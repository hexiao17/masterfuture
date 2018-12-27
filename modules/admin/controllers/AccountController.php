<?php

namespace app\modules\admin\controllers; 
use app\modules\admin\controllers\common\BaseAdminController;
use app\models\User;
use app\common\services\ConstantMapService;
use app\common\services\UrlService;
use app\models\AppAccessLog;
use app\models\role\Role;
use app\models\role\UserRole;

/***
 * 账号控制器
 * Class AccountController
 * @package app\modules\admin\controllers
 */
class AccountController extends BaseAdminController
{
 

    //账号列表
     public function actionIndex(){

         $status = intval($this->get("status",ConstantMapService::$status_default));
         $mix_kw = trim( $this->get("mix_kw",""));
         $p = intval($this->get("p",1));
         
         $query =User::find();
         if($status  > ConstantMapService::$status_default){
             $query->andWhere(['status'=>$status]);
         }         
         if($mix_kw){
             $where_nickname = ['LIKE','nickname','%'.$mix_kw.'%',false];
             $where_mobile = ['LIKE','mobile','%'.$mix_kw.'%',false];
             $query->andWhere(['OR',$where_nickname,$where_mobile]);
         }
         //分页功能，需要2个参数：1、符合条件的总记录数量；2、每页展示的数量
         $page_size = 20;
         $total_res_count = $query->count();
         $total_page= ceil( $total_res_count/$page_size);
         
         
         $users =$query->orderBy(['uid'=>SORT_ASC])
                        ->offset(($p-1)*$page_size)
                        ->limit($page_size)
                        ->all();         
          
         return $this->render('index',[
             "users" => $users,
             "status_mapping"=>ConstantMapService::$status_mapping,
             'search_condition'=>[
                 'mix_kw'=>$mix_kw,
                 'status'=>$status
             ],
             'pages'=>[
                 'total_count'=>$total_res_count,
                 'page_size' =>$page_size,
                 'total_page'=>$total_page,
                 'p'=>$p
             ]
         ]);

     }
    //账号编辑或添加
    public function actionSet(){
    
        if(\Yii::$app->request->isGet){
            $id = intval($this->get("id",0));
            $info = [];
            if($id){
                $info  = User::find()->where(['uid'=>$id])->one();
            }            
            
            return $this->render('set',[
                'info'=>$info,
            ]);
        }
        $id = intval($this->post('id',0));
        $nickname = trim($this->post('nickname',""));
        $mobile = trim($this->post('mobile',""));
        $email = trim($this->post('email',""));
        $login_name = trim($this->post('login_name',""));
        $login_pwd = trim($this->post('login_pwd',""));
        $date_now = date('Y-m-d H:i:s');
        if(mb_strlen($nickname,"utf-8")<1){
            return $this->renderJson([],"请输入合规的姓名~~",-1);
        }
        if(mb_strlen($mobile,"utf-8")<1){
            return $this->renderJson([],"请输入合规的手机号码~~",-1);
        }
        if(mb_strlen($email,"utf-8")<1){
            return $this->renderJson([],"请输入合规的邮箱~~",-1);
        }
        if(mb_strlen($login_name,"utf-8")<1){
            return $this->renderJson([],"请输入合规的登录名~~",-1);
        }
        if(mb_strlen($login_pwd,"utf-8")<1){
            return $this->renderJson([],"请输入合规的密码~~",-1);
        }
        $has_in = User::find()->where(['login_name'=>$login_name])->andWhere(['!=','uid',$id])->count();
        if($has_in){
            return $this->renderJson([],"用户名已存在，请重新输入~~",-1);
        }
        
        $info = User::find()->where(['uid'=>$id])->one();
        if($info){//编辑
                $new_user = $info;
        }else {//添加
            $new_user = new User();
            $new_user->setSalt();
            $new_user->created_time = $date_now;
        }
        //公共部分              
        $new_user->nickname = $nickname;
        $new_user->mobile = $mobile;
        $new_user->email = $email;
        $new_user->avatar = ConstantMapService::$default_avatar;
        $new_user->login_name = $login_name;  
        //用户修改了密码
        if($login_pwd != ConstantMapService::$default_password){
            $new_user->setPassword($login_pwd);
        }          
        $new_user->updated_time = $date_now;
        
        $new_user->save( 0 );
        
        $this->renderJson([],"操作成功~~");
        
      
    }
    /**
     * 设置用户的角色
     */
    public function actionSetrole(){
        if(\Yii::$app->request->isGet){
           $uid = intval($this->get('uid',0));
           $info =[];
           if($uid){
               $info = User::find()->where(['uid'=>$uid])->one();               
           }
           //取出所有的角色           
           $role_list = Role::find()->orderBy( [ 'cate'=>SORT_ASC,'pos' => SORT_DESC ])->all();
           //取出所有的已分配角色           
           $user_role_list = UserRole::find()->where([ 'uid' => $uid ,'cate'=>2])->asArray()->all();           
           $related_role_ids = array_column($user_role_list,"role_id");
           return $this->render('setrole',[
               'info'=>$info,
               'role_list'=>$role_list,
               'related_role_ids'=>$related_role_ids
           ]);
           
        }
        
        $uid = intval($this->post('uid',0));
        $role_ids = $this->post('role_ids',[]);
        $date_now = date("Y-m-d H:i:s");
        $info = User::find()->where([ 'uid' => $uid ])->one();
        if( !$info ){ 
         //不存在就是非法访问
            return $this->renderJson([],"系统繁忙，请稍后再试~~",-1);
        }
        $info->updated_time = date("Y-m-d H:i:s");
        if( $info->save(0) ){//如果用户信息保存成功，接下来保存用户和角色之间的关系
            /**
             * 找出删除的角色
             * 假如已有的角色集合是A，界面传递过得角色集合是B
             * 角色集合A当中的某个角色不在角色集合B当中，就应该删除
             * array_diff();计算补集
             */
            $user_role_list = UserRole::find()->where([ 'uid' => $info->uid,'cate'=>2 ])->all();
            $related_role_ids = [];
            if( $user_role_list ){
                foreach( $user_role_list as $_item ){
                    $related_role_ids[] = $_item['role_id'];
                    if( !in_array( $_item['role_id'],$role_ids ) ){
                        $_item->delete();
                    }
                }
            }
            
            /**            
            * 找出添加的角色            
            * 假如已有的角色集合是A，界面传递过得角色集合是B            
            * 角色集合B当中的某个角色不在角色集合A当中，就应该添加            
            */            
            if ( $role_ids ){
                foreach( $role_ids as $_role_id ){
                    if( !in_array( $_role_id ,$related_role_ids ) ){
                        $model_user_role = new UserRole();
                        $model_user_role->uid = $info->uid;
                        $model_user_role->role_id = $_role_id;
                        $model_user_role->created_time = $date_now;
                        $model_user_role->cate = 2;
                        $model_user_role->save(0);
                    }
                }
            }       
        }
        return $this->renderJSON([],'操作成功~~');
    }
    //账号详情
    public function actionInfo(){
        $id = intval($this->get('id',0));
        $reback_url = UrlService::buildAdminUrl('/account/index');        
        if(!$id){
            $this->redirect($reback_url);
        }
        $info = User::find()->where(['uid'=>$id])->one();
        if(!$info){
            $this->redirect($reback_url);
        }

        //访问记录
        $accesslist = AppAccessLog::find()->where(['uid'=>$info['uid']])->orderBy(['id'=>SORT_DESC])->limit(10)->all();
        
        return $this->render('info',[
            'info'=>$info,
            'accesslist'=>$accesslist
        ]);
    }

    //操作方法
    public function actionOps(){
        if(!\Yii::$app->request->isPost){
            return $this->renderJson([],"系统繁忙，请稍后再试~~",-1);
        }
        
        $uid = intval($this->post('uid',0));
        $act = trim( $this->post("act",""));
        
        if(!$uid){
            return $this->renderJson([],"请选择要操作的账号~~",-1);
        }
        if(!in_array($act, ["remove","recover"])){
            return $this->renderJson([],"操作有误，请重试~~",-1);
        }
        $user_info = User::find()->where(['uid'=>$uid])->one();
        if(!$user_info){
            return $this->renderJson([],"你指定的账号不存在~~",-1);
        }
        switch ($act){
            case "remove":
                $user_info->status =0;
                break;
            case "recover":
                $user_info->status = 1;
                break;
        }
        $user_info->updated_time = date("Y-m-d H:i:s");
        $user_info->update(0);
        
        return $this->renderJson([],"操作成功~~"); 
    }
}
