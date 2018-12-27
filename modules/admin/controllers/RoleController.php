<?php
namespace app\modules\admin\controllers;

use app\modules\admin\controllers\common\BaseAdminController; 
use app\common\services\ConstantMapService;
use app\common\services\UrlService;
use app\models\role\Role;
use app\models\role\Access;
use app\models\role\RoleAccess;

/**
 * 角色
 * 
 * @author Administrator
 *        
 */
class RoleController extends BaseAdminController
{

    public function actionIndex()
    {
        $status = intval($this->get("status", ConstantMapService::$status_default));
        $query = Role::find();
        
        if ($status > ConstantMapService::$status_default) {
            $query->andWhere([
                'status' => $status
            ]);
        }
        $query->orderBy(['cate'=>SORT_ASC,'pos'=>SORT_DESC]);
        $roles = $query->all();
        
        return $this->render('index', [
            'list' => $roles,
            
            'search_conditions' => [
                
                'status' => $status
            ],
            'status_mapping' => ConstantMapService::$status_mapping
        ]);
    }

    public function actionInfo()
    {
        
        $id = intval( $this->get("id", 0) );
        $reback_url = UrlService::buildAdminUrl("/role/index");
        if( !$id ){
            return $this->redirect( $reback_url );
        }
        
        $info = Role::find()->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->redirect( $reback_url );
        }
        
        //$pay_order_list = PayOrder::find()->where([ 'member_id' => $id,'status' => [ -8,1 ] ])->orderBy([ 'id' => SORT_DESC ])->all();
        //$comments_list = MemberComments::find()->where([ 'member_id' => $id ])->orderBy([ 'id' => SORT_DESC ])->all();
        
        
        return $this->render("info",[
            "info" => $info,
            //"pay_order_list" =>  null,//$pay_order_list,
            //'comments_list' => null // $comments_list
        ]);
    }

    public function actionSet()
    {
        if (\Yii::$app->request->isGet) {
            $id = intval($this->get("id", 0));
            $info = [];
            if ($id) {
                $info = Role::find()->where([
                    'id' => $id
                ])->one();
            }
            
            return $this->render('set', [
                'info' => $info
            ]);
        }
        
        $id = intval($this->post("id", 0));
        $role_name = trim($this->post("name", ""));      
        $role_level = trim($this->post('pos', ''));      
        $valid_days = intval($this->post('valid_days', 0));
        $cate = intval($this->post('cate',0));
        
        $date_now = date('Y-m-d H:i:s');
        if (mb_strlen($role_name, "utf-8") < 1) {
            return $this->renderJSON([], "请输入符合规范的角色名~~", - 1);
        }
        if($valid_days <=0 && $valid_days >3650){
            return $this->renderJSON([], "请输入符合规范的有效期[大于1并且小于3650]~~", - 1);
        } 
        if ($role_level < 1) {
            return $this->renderJSON([], "请输入符合规范的角色等级~~", - 1);
        }     
        if ($cate < 1) {
            return $this->renderJSON([], "请选择角色类型~~", - 1);
        }
        $info = [];
        if ($id) {
            $info = Role::findOne([
                'id' => $id
            ]);
        }
        if ($info) {//修改
            $model_role = $info;
        } else { //添加
            //先查下名称是否已存在
            $tmp_model = Role::find()->where(['name'=>$role_name])->one();
            if($tmp_model){
                return $this->renderJSON([], "你输入的角色已经存在，请修改角色名", - 1);
            }
            $model_role = new Role();
            $model_role->status = 1;
            $model_role->created_time = $date_now;
        }
        
        $model_role->name = $role_name;
        $model_role->pos = $role_level;    
        $model_role->valid_days = $valid_days;
        $model_role->updated_time = $date_now;
        $model_role->cate = $cate;
        $model_role->save(0);
        return $this->renderJSON([], "操作成功~~");
    }

    public function actionOps()
    {
        if (! \Yii::$app->request->isPost) {
            return $this->renderJSON([], ConstantMapService::$default_syserror, - 1);
        }
        
        $id = $this->post('id', []);
        $act = trim($this->post('act', ''));
        if (! $id) {
            return $this->renderJSON([], "请选择要操作的会员账号号~~", - 1);
        }
        
        if (! in_array($act, [
            'remove',
            'recover'
        ])) {
            return $this->renderJSON([], "操作有误，请重试~~", - 1);
        }
        
        $info = Role::find()->where([
            'id' => $id
        ])->one();
        if (! $info) {
            return $this->renderJSON([], "指定会员账号不存在~~", - 1);
        }
        
        switch ($act) {
            case "remove":
                $info->status = 0;
                break;
            case "recover":
                $info->status = 1;
                break;
        }
        $info->updated_time = date("Y-m-d H:i:s");
        $info->update(0);
        return $this->renderJSON([], "操作成功~~");
    }
    
    
    /**
     * 设置角色和权限的关系逻辑
     */
    public function actionAccess(){
        //http get 请求 展示页面
        if( \Yii::$app->request->isGet ){
            $id = $this->get("id",0);
            $reback_url =  UrlService::buildAdminUrl("/role/index");
            if( !$id ){
                return $this->redirect( $reback_url );
            }
            $info = Role::find()->where([ 'id' => $id ])->one();
            if( !$info ){
                return $this->redirect( $reback_url );
            }
    
            //取出所有的权限
            $access_list = Access::find()->where([ 'status' => 1 ])->orderBy( [ 'id' => SORT_DESC ])->all();
    
            //取出所有已分配的权限
            $role_access_list = RoleAccess::find()->where([ 'role_id' => $id ])->asArray()->all();
            $access_ids = array_column( $role_access_list,"access_id" );
            return $this->render("access",[
                "info" => $info,
                'access_list' => $access_list,
                "access_ids" => $access_ids
            ]);
        }
        //实现保存选中权限的逻辑
        $id = $this->post("id",0);
        $access_ids = $this->post("access_ids",[]);
    
        if( !$id ){
            return $this->renderJSON([],"您指定的角色不存在",-1);
        }
    
        $info = Role::find()->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->renderJSON([],"您指定的角色不存在",-1);
        }
    
        //取出所有已分配给指定角色的权限
        $role_access_list = RoleAccess::find()->where([ 'role_id' => $id ])->asArray()->all();
        $assign_access_ids = array_column( $role_access_list,'access_id' );
        /**
         * 找出删除的权限
         * 假如已有的权限集合是A，界面传递过得权限集合是B
         * 权限集合A当中的某个权限不在权限集合B当中，就应该删除
         * 使用 array_diff() 计算补集
         */
        $delete_access_ids = array_diff( $assign_access_ids,$access_ids );
        if( $delete_access_ids ){
            RoleAccess::deleteAll([ 'role_id' => $id,'access_id' => $delete_access_ids ]);
        }
    
        /**
         * 找出添加的权限
         * 假如已有的权限集合是A，界面传递过得权限集合是B
         * 权限集合B当中的某个权限不在权限集合A当中，就应该添加
         * 使用 array_diff() 计算补集
         */
        $new_access_ids = array_diff( $access_ids,$assign_access_ids );
        if( $new_access_ids ){
            foreach( $new_access_ids as $_access_id  ){
                $tmp_model_role_access = new RoleAccess();
                $tmp_model_role_access->role_id = $id;
                $tmp_model_role_access->access_id = $_access_id;
                $tmp_model_role_access->created_time = date("Y-m-d H:i:s");
                $tmp_model_role_access->save( 0 );
            }
        }
        return $this->renderJSON([],"操作成功~~",200 );
    }
}

