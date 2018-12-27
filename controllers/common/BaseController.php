<?php
namespace app\controllers\common;

use app\common\components\BaseWebController;
 
use app\common\services\UrlService;
use app\common\services\UtilService; 
 
use app\models\member\OauthMemberBind;
use app\common\services\ConstantMapService;
use app\common\services\applog\AppLogService;
use app\models\role\Role;
use app\models\role\UserRole;
use app\models\role\RoleAccess;
use app\models\role\Access;
use app\models\member\MemberExtra;
 

class BaseController extends BaseWebController
{
    
    protected $auth_cookie_current_openid = "masterfuture_m_openid";
	protected  $auth_cookie_name = "masterfuture_user_loginxxx";
	protected  $salt = "dm3HsNYz3Uyddd46Rjg";
	protected $current_user = null;
	protected  $current_user_role=null;
	protected $page_size =20;
	protected $m_page_size =10;
	 
	/**是否是微信端*/
	protected  $isWechat =FALSE;
	
	public $privilege_urls = [];//保存去的权限链接
	
	/*这部分永远不用登录*/
	protected $allowAllAction = [
		'front/oauth/login',
		'front/oauth/logout',
		'front/oauth/callback',
	    'front/user/login',
	    'front/user/reg',
		'front/user/bind',
	    'front/user/invitate',//这里的post请求需要登录,get不需要		
	    'front/default/index',
	    'front/default/shared',
	    'front/default/noaccess',
	    'front/pay/callback',
	    'front/equipment/index',
	    'front/equipment/info'
	    //以下部分要进行角色验证
// 	    'web/stnews/index',
// 	    'web/stnews/info',
// 	    'web/zbnews/index',
// 	    'web/zbnews/info'
	   
	];

	/**
	 * 基础会员登陆之后就拥护有的权限
	 * @var  
	 */
	public $logined_AllowAction=[
	   
	    'front/user/index', 
	    'front/user/set', 
	    'front/user/home', 
	    'front/user/cate', 
	    'front/user/logout', 
	    'front/task/index',
	    'front/task/set',
	    'front/task/info',
	    'front/task/ops',
	    'front/task/ajaxbody',
	    'front/share/one', 
	    'front/share/index', 
	    'front/share/info', 
	    'front/share/getpwd', 
	    'front/share/accesspwd', 
	    'front/summary/index', 
	    'front/summary/set', 
	    'front/summary/info',  
	    'front/fav/ops',  
	    'front/sharereply/ops',  
	    'front/sharereply/set',  
	    
	    //'m/user/invitate',
	    //产品部分
// 	    'web/product/cart',
// 	    'web/product/fav',
// 	    'web/product/order',
// 	    'web/pay/buy',
// 	    'web/pay/callback',
// 	    'web/pay/prepare',
// 	    'web/order/ops',
	];
	
	public function __construct($id, $module, $config = []){
		parent::__construct($id, $module, $config = []);
		if(UtilService::isWechat() ||  $this->module->id =="m"){
		    $this->layout = "minimain";
		    $this->isWechat = true;
		}else {
		    //注意这里的写法		       
		    if (in_array($this->getUniqueId(),['front/share'])){
		        $this->layout = "share_index";
		    }elseif (in_array($this->getUniqueId(),['front/user','front/task','front/summary'])){
		        $this->layout = "user_index";
		    
		    }else{
		        $this->layout = "main";
		     
		    }
		    
		} 
        
		//把分享信息加入试图层
		\Yii::$app->view->params['share_info'] = json_encode( [
			'title' => \Yii::$app->params['title'].',油田招标商谈信息聚合平台,你的生意来了~免费试用',
			'desc' => \Yii::$app->params['title'].'->招标，商谈信息全都有！',
			'img_url' => UrlService::buildWwwUrl("/images/common/qrcode.jpg"),
		] ); 		
	}

	/**
	 *     判断是普通用户自己的主题
	 *     用户自己，或者创始人都是true
 
	 */
	public function IsUserOfObject($model){ 
	    if ($this->current_user->id == $model->user_id ||$this->current_user->id  ==1) {//自己的帖子	            
	            return true;
	    } else{
	        return false;
	    }
	  
	}
	
	public function beforeAction( $action ){
	    
		$this->setMenu();
        //1、始终允许访问的页面，直接通过
		if ( in_array($action->getUniqueId(), $this->allowAllAction ) ) {		   
			return true;
		}
		//2、检查登录态，如果已经登录，直接通过
		$login_status = $this->checkLoginStatus();	
		
		//！！记录日志的话，会影响速度，越来越慢
		AppLogService::addAccessLog($this->current_user['id']);
		//3、登录态验证不成功，也可能是cookie过期，微信不用重新登录的。		
		if( !$login_status ){     
			if( \Yii::$app->request->isAjax ){//ajax请求就ajax 返回
				$this->renderJSON([],"未登录,系统将引导您重新登录~~",302);
				return false;
			}else{			  
			   //1、系统级权限
				$redirect_url = UrlService::buildFrontUrl( "/user/bind" );
				//3.1 如果是微信访问
				if(UtilService::isWechat() ){
				    //取得openid
					$openid = $this->getCookie( $this->auth_cookie_current_openid ); 
					if( $openid ){//存在openid，只表示微信访问过oauth/login页面
					    //这里要注意了，有openid,也可能没有注册,所以这里要查询绑定记录
					    $reg_bind = OauthMemberBind::find()->where([ 'openid' => $openid,'type' => ConstantMapService::$client_type_wechat ])->one();
					   
                        //没有绑定先绑定
                        if(!$reg_bind){
                            $this->redirect( UrlService::buildFrontUrl( "/user/bind" ) );
                             return false;
                        }	
                        //***验证登录成功***
                        //继续
                      					
					}else{
					    //申请微信登陆授权
					    $redirect_url = UrlService::buildFrontUrl( "/oauth/login" );
					}
				}
			    //3.2 如果是其他浏览器，那么直接跳转到登录
				else{
				    $this->redirect( UrlService::buildFrontUrl( "/user/login" ) ); 
				    
				    return false;
				}					
				$this->redirect( $redirect_url );
			}
			
		} 
		  //////登录成功之后的角色权限////////
		    //登陆了之后判断
		    //2、个人权限
		    //初始化用户角色信息
		    $role_status = $this->checkUserRole($this->current_user);
		    //登陆了，判断是否有基础权限，直接允许
		    if(in_array($action->getUniqueId(), $this->logined_AllowAction)){
		        return true;
		    }		       	    
		    //已登陆了,判断是否过期
		    if(!$role_status){
		        //角色已过期
		        $this->redirect(UrlService::buildFrontUrl("/default/noaccess",[
		            'msg'=>'你没有购买会员或者会员已过期~,请先购买会员！',
		            'tourl'=>UrlService::buildFrontUrl('/product/index'),
		        ]));
		        return false;
		    }
		   
		    
		    ////判断当前访问的链接 是否在 所拥有的权限列表中
		    if( $this->checkPrivilege( $action->getUniqueId() )){//有查看权限
		        return true;
		    }else{//无查看权限		       
		        //跳转到无权限提示页面，之后自动跳转到购买页面		       
		        $this->redirect(UrlService::buildFrontUrl("/default/noaccess",[
		            'msg'=>'你无权访问此页面,请先购买会员！',
		            'tourl'=>UrlService::buildFrontUrl('/product/index'),
		        ])); 
		       return false;		       
		    }	 		 
	}
	
	//检查是否有访问指定链接的权限
	public function checkPrivilege( $url ){
	    //如果是创始人，即拥有所有权限	    
	    if($this->current_user['id'] == 1){
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
	        $uid = $this->current_user->id;
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
     * 检查用户的角色(角色存在)
     * 检查角色有效期！
     */
	protected function checkUserRole($user){
	    $role = Role::find()->where(['id'=>$user['role_id']])->one();
	    if(!$role){
	        return false;
	    }
	    
	    $this->current_user_role = $role;

	    \Yii::$app->view->params['current_user_role'] = $role;
	    
	    //检查会员角色有效期期
	    if( strtotime($user['expired_time'])<time()){	        
	        return false;
	    }	    
	    return true;
	}
	protected function checkLoginStatus(){

		$auth_cookie = $this->getCookie( $this->auth_cookie_name );
        
		if( !$auth_cookie ){
			return false;
		}
		list($auth_token,$member_id) = explode("#",$auth_cookie);
		if( !$auth_token || !$member_id ){
			return false;
		}
		//验证cookie 中的token是否正确
		if( $member_id && preg_match("/^\d+$/",$member_id) ){
			$member_info = MemberExtra::findOne([ 'id' => $member_id,'status' => 1 ]);
			if( !$member_info ){
			    
				$this->removeLoginStatus(); 
				return false;
			}
			if( $auth_token != $this->geneAuthToken( $member_info ) ){
				$this->removeLoginStatus(); 
				return false;
			}
			$this->current_user = $member_info;
			\Yii::$app->view->params['current_user'] = $member_info;
			return true;
		}
		return false;
	}
    /**
     * 统一设置用户的登陆信息
     * @param   $user_info
    
     */
	public function setLoginStatus( $user_info ){
		$auth_token = $this->geneAuthToken( $user_info );		
		
		$this->setCookie($this->auth_cookie_name,$auth_token."#".$user_info['id']);
	}

	protected  function removeLoginStatus(){
		$this->removeCookie($this->auth_cookie_name);
	}

	public function geneAuthToken( $member_info ){
		return md5( $this->salt."-{$member_info['id']}-{$member_info['mobile']}-{$member_info['salt']}");
	}
     
	/**
	 * 设置在产品信息页面隐藏 菜单
	 */
	protected function setMenu(){

		$menu_hide = false;
		$url = \Yii::$app->request->getPathInfo();
		if( stripos($url,"product/info") !== false ){
			$menu_hide = true;
		}

		\Yii::$app->view->params['menu_hide'] = $menu_hide;
	}

	public function goHome(){
	    return $this->redirect( UrlService::buildWWWUrl( "/default/index" ) );
	}
    
}

