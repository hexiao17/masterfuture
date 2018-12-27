<?php
namespace app\modules\admin\controllers\common;

use app\common\services\UrlService;
use app\common\services\applog\AppLogService;
use app\common\components\BaseWebController;
use app\models\role\UserRole;
use app\models\role\RoleAccess;
use app\models\role\Access; 
 
use app\models\member\MemberExtra;
//admin的统一控制器
// 1、指定统一的布局文件
// 2、登录验证
class BaseAdminController extends BaseWebController
{
    protected $page_size = 20;
    //cookie名称
    protected $auth_cookie_name = "mooc_book";
    
    public  $current_user = NULL;
    //已发布
    public $tmpData_PUBLISHED= 3;
    
    public $privilege_urls = [];//保存去的权限链接
    /**
     * 已删除
     * @var  
     */
    public  $tmpData_REMOVE = -1;
    /**
     * 不需要登陆的页面
     * @var  
     */
    public   $allowAllAction = [
         "admin/user/login",
         
    ];
    /**
     *  无需权限访问的url 
     * @var  
     */
    public $ignore_url = [
        'error/forbidden' ,      
        'admin/user/login',
        'admin/user/logout',
        "admin/weixin/index",        
    ];
    
    //1
    public function __construct($id, $module){
        parent::__construct($id, $module);
        $this->layout = 'main';
    }
    
    /**
     * 统一登录验证，使用beforeAction|每个页面都拦截调用
     * $action->getUniqueId()  =>admin/user/login
     */
    public function  beforeAction($action){
        
        //
        
        
        //验证是否登录
       $login_statu =  $this->checkLoginStatus();
       
       return true;
        //如果没有登陆并且访问了需要登陆的页面！那么就提示登陆
       if(!$login_statu && !in_array($action->getUniqueId(), $this->allowAllAction)){
          
         if(\Yii::$app->request->isAjax){
                 $this->renderJson([],"未登录，请先登录",-302);
             }else{
                 $this->redirect(UrlService::buildAdminUrl("/user/login"));
             }
             return false;
       }
       //保存所有的访问到数据库当中 
        //记录用户的访问日志
        AppLogService::addAccessLog($this->current_user['uid']);
        /**
         * 判断权限的逻辑是
         * 取出当前登录用户的所属角色，
         * 在通过角色 取出 所属 权限关系
         * 在权限表中取出所有的权限链接
         * 判断当前访问的链接 是否在 所拥有的权限列表中
         */
        //判断当前访问的链接 是否在 所拥有的权限列表中      
        if( !$this->checkPrivilege( $action->getUniqueId() ) ){           
            $this->redirect( UrlService::buildWWWUrl( "/error/forbidden" ) );
            return false;
        }         
        return true; 
    }
    
    //检查是否有访问指定链接的权限
    public function checkPrivilege( $url ){
        //如果是超级管理员 也不需要权限判断
        if( $this->current_user && $this->current_user['is_admin'] ){
            return true;
        }
    
        //有一些页面是不需要进行权限判断的
        if( in_array( $url,$this->ignore_url ) ){          
            return true;
        }
    
        return in_array( $url, $this->getRolePrivilege( ) );
    }
    
    
    /*
     * 获取某用户的所有权限
     * 取出指定用户的所属角色，
     * 在通过角色 取出 所属 权限关系
     * 在权限表中取出所有的权限链接
     */
    public function getRolePrivilege($uid = 0){
        if( !$uid && $this->current_user ){
            $uid = $this->current_user->uid;
        }
    
        if( !$this->privilege_urls ){
            $role_ids = UserRole::find()->where([ 'uid' => $uid ])->select('role_id')->asArray()->column();
            if( $role_ids ){
                //在通过角色 取出 所属 权限关系
                $access_ids = RoleAccess::find()->where([ 'role_id' =>  $role_ids ])->select('access_id')->asArray()->column();
                //在权限表中取出所有的权限链接
                $list = Access::find()->where([ 'id' => $access_ids ])->all();
                if( $list ){
                    foreach( $list as $_item  ){
                        $tmp_urls = @json_decode(  $_item['urls'],true );
                        $this->privilege_urls = array_merge( $this->privilege_urls,$tmp_urls );
                    }
                }
            }
        }
        return $this->privilege_urls ;
    }
    
    /**
     * 验证当前登录态是否有效
     */
    public function checkLoginStatus(){
        $auth_cookie = $this->getCookie($this->auth_cookie_name, "");
        if(!$auth_cookie){
            return false;
        }
        
        list($auth_token,$uid) = explode("#", $auth_cookie);
        if(!$auth_token || !$uid){
            return false;
        }
        
        if(!preg_match("/^\d+$/", $uid)){
            return false;
        }
        $user_info = MemberExtra::find()->where(["id"=>$uid])->one();
        if(!$user_info){
            return false;
        }
        
        //验证加密字符串
        if($auth_token != $this->geneAuthToken($user_info)){
            return false;
        }
        
        $this->current_user = $user_info; 
        //给所有的视图页面传递参数
        \Yii::$app->view->params['current_user'] = $user_info;
        return true;
        
    }
    
    //设置登录态的方法
    public function setLoginStatus($user_info){
        $auth_token = $this->geneAuthToken($user_info);
        $this->setCookie($this->auth_cookie_name, $auth_token."#".$user_info["id"]);
    }    
    
    //移除登录态的方法
    public function removeLoginStatus(){
        $this->removeCookie($this->auth_cookie_name);
    }
    
    //统一生产md5加密，加密字符串= md5(login_name +login_pwd + login_salt)
    public function geneAuthToken($user_info){
        return md5($user_info["mobile"].$user_info["login_pwd"].$user_info["salt"]);
    }
}

