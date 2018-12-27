<?php

namespace app\modules\admin\controllers;
  
use app\modules\admin\controllers\common\BaseAdminController;
use app\common\services\ConstantMapService;
use app\models\member\MemberExtra;
use app\common\services\DataHelper;
use app\models\role\RoleExtra;
use app\common\services\UtilService;
use app\common\services\UrlService;
use app\models\member\MemberComments;
use app\models\role\UserRole;

class MemberController extends BaseAdminController
{
    //會員列表
    public function actionIndex()
    {
        $mix_kw = trim( $this->get("mix_kw","" ) );
        $status = intval( $this->get("status",ConstantMapService::$status_default ) );
        $p = intval( $this->get("p",1) );
        $p = ( $p > 0 )?$p:1;
        
        $query = MemberExtra::find();
        //混合查询
        if( $mix_kw ){
            $where_nickname = [ 'LIKE','nickname','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $where_mobile = [ 'LIKE','mobile','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $query->andWhere([ 'OR',$where_nickname,$where_mobile ]);
        }
        
        if( $status > ConstantMapService::$status_default ){
            $query->andWhere([ 'status' => $status ]);
        }
        
        
        //分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
        //60,60 ~ 11,10 - 1
        $total_res_count = $query->count();
        $total_page = ceil( $total_res_count / $this->page_size );
        
        $list = $query->orderBy([ 'id' => SORT_DESC ])
        ->offset( ( $p - 1 ) * $this->page_size )
        ->limit($this->page_size)
        ->all( );
        
        $data = [];
        
        //关联查询
        $member_mapping = DataHelper::getDicByRelateID($list, RoleExtra::className(), "role_id",'id', ['name']);
      
        if( $list ){
            foreach( $list as $_item ){
                $role = isset($member_mapping[$_item['role_id']])?$member_mapping[$_item['role_id']]:null;
             
                $data[] = [
                    'id' => $_item['id'],
                    'role'=>$role,
                    'expired_time'=>$_item['expired_time'],
                    'nickname' => UtilService::encode( $_item['nickname'] ),
                    'mobile' => UtilService::encode( $_item['mobile'] ),
                    'sex_desc' => ConstantMapService::$sex_mapping[ $_item['sex'] ],
                    'avatar' => UrlService::buildPicUrl( "avatar",$_item['avatar'] ),
                    'status_desc' => ConstantMapService::$status_mapping[ $_item['status'] ],
                    'status' => $_item['status'],
                    'updated_time'=>$_item['updated_time']
                ];
            }
        } 
        return $this->render('index',[
            'list' => $data,
            'search_conditions' => [
                'mix_kw' => $mix_kw,
                'p' => $p,
                'status' => $status
            ],
            'status_mapping' => ConstantMapService::$status_mapping,
            'pages' => [
                'total_count' => $total_res_count,
                'page_size' => $this->page_size,
                'total_page' => $total_page,
                'p' => $p
            ],
           
        ]);      
        
    }
    
    //會員詳情
    public function actionInfo(){
        $id = intval( $this->get("id", 0) );
        $reback_url = UrlService::buildAdminUrl("/member/index");
        if( !$id ){
            return $this->redirect( $reback_url );
        }
        
        $info = MemberExtra::find()->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->redirect( $reback_url );
        }
        
        // $comments_list = MemberComments::find()->where([ 'member_id' => $id ])->orderBy([ 'id' => SORT_DESC ])->all();
        
        
        return $this->render("info",[
            "info" => $info,
            
           // 'comments_list' => $comments_list // $comments_list
        ]);        
      
    }
    //添加或者編輯會員
    public function actionSet(){
        if( \Yii::$app->request->isGet ) {
            $id = intval( $this->get("id", 0) );
            $info = [];
            if( $id ){
                $info = MemberExtra::find()->where([ 'id' => $id ])->one();
            }
            
           
            return $this->render('set',[
                'info' => $info,
               
            ]);
        }
        
        $id = intval( $this->post("id",0) );
        $nickname = trim( $this->post("nickname","") );
        $mobile = floatval( $this->post("mobile",0) );
        $date_now = date("Y-m-d H:i:s");
       
        $expired_time = trim($this->post("expired_time"),"");
        
        $beizhu = trim($this->post("beizhu",""));
       
        if( mb_strlen( $nickname,"utf-8" ) < 1 ){
            return $this->renderJSON([],"请输入符合规范的姓名~~",-1);
        }
        
        if( mb_strlen( $mobile,"utf-8" ) < 1   ){
            return $this->renderJSON([],"请输入符合规范的手机号码~~",-1);
        }        
        
        $info = [];
        if( $id ){
            $info = MemberExtra::findOne(['id' => $id]);
        }
        if( $info ){
            $model_member = $info;
        }else{
            $model_member = new MemberExtra();
            $model_member->status = 1;
            $model_member->avatar = ConstantMapService::$default_avatar;
            $model_member->created_time = $date_now;
        }
        //设置试用时间
        $model_member->expired_time = $expired_time;
        //添加试用记录
         
        
        $model_member->nickname = $nickname;
        $model_member->mobile = $mobile;
        $model_member->updated_time = $date_now;
        $model_member->save( 0 );
        return $this->renderJSON([],"操作成功~~");       
        
    }
    //会员评论列表
    public function actionComment(){
 
        return $this->render('comment');
    }
    //删除、恢复操作
    public function actionOps(){
        if( !\Yii::$app->request->isPost ){
            return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
        }
    
        $id = $this->post('id',[]);
        $act = trim($this->post('act',''));
        if( !$id ){
            return $this->renderJSON([],"请选择要操作的会员账号号~~",-1);
        }
    
        if( !in_array( $act,['remove','recover' ])){
            return $this->renderJSON([],"操作有误，请重试~~",-1);
        }
    
        $info = MemberExtra::find()->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->renderJSON([],"指定会员账号不存在~~",-1);
        }
    
        switch ( $act ){
            case "remove":
                $info->status = 0;
                break;
            case "recover":
                $info->status = 1;
                break;
        }
        $info->updated_time = date("Y-m-d H:i:s");
        $info->update( 0 );
        return $this->renderJSON( [],"操作成功~~" );
    }
   
    
    /**
     * 设置用户的角色
     *  这里注意，我们一般只给前台用户一个角色！！
     */
    public function actionSetrole(){
        if(\Yii::$app->request->isGet){
            $uid = intval($this->get('id',0));
            $info =[];
            if($uid){
                $info = MemberExtra::find()->where(['id'=>$uid])->one();
            }
            //取出所有的角色
            $role_list = RoleExtra::find()->orderBy( [ 'cate'=>SORT_ASC,'pos' => SORT_DESC ])->all();
            //取出所有的已分配角色
            $user_role_list = UserRole::find()->where([ 'uid' => $uid,'cate'=>1 ])->asArray()->all();
            $related_role_ids = array_column($user_role_list,"role_id");
            return $this->render('setrole',[
                'info'=>$info,
                'role_list'=>$role_list,
                'related_role_ids'=>$related_role_ids
            ]);
             
        }
    
        $uid = intval($this->post('id',0));
        $role_ids = $this->post('role_ids',[]);
        $date_now = date("Y-m-d H:i:s");
        
        $info = MemberExtra::find()->where([ 'id' => $uid ])->one();
       
        if( !$info ){
            //不存在就是非法访问
            return $this->renderJson([],"系统繁忙，请稍后再试~~",-1);
        }
        //如果只有一个角色就更新到用户表
        if(sizeof($role_ids) ==1){
            $info->role_id = $role_ids[0];
        }        
        $info->updated_time = date("Y-m-d H:i:s");
        if( $info->save(0) ){//如果用户信息保存成功，接下来保存用户和角色之间的关系
            /**
             * 找出删除的角色
             * 假如已有的角色集合是A，界面传递过得角色集合是B
             * 角色集合A当中的某个角色不在角色集合B当中，就应该删除
             * array_diff();计算补集
             */
            $user_role_list = UserRole::find()->where([ 'uid' => $info->id,'cate'=>1 ])->all();
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
                        $model_user_role->uid = $info->id;
                        $model_user_role->role_id = $_role_id;
                        $model_user_role->created_time = $date_now;
                        $model_user_role->cate = 1;
                        $model_user_role->save(0);
                    }
                }
            }
        }
        return $this->renderJSON([],'操作成功~~');
    }
    
   }
