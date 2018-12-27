<?php
namespace app\modules\m\controllers;


use app\common\services\UrlService;
use app\common\components\HttpClient;
use app\models\member\OauthMemberBind;
use app\models\member\Member;
use app\common\services\ConstantMapService;
use app\common\services\QueueListService;
 
use app\modules\m\controllers\common\BaseMController;
/**
 * 如果用户在微信客户端中访问第三方网页，公众号可以通过微信网页授权机制，来获取用户基本信息，进而实现业务逻辑。
 * @author Administrator
 *
 */
class OauthController extends BaseMController
{
    /**
     * http://gupingkuapp.ngrok.cc/web/oauth/login?scope=snsapi_userinfo
     * code说明 ： code作为换取access_token的票据，每次用户授权带上的code将不一样，code只能使用一次，5分钟未被使用自动过期。 
     * 所以每次都得重新访问
     * 授权登录
     * scope 
     * 应用授权作用域，snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），
     * snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且，即使在未关注的情况下，只要用户授权，也能获取其信息）
     * 需要把服务域名加入 微信设置授权回调域名
     */
     public function actionLogin(){
         
         $scope = trim($this->get('scope','snsapi_base')); //静默方式
         $appid = \Yii::$app->params['weixin']['appid'];
         $redirect_uri = urlencode(UrlService::buildWebUrl('/oauth/callback'));
         
         $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state=#wechat_redirect";
     
        return $this->redirect( $url );
         
     }
     /**
      * 通过回调函数取得用户信息
      * 
      */
     public function actionCallback(){
         
     $code = $this->get( "code","" );
		if( !$code ){
			return $this->goHome();
		}

		//通过code 获取网页授权的access_token
		$appid = \Yii::$app->params['weixin']['appid'];
		$sk = \Yii::$app->params['weixin']['sk'];
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$sk}&code={$code}&grant_type=authorization_code";
        $ret = HttpClient::get( $url );
		$ret = @json_decode( $ret,true );		
		/**
		 * ret{
		 *    ["access_token"]=>,
		 *    ["expires_in"]=>,
		 *    ["openid"]=>
		 *    	 
		 * } 
		 */		
		
		$ret_token = isset( $ret['access_token'] )?$ret['access_token']:'';		
		if( !$ret_token ){
			return $this->goHome();
		}
		$openid = isset( $ret['openid'] )?$ret['openid']:'';
		$scope = isset( $ret['scope'] )?$ret['scope']:'';
        //把openid 加入cookie中
		$this->setCookie( $this->auth_cookie_current_openid,$openid );

        //查询绑定记录
		$reg_bind = OauthMemberBind::find()->where([ 'openid' => $openid,'type' => ConstantMapService::$client_type_wechat ])->one();
        if( $reg_bind ){
			$member_info = Member::findOne( [ 'id' => $reg_bind['member_id'],'status' => 1 ] );
			if( !$member_info ){
				$reg_bind->delete();
				return $this->goHome();
			}
			//授权登录方式，更新会员信息
			if( $scope == "snsapi_userinfo" ){
				$url = "https://api.weixin.qq.com/sns/userinfo?access_token={$ret_token}&openid={$openid}&lang=zh_CN";
				$wechat_user_info = HttpClient::get( $url );
				$wechat_user_info = @json_decode( $wechat_user_info,true );
				//这个时候做登录特殊处理，例如更新用户名和头像等等
				if( $member_info->avatar == ConstantMapService::$default_avatar ){
					//使用队列来更新头像
					//$wechat_user_info['headimgurl']
					QueueListService::addQueue( "member_avatar",[
						'member_id' => $member_info['id'],
						'avatar_url' => $wechat_user_info['headimgurl'],
					] );
				}
                 //更新用户名
				if( $member_info['nickname'] == $member_info['mobile'] ){
					$member_info->nickname = isset( $wechat_user_info['nickname'] )?$wechat_user_info['nickname']:$member_info->nickname;
					$member_info->update( 0 );
				}
			}
			//设置登录态
			$this->setLoginStatus( $member_info );
		}else{
		    //没有绑定，那么就先绑定吧
			$this->removeLoginStatus();
			return $this->redirect( UrlService::buildWebUrl( "/user/bind" ) );
		}

		return $this->redirect( UrlService::buildWebUrl( "/default/index" ) );
	}

	public function actionLogout(){
		$this->removeLoginStatus();
		$this->removeCookie( $this->auth_cookie_current_openid );
		return $this->goHome();
	}
  
    
}

