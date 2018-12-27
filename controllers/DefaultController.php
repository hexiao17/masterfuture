<?php

namespace app\controllers;


use app\common\components\BaseWebController;
use app\common\services\captcha\ValidateCode;
use app\common\services\UtilService;
use app\models\sms\SmsCaptcha;
use app\common\services\AreaService;
use dosamigos\qrcode\lib\Enum;
use dosamigos\qrcode\QrCode;
use app\common\services\QueueListService;
use app\common\services\SmsService;

use app\models\member\MemberTrial;
use app\common\services\ConstantMapService;
use app\models\masterfuture\MasterfutureShareTaskExtra;
 
 
class DefaultController extends BaseWebController {
    
	public function actionIndex(){
	    //$now_month = date('Y-m',time());
	    $now_year = date('Y',time());
	    $start_month = $now_year.'-01-01';
	    $end_month = $now_year.'-12-31';
	    
	    //分页
	    $p = intval( $this->get("p",1) );
	    $p = ( $p > 0 )?$p:1;
	    //默认显示条数
	    $pageSize =10;
	    
	    $query = MasterfutureShareTaskExtra::find()
	    ->where(['share_level'=>2])
	    ->andWhere(['>=','statu',1])
	    ->andWhere(['>=','created_time',$start_month])
	    ->andWhere(['<=','created_time',$end_month]);
	    
	    //分页功能
	    $total_res_count = $query->count();
	    $total_page = ceil($total_res_count/$pageSize);	    
	    
	    //查询公开的分享
	    $shares =  $query
	                   ->offset(($p-1)*$pageSize)
	                   ->limit($pageSize)
	                   ->all();
	     
	    return $this->render( "index",[
	        'shares'=>$shares,
	        'pages' => [
	            'total_count' => $total_res_count,
	            'page_size' => $pageSize,
	            'total_page' => $total_page,
	            'p' => $p
	        ]
	        
	    ]);
	     
	}

	 
	/**
	 * 获取图片验证码
	 */
	public function actionImg_captcha(){
	    
		$font_path = \Yii::$app->getBasePath() ."/web/fonts/captcha.ttf";
		$captcha_handle = new ValidateCode( $font_path );
		$captcha_handle->doimg();
	 
		$this->setCookie( ConstantMapService::$img_captcha_cookie_name,$captcha_handle->getCode() );
	}
    /*
     * 判断图片验证码正确，产生手机验证码
     */
	public function actionGet_captcha(){
		$mobile = $this->post( "mobile","" );
		$img_captcha = $this->post( "img_captcha","" );
		if( !$mobile || !preg_match('/^1[0-9]{10}$/',$mobile ) ){
		    $this->removeCookie( ConstantMapService::$img_captcha_cookie_name );
			return $this->renderJson( [],"请输入符合要求的手机号码~~",-1 );
		}

		$captcha_code = $this->getCookie( ConstantMapService::$img_captcha_cookie_name );
		if( strtolower( $img_captcha  )  != $captcha_code ){
		    $this->removeCookie( ConstantMapService::$img_captcha_cookie_name );
			return $this->renderJson( [],"请输入正确图形校验码\r\n你输入的图形验证码是{$img_captcha},正确的是{$captcha_code}~~",-1 );
		}
        
		//查询当天 and 发送成功，的短信
		 $count = SmsCaptcha::findBySql("select * from ".SmsCaptcha::tableName()." where mobile=:mobile and status>-1 and  to_days(created_time) = to_days(now())",[':mobile'=>$mobile])->count();
	 
		if($count >=\yii::$app->params['sms']['captcha']['dailyCanDo']){
		    //给队列添加一个清理短信验证码的任务（满了5条5分钟清理一次）
		    QueueListService::addQueue('clear_sms_captcha',[
		        'mobile'=>$mobile
		    ]);
		    return $this->renderJson( [],"你是不是傻？验证码都发了{$count}次了，5分钟之后再试吧！");
		}
		
		//发送手机验证码，能发验证码，能验证
		$model_sms = new SmsCaptcha();
		$ret = $model_sms->geneCustomCaptcha( $mobile ,UtilService::getIP() );
		$this->removeCookie( $this->captcha_cookie_name );
		if( $ret ){		    
			return $this->renderJson( [],"发送成功，请稍等~");
		}

		return $this->renderJson( [],ConstantMapService::$default_syserror,-1 );
	}
    /**
     * 生产二维码图片
     * 通过get参数附带 url
     */
	public function actionQrcode(){
	    $size  = intval($this->get('s',5));
		$qr_code_url =  $this->get("qr_code_url","");
		header('Content-type: image/png');
		QrCode::png($qr_code_url,false,Enum::QR_ECLEVEL_H,$size,0,false);
		exit();
	}
	/**
	 * 二维码的下载
	 */
	public function actionDown_qrcode(){
	    $size  = intval($this->get('s',10));
	    $qr_code_url = $this->get("qr_code_url","");
	    header('Content-type: image/png');
	    QrCode::png($qr_code_url,false,Enum::QR_ECLEVEL_H,$size,0,false);
	    exit();
	}
	

	public function actionCascade(){
		$province_id = $this->get('id',0);
		$tree_info = AreaService::getProvinceCityTree($province_id);
		return $this->renderJSON( $tree_info );
	}
	
	/**
	 * 测试方法
	 */
	public function actionTest(){
	  
	}
	
}