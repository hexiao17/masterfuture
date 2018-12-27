<?php

namespace app\modules\m\controllers;

use app\common\services\ConstantMapService;
use app\common\services\DataHelper;
use app\common\services\QueueListService;
use app\common\services\UrlService;
use app\common\services\UtilService;
 
use app\models\City;

use app\models\member\MemberAddress;
use app\models\member\MemberComments;
 
use app\models\member\OauthMemberBind;
 
 
use app\common\services\AreaService;
 
use app\models\sms\SmsCaptcha;
 
use app\models\member\MemberTrial;

use app\models\market\MarketQrcode;
use app\common\services\weixin\RequestService; 
//use dosamigos\qrcode\QrCode;
use app\models\role\Role;
use app\models\role\UserRole;
use app\models\member\PasswordUtils;
 
use app\controllers\common\BaseController;
use app\models\member\MemberExtra;
use app\modules\m\controllers\common\BaseMController;
 
  
class UserController extends BaseMController {

    public function actionIndex(){
        return $this->render('index',[
        	'current_user' => $this->current_user
		]);
    }

	//账号绑定
	public function actionBind(){
		if( \Yii::$app->request->isGet ){
			return $this->render( "bind" );
		}

		$mobile = trim( $this->post("mobile") );
		$img_captcha = trim( $this->post("img_captcha") );
		$captcha_code = trim( $this->post("captcha_code") );
		$date_now = date("Y-m-d H:i:s");

		$openid = $this->getCookie( $this->auth_cookie_current_openid );

		if( mb_strlen($mobile,"utf-8") < 1 || !preg_match("/^[1-9]\d{10}$/",$mobile) ){
			return $this->renderJSON([],"请输入符合要求的手机号码~~",-1);
		}

		if (mb_strlen( $img_captcha, "utf-8") < 1) {
			return $this->renderJSON([], "请输入符合要求的图像校验码~~", -1);
		}

		if (mb_strlen( $captcha_code, "utf-8") < 1) {
			return $this->renderJSON([], "请输入符合要求的手机验证码~~", -1);
		}

        //检查手机验证码    
		if ( !SmsCaptcha::checkCaptcha($mobile, $captcha_code ) ) {
			return $this->renderJSON([], "请输入正确的手机验证码~~", -1);
		}

		$member_info = MemberExtra::find()->where([ 'mobile' => $mobile,'status' => 1 ])->one();

		//未注册
		if( !$member_info ){
		    if( MemberExtra::findOne([ 'mobile' => $mobile]) ){
				$this->renderJSON([], "手机号码已注册，请直接使用手机号码登录~~", -1);
			}

			$model_member = new MemberExtra();
			$model_member->nickname = $mobile;
			$model_member->mobile = $mobile;
			$model_member->setSalt();
			$model_member->avatar = ConstantMapService::$default_avatar;
			$model_member->reg_ip = sprintf("%u",ip2long( UtilService::getIP() ) );
			$model_member->status = 1;
			$model_member->created_time = $model_member->updated_time = $date_now;
			$model_member->save( 0 );			
			//设置会员试用信息
			$model_member = $this->setUserTrial($model_member);
			//第一次绑定的时候才会更新角色表,再次绑定的时候不能随便更新角色！否则会人为造成角色更改
			if($model_member){
			    //添加用户角色表 userrole
			    $model_user_role = new UserRole();
			    $model_user_role->uid = $model_member->id;
			    $model_user_role->role_id = $model_member->role_id;
			    $model_user_role->cate =1;
			    $model_user_role->created_time = $date_now;
			    $model_user_role->save( 0 );			    	
			}
			
			//再次更新
			$model_member->save( 0 );
			$member_info = $model_member;
		}

		if ( !$member_info || !$member_info['status']) {
			return $this->renderJSON([], "您的账号已被禁止，请联系客服解决~~", -1);
		}

		if( $openid ){//微信打开才有openid
			$bind_info = OauthMemberBind::find()->where([ 'member_id' => $member_info['id'],'openid' => $openid,'type' => ConstantMapService::$client_type_wechat  ])->one();

			if( !$bind_info ){
				$model_bind = new OauthMemberBind();
				$model_bind->member_id = $member_info['id'];
				$model_bind->type = ConstantMapService::$client_type_wechat;
				$model_bind->client_type = "weixin";
				$model_bind->openid = $openid;
				$model_bind->unionid = '';
				$model_bind->extra = '';
				$model_bind->updated_time = $date_now;
				$model_bind->created_time = $date_now;
				$model_bind->save( 0 );
				//绑定之后要做的事情
				QueueListService::addQueue( "bind",[
					'member_id' => $member_info['id'],
					'type' => 1,
					'openid' => $model_bind->openid
				] );
			}
		}
        //如果没有取得授权的话，现在要取得授权
		if( UtilService::isWechat() && $member_info['nickname']  == $member_info['mobile'] ){
			return $this->renderJSON([ 'url' => UrlService::buildWebUrl( "/oauth/login",[ 'scope' => 'snsapi_userinfo' ] )  ],"绑定成功~~");
		}
		//todo设置登录态
		$this->setLoginStatus( $member_info );
		return $this->renderJSON([ 'url' => UrlService::buildWebUrl( "/default/index" )  ],"绑定成功~~");
	}
	/**
	 * 电脑端的登录
	 * @return string
	 */
	public function  actionLogin(){
	    if( \Yii::$app->request->isGet ){
	        return $this->render( "login" );
	    }
	    $mobile = trim( $this->post("mobile") );
	    $pwd = trim($this->post("login_pwd",""));
	    $img_captcha = trim( $this->post("img_captcha") );
	    
	    $date_now = date("Y-m-d H:i:s");
	    
	    if (mb_strlen( $img_captcha, "utf-8") < 4) {
	        return $this->renderJs("请输入符合要求的图像校验码~~", UrlService::buildMUrl('/user/login'));
	    }
	    //判断图像验证码是否正确	 	    
	    $captcha_code = $this->getCookie( ConstantMapService::$img_captcha_cookie_name );
	    if( strtolower( $img_captcha  )  != $captcha_code ){
	        $this->removeCookie(ConstantMapService::$img_captcha_cookie_name);
	        return $this->renderJs('请输入正确图形校验码\r\n你输入的图形验证码是'.$img_captcha.',正确的是'.$captcha_code.'~~',UrlService::buildMUrl('/user/login') );
	    }
	    
	    if(!$mobile || !$pwd){
	        return $this->renderJs('请输入正确的用户名和密码~~',UrlService::buildMUrl('/user/login'));
	        
	    }
	    
	    //从用户表获取 login_name = $login_name 信息是否存在
	    $member_info = MemberExtra::find()->where(['mobile'=>$mobile,'status'=>1])->one();
	    if(!$member_info){
	        return $this->renderJs('请输入正确的用户名和密码~~',UrlService::buildMUrl('/user/login'));
	    }
	    
	    //校验密码
	    //密码加密算法 = md5(login_pwd + md5(login_salt))
	   
	    if(!PasswordUtils::verifyPassword($pwd, $member_info->login_pwd, $member_info->salt)){
	        return $this->renderJs('请输入正确的用户名和密码~~',UrlService::buildMUrl('/user/login'));	        
	    }
	    //保持用户的登录状态
	    //cookie保存
	    //加密字符串 + "#" + uid,加密字符串= md5(login_name +login_pwd + login_salt)
	     
	    $this->setLoginStatus($member_info);
	    
	    //更新登录时间
	    $member_info->updated_time = $date_now;	    
	    $member_info->save( );    
	   	   
	    return $this->renderJSON([ 'url' => UrlService::buildMUrl( "/default/index" )  ],"登陆成功~~");
	}
	/**
	 * 电脑端的注册
	 * @return string
	 */
	public function actionReg(){
	    if( \Yii::$app->request->isGet ){
	        return $this->render( "register" );
	    }
	    
	    $mobile = trim($this->post("mobile",""));
	    $email = trim($this->post("email",""));
	    $login_pwd = trim($this->post("login_pwd",""));
	    $captcha_code = trim($this->post("captcha_code",""));
	    $date_now = date("Y-m-d H:i:s");
	    
	    if(mb_strlen($mobile,"utf-8") !==11  ){
	        return $this->renderJson([],"请输入合规的手机号~~1",-1);
	    }
	    
	    if(mb_strlen($email,"utf-8")<1){
	        return $this->renderJson([],"请输入合规的邮箱~~11",-1);
	    }
	    if(mb_strlen($login_pwd,"utf-8")<1){
	        return $this->renderJson([],"请输入合规的密码~~111",-1);
	    }
	   
	    if(mb_strlen($captcha_code,"utf-8")<1){
	        return $this->renderJson([],"请输入正确的手机验证码~~111",-1);
	    }
	    //检查手机验证码
// 	    if ( !SmsCaptcha::checkCaptcha($mobile, $captcha_code ) ) {
// 	        return $this->renderJSON([], "请输入正确的手机验证码~~", -1);
// 	    }
	    
	    $has_in  = MemberExtra::find()->where(['mobile'=>$mobile])->one();
	     
	    if($has_in){
	        return $this->renderJson([],"用户名已存在，请重新输入~~2",-1);
	    }
	    
	    $new_member = new MemberExtra();
	   
	    $new_member->salt= PasswordUtils::getSalt();
	    
	    $new_member->created_time= $date_now;
	    
	    $new_member->mobile = $new_member->nickname = $mobile;
	    $new_member->email = $email;
	    $new_member->avatar = ConstantMapService::$default_avatar;
	    $new_member->login_pwd = PasswordUtils::getMd5SaltPassword($login_pwd, $new_member->salt);
	    $new_member->updated_time = $date_now;
	    
	    
	    if($new_member->save( 0 )){
	        return  $this->renderJson([],"操作成功~~3");
	    }
	    return  $this->renderJson([],"注册失败，请重新注册~~5",-1);
	  
	    
	}
// 	public function actionOrder(){
//     	$pay_order_list = PayOrder::find()->where([ 'member_id' => $this->current_user['id'] ])
// 			->orderBy([ 'id' => SORT_DESC ])->asArray()->all();

//     	$list = [];
//     	if( $pay_order_list ) {
// 			$pay_order_items_list = PayOrderItem::find()->where(['member_id' => $this->current_user['id'], 'pay_order_id' => array_column($pay_order_list, 'id')])->asArray()->all();

// 			$book_mapping = Book::find()->where(['id' => array_column($pay_order_items_list, 'target_id')])->indexBy('id')->all();

// 			$pay_order_items_mapping = [];
// 			foreach ($pay_order_items_list as $_pay_order_item) {
// 				$tmp_book_info = $book_mapping[ $_pay_order_item['target_id'] ];
// 				if (!isset( $pay_order_items_mapping[ $_pay_order_item['pay_order_id'] ] ) ) {
// 					$pay_order_items_mapping[$_pay_order_item['pay_order_id']] = [];
// 				}
// 				$pay_order_items_mapping[$_pay_order_item['pay_order_id']][] = [
// 					'pay_price'       => $_pay_order_item['price'],
// 					'book_name'       => UtilService::encode($tmp_book_info['name']),
// 					'book_main_image' => UrlService::buildPicUrl("book", $tmp_book_info['main_image']),
// 					'book_id' => $_pay_order_item['target_id'],
// 					'comment_status' => $_pay_order_item['comment_status']
// 				];
// 			}

// 			foreach ($pay_order_list as $_pay_order_info) {
// 				$list[] = [
// 					'id' => $_pay_order_info['id'],
// 					'sn' => date("Ymd", strtotime($_pay_order_info['created_time'])) . $_pay_order_info['id'],
// 					'created_time' => date("Y-m-d H:i", strtotime($_pay_order_info['created_time'])),
// 					'pay_order_id' => $_pay_order_info['id'],
// 					'pay_price'    => $_pay_order_info['pay_price'],
// 					'items' => $pay_order_items_mapping[$_pay_order_info['id']],
// 					'status' => $_pay_order_info[ 'status' ],
// 					'comment_status' => $_pay_order_info[ 'comment_status' ],
// 					'express_status' => $_pay_order_info[ 'express_status' ],
// 					'express_info' => $_pay_order_info[ 'express_info' ],
// 					'express_status_desc' => ConstantMapService::$express_status_mapping_for_member[ $_pay_order_info[ 'express_status' ] ],
// 					'status_desc' => ConstantMapService::$pay_status_mapping[ $_pay_order_info[ 'status' ] ],
// 					'pay_url' => UrlService::buildWebUrl("/pay/buy/?pay_order_id={$_pay_order_info['id']}")
// 				];

// 			}
// 		}

// 		return $this->render('order',[
// 			'list' => $list
// 		]);
// 	}

// 	public function actionFav(){
// 	    //把 zbnews 和 stnews分开
	    
// 		$zblist = NewsFav::find()->where([ 'member_id' => $this->current_user['id'],'type'=>'zb'])->orderBy([ 'id' => SORT_DESC ])->all();
// 		$stlist = NewsFav::find()->where([ 'member_id' => $this->current_user['id'],'type'=>'st'])->orderBy([ 'id' => SORT_DESC ])->all();
// 		$data = [];
// 		if( $zblist ){
// 			$book_mapping = DataHelper::getDicByRelateID( $zblist ,ZBNews::className(),"newlist_id","id",[ 'title','pub_company','tags','expired_time' ] );
// 			foreach( $zblist as $_item ){
// 				$tmp_book_info = $book_mapping[ $_item['newlist_id'] ];
// 				$data[] = [
// 					'id' => $_item['id'],
// 					'newlist_id' => $_item['newlist_id'],
// 					'title' => UtilService::encode( $tmp_book_info['title'] ),
// 					'pub_company' => UtilService::encode( $tmp_book_info['pub_company'] ),
// 				    'tags' => UtilService::encode( $tmp_book_info['tags'] ),
// 					'expired_time' => $tmp_book_info['expired_time'],
// 				    'type'=>'zb'
// 				];
// 			}
// 		}
// 		if( $stlist ){
// 		    $book_mapping = DataHelper::getDicByRelateID( $stlist ,STNews::className(),"newlist_id","id",[ 'title','pub_company','tags','expired_time' ] );
// 		    foreach( $stlist as $_item ){
// 		        $tmp_book_info = $book_mapping[ $_item['newlist_id'] ];
// 		        $data[] = [
// 		            'id' => $_item['id'],
// 		            'newlist_id' => $_item['newlist_id'],
// 		            'title' => UtilService::encode( $tmp_book_info['title'] ),
// 		            'pub_company' => UtilService::encode( $tmp_book_info['pub_company'] ),
// 		            'tags' => UtilService::encode( $tmp_book_info['tags'] ),
// 		            'expired_time' => $tmp_book_info['expired_time'],
// 		            'type'=>'st'
// 		        ];
// 		    }
// 		}
// 		return $this->render("fav",[
// 			'list' => $data
// 		]);
// 	}

	public function actionAddress(){

		$list = MemberAddress::find()->where([ 'member_id' => $this->current_user['id'],'status' => 1 ])
			->orderBy([ 'is_default' => SORT_DESC,'id' => SORT_DESC ])->asArray()->all();
		$data = [];
		if( $list ){
			$area_mapping = DataHelper::getDicByRelateID( $list,City::className(),"area_id","id",[ 'province','city','area' ] );
			foreach( $list as $_item){
				$tmp_area_info = $area_mapping[ $_item['area_id'] ];
				$tmp_area = $tmp_area_info['province'].$tmp_area_info['city'];
				if( $_item['province_id'] != $_item['city_id'] ){
					$tmp_area .= $tmp_area_info['area'];
				}

				$data[] = [
					'id' => $_item['id'],
					'is_default' => $_item['is_default'],
					'nickname' => UtilService::encode( $_item['nickname'] ),
					'mobile' => UtilService::encode( $_item['mobile'] ),
					'address' => $tmp_area.UtilService::encode( $_item['address'] ),
				];
			}
		}
		return $this->render('address',[
			'list' => $data
		]);
	}

	public function actionAddress_set(){
		if( \Yii::$app->request->isGet ){
			$id = intval( $this->get("id",0) );
			$info = [];
			if( $id ){
				$info = MemberAddress::find()->where([ 'id' => $id,'member_id' => $this->current_user['id'] ])->one();
			}
			return $this->render('address_set',[
				"province_mapping" => AreaService::getProvinceMapping(),
				'info' => $info
			]);
		}

		$id = intval( $this->post("id",0) );
		$nickname = trim( $this->post("nickname","") );
		$mobile = trim( $this->post("mobile","") );
		$province_id = intval( $this->post("province_id",0) );
		$city_id = intval( $this->post("city_id",0) );
		$area_id = intval( $this->post("area_id",0) );
		$address = trim( $this->post("address","" ) );
		$date_now = date("Y-m-d H:i:s");

		if( mb_strlen( $nickname,"utf-8" ) < 1 ){
			return $this->renderJSON([],"请输入符合规范的收货人姓名~~",-1);
		}

		if( !preg_match("/^[1-9]\d{10}$/",$mobile) ){
			return $this->renderJSON([],"请输入符合规范的收货人手机号码~~",-1);
		}

		if( $province_id < 1 ){
			return $this->renderJSON([],"请选择省~~",-1);
		}

		if( $city_id < 1 ){
			return $this->renderJSON([],"请选择市~~",-1);
		}

		if( $area_id < 1 ){
			return $this->renderJSON([],"请选择区~~",-1);
		}

		if( mb_strlen( $address,"utf-8" ) < 3 ){
			return $this->renderJSON([],"请输入符合规范的收货人详细地址~~",-1);
		}

		$info = [];
		if( $id ){
			$info = MemberAddress::find()->where([ 'id' => $id,'member_id' => $this->current_user['id'] ])->one();
		}

		if( $info ){
			$model_address = $info;
		}else{
			$model_address = new MemberAddress();
			$model_address->member_id = $this->current_user['id'];
			$model_address->status = 1;
			$model_address->created_time = $date_now;
		}

		$model_address->nickname = $nickname;
		$model_address->mobile = $mobile;
		$model_address->province_id = $province_id;
		$model_address->city_id = $city_id;
		$model_address->area_id = $area_id;
		$model_address->address = $address;
		$model_address->updated_time = $date_now;
		$model_address->save( 0 );

		return $this->renderJSON([],"操作成功");
	}

	public function actionAddress_ops(){
		$act = trim( $this->post("act","") );
		$id = intval( $this->post("id",0) );

		if( !in_array( $act,[ "del","set_default" ] ) ){
			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
		}

		if( !$id ){
			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
		}

		$info = MemberAddress::find()->where([ 'member_id' => $this->current_user['id'],'id' => $id ])->one();
		switch ( $act ){
			case "del":
				$info->is_default = 0;
				$info->status = 0;
				break;
			case "set_default":
				$info->is_default = 1;
				break;
		}

		$info->updated_time = date("Y-m-d H:i:s");
		$info->update( 0 );

		if( $act == "set_default" ){
			MemberAddress::updateAll(
				[ 'is_default' => 0  ],
				[ 'AND',[ 'member_id' => $this->current_user['id'],'status' => 1 ] ,[ '!=','id',$id ] ]
			);
		}
		return $this->renderJSON( [],"操作成功,请重新购买~~" );
	}

	public function actionComment(){
	    //给自己只展示真实的评论
		$list = MemberComments::find()->where([ 'member_id' => $this->current_user['id'],'type'=>1 ])
			->orderBy([ 'id' => SORT_DESC ])->asArray()->all();

		return $this->render('comment',[
			'list' => $list
		]);
	}

// 	public function actionComment_set(){
// 		if( \Yii::$app->request->isGet ){
// 			$pay_order_id = intval( $this->get("pay_order_id",0) );
// 			$book_id = intval( $this->get("book_id",0) );
// 			$pay_order_info = PayOrder::findOne([ 'id' => $pay_order_id,'status' => 1,'express_status' => 1 ]);
// 			$reback_url = UrlService::buildWebUrl("/user/index");
// 			if( !$pay_order_info ){
// 				return $this->redirect( $reback_url );
// 			}

// 			$pay_order_item_info  = PayOrderItem::findOne([ 'pay_order_id' => $pay_order_id,'target_id' => $book_id ]);
// 			if( !$pay_order_item_info ){
// 				return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
// 			}

// 			if(  $pay_order_item_info['comment_status'] ){
// 				return $this->renderJS( "您已经评论过啦，不能重复评论~~",$reback_url );
// 			}


// 			return $this->render('comment_set',[
// 				'pay_order_info' => $pay_order_info,
// 				'book_id' => $book_id
// 			]);
// 		}

// 		$pay_order_id = intval( $this->post("pay_order_id",0) );
// 		$book_id = intval( $this->post("book_id",0) );
// 		$score = intval( $this->post("score",0) );
// 		$content = trim( $this->post('content','') );
// 		$date_now  = date("Y-m-d H:i:s");

// 		if( $score <= 0 ){
// 			return $this->renderJSON([],"请打分~~",-1);
// 		}

// 		if( mb_strlen( $content,"utf-8" ) < 3 ){
// 			return $this->renderJSON([],"请输入符合要求的评论内容~~",-1);
// 		}

// 		$pay_order_info = PayOrder::findOne([ 'id' => $pay_order_id,'status' => 1,'express_status' => 1 ]);
// 		if( !$pay_order_info ){
// 			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
// 		}

// 		$pay_order_item_info  = PayOrderItem::findOne([ 'pay_order_id' => $pay_order_id,'target_id' => $book_id ]);
// 		if( !$pay_order_item_info ){
// 			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
// 		}

// 		if(  $pay_order_item_info['comment_status'] ){
// 			return $this->renderJSON( [],"您已经评论过啦，不能重复评论~~",-1 );
// 		}

// 		$book_info = Book::findOne([ 'id' => $book_id ]);
// 		if( !$book_info ){
// 			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
// 		}

// 		$model_comment = new MemberComments();
// 		$model_comment->member_id = $this->current_user['id'];
// 		$model_comment->book_id = $book_id;
// 		$model_comment->pay_order_id = $pay_order_id;
// 		$model_comment->score = $score * 2;
// 		$model_comment->content = $content;
// 		$model_comment->created_time = $date_now;
// 		$model_comment->save( 0 );

// 		$pay_order_item_info->comment_status = 1;
// 		$pay_order_item_info->update( 0 );

// 		$book_info->comment_count += 1;
// 		$book_info->update( 0 );


// 		return $this->renderJSON([],"评论成功~~");
// 	}
	 /**
	  *  生成测试记录
	  * @param   $member_id
	  * @return boolean  true 可以试用;false 不能试用
	  */
	private function setUserTrial($member){
	    $model_trial = MemberTrial::findOne(['member_id'=>$member->id]);
	    if($model_trial){//表示已经试用过了
	        return false;
	    }
	    
	    //可以试用
	    //1、修改会员信息
	    $config = \Yii::$app->params['role']['trial'];
	    $member->role_id = $config['role_id'];
	    $role = Role::findOne(['id'=>$config['role_id']]);
	    $member->expired_time = date("Y-m-d",(time()+$role->valid_days*24*3600));
	    //2、添加试用信息
	    $model = new MemberTrial();
	    $model->member_id = $member->id;
	    $model->created_time = date('Y-m-d H:i:s');
	    $model->expired_time = $member->expired_time;	    
	    $res = $model->save( 0 );
	    
	    if($res){
	        return $member;
	    }else{
	        return false;
	    }
	    	    
	    //已经试用过了
	    // 	        $config = \Yii::$app->params['role']['default'];
	    // 	        $model_member->role_id = $config['role_id'];
	    // 	        $role = Role::findOne(['id'=>$config['role_id']]);
	    // 	        $model_member->expired_time = date("Y-m-d",(time()+$role->valid_days*24*3600));
	    
	}
	
	/**
	 * 邀请链接
	 * 1、根据会员申请二维码
	 * 2、返回给view
	 * 
	 * 权限：普通会员
	 * @return string
	 */
	public function actionInvitate(){
	    //get 请求就展示二维码页面
	    if (\Yii::$app->request->isGet){
	        $qr_id = intval($this->get('qr_id',0));
	        
	        if($qr_id){	            
	            $qrcode =  MarketQrcode::find()->where(['id'=>$qr_id])->one();	            
	            if($qrcode){
	                //检查是否是自己看
	                $ismy = false;
	                if($this->checkLoginStatus()){
	                    if($qrcode->member_id == $this->current_user->id){
	                        $ismy = true;
	                    }else{
	                        $qrcode->total_view_count +=1;	                        
	                    }	                  
	                }else{
	                    $qrcode->total_view_count +=1;
	                }
	                $qrcode->save( 0 );
	                return $this->render('invitate',[
	                    'data'=>$qrcode,
	                    'ismy'=>$ismy
	                ]);	                
	            }            
	        } 
	        //错误
	       return $this->render('/default/noaccess',['msg'=>"系统繁忙，请稍候再试！",'tourl'=>'/web/user/bind']);     
	    }
	    //post  请求，先检查是否登录
	    if(!$this->checkLoginStatus()){
	        return  $this->redirect(UrlService::buildWebUrl('/user/bind'));
	    }
	    $user_info = $this->current_user;
	    $date_now = date('Y-m-d H:i:s');
	    //查询 该  用户的 的二维码(如果过期，需要更新)
	    $model_qrcode = MarketQrcode::find()->where(['member_id'=>$user_info->id,'type'=>2])->one();
	    
	    if($model_qrcode){
	        //二维码没有过期，直接返回
	        if($model_qrcode->expired_time  > $date_now){
	           return $this->renderJSON([ 'url' => UrlService::buildWebUrl( "/user/invitate",['qr_id'=>$model_qrcode->id] )  ],"",2000);
	          
	        }else {
	         //二维码过期，需要跟新
	         $model_qrcode->updated_time = $date_now;
	          //继续执行  
	        }       
	    }else{//如果没有就新建
	        $model_qrcode = new MarketQrcode();
	        $model_qrcode->member_id=$user_info->id;	        
	        $model_qrcode->created_time = $date_now;	        
	        $name = '来自'.$user_info['nickname']."的邀请";	        
	        $model_qrcode->name = $name;
	        $model_qrcode->updated_time = $date_now;
	        $model_qrcode->type = 2;	        
	        
	        if( !$model_qrcode->save( 0 ) ){
	            return $this->renderJSON( [],"操作失败~~",-1 );
	        }
	        //else继续执行
	        
	    }
	     //生成二维码
	        $ret = $this->geneTmpQrcode( $model_qrcode->id );
	        if( $ret ){
	            $model_qrcode->extra = @json_encode( $ret );
	            $model_qrcode->expired_time = date("Y-m-d H:i:s",time() + $ret['expire_seconds'] );
	            $model_qrcode->qrcode = isset( $ret['url'] )?$ret['url']:'';
	            $model_qrcode->update( 0 );
	        } 
	     return $this->renderJSON([ 'url' => UrlService::buildWebUrl( "/user/invitate",['qr_id'=>$model_qrcode->id] )  ],"推广二维码已生成，可以分享给朋友圈了~~");
	
	}
	
	private function geneTmpQrcode( $id ){
	    $config = \Yii::$app->params['weixin'];
	    RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );
	    $token = RequestService::getAccessToken();
	    $post_data = [
	        'expire_seconds' => 2592000,//2592000（即30天）
	        'action_name' => 'QR_SCENE',
	        'action_info' => [
	            'scene' => [
	                'scene_id' => $id
	            ]
	        ],
	    ];
	    return RequestService::send( "qrcode/create?access_token={$token}",json_encode( $post_data ),'POST' );
	}
	 
	

}
