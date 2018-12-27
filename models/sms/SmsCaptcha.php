<?php

namespace app\models\sms;

use Yii;
use app\common\services\SmsService;

/**
 * This is the model class for table "sms_captcha".
 *
 * @property integer $id
 * @property string $mobile
 * @property string $captcha
 * @property string $ip
 * @property string $expires_at
 * @property integer $status
 * @property string $created_time
 */
class SmsCaptcha extends \yii\db\ActiveRecord
{
    //验证
	public static function checkCaptcha( $mobile , $captcha ){
		$info = self::find()->where( [ 'mobile' => $mobile,'captcha' => $captcha ] )->one();
		if( $info &&  strtotime( $info['expires_at'] ) >= time()  ){
			$info->expires_at = date("Y-m-d H:i:s",time() - 1 );
			$info->status = 1;
			$info->save( 0 );
			return true;
		}
		return false;
	}
    //获取
	public function geneCustomCaptcha( $mobile,$ip = '',$sign = '',$channel = '' ){
		$this->mobile = $mobile;
		$this->ip = $ip;
		$this->captcha = rand(1000,9999);
		$this->expires_at = date("Y-m-d H:i:s",time() + 60 * 10  );
		$this->created_time = date( "Y-m-d H:i:s");
		
		//如果你对接了手机验证码供应商，todo实现发验证码 
		//发短信
		$paramArr=Array(  // 短信模板中字段的值
		    "code"=>$this->captcha 
		    );
		$config = \Yii::$app->params['sms']['captcha'];
		$service = new SmsService(
		    $config['accessKeyId'],
		    $config['accessKeySecret']
		    );
		 
		$res= $service->sendAlisms($config['template_id'],$config['qianming'],$mobile, $paramArr);
		 
		if($res->Code =="OK"){//发送成功
		      $this->status = 0 ;
		}else{
		     $this->status = -1 ;		     
		}		
		return $this->save( 0 );
	}
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'sms_captcha';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['expires_at', 'created_time'], 'safe'],
			[['status'], 'required'],
			[['status'], 'integer'],
			[['mobile', 'ip'], 'string', 'max' => 20],
			[['captcha'], 'string', 'max' => 10],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'mobile' => 'Mobile',
			'captcha' => 'Captcha',
			'ip' => 'Ip',
			'expires_at' => 'Expires At',
			'status' => 'Status',
			'created_time' => 'Created Time',
		];
	}
}
