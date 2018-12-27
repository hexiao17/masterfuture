<?php

namespace app\modules\m\controllers;
 
use app\common\services\DataHelper;
 
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
use app\common\services\UrlService;
 
use app\models\masterfuture\MasterfutureTask;

use app\models\masterfuture\MasterfutureCategory;
 
use app\models\equipment\EquipmentDetailExtra;
use app\modules\m\controllers\common\BaseMController;
class EquipController extends BaseMController
{
	  
  public function actionInfo(){
    //只能访问自己的
  	
  	$user_id = $this->current_user['id'];
  	$uuid = trim($this->get('uuid','2867e459f92f91b84757baadc1bdadb6'));
  	//返回首页		
  	$reback_url = UrlService::buildMUrl('/default/index'); 
  	$equip_info = EquipmentDetailExtra::find()->where(['qrcode'=>$uuid])->one(); 
  	if(!$equip_info){
  		//是否是拥有者
         return  $this->redirect($reback_url);
   	}   
   	//计算已使用年数
   	$between = UtilService::DateMath($equip_info->lastUse->created_time,"",$type='year');
   	
  	return $this->render("info",[
  	         'equip_info'=>$equip_info, 
  			 'class_info'=>$equip_info->classinfo,
  	         'org_info'=>$equip_info->org,
  	         'use_log'=>$equip_info->lastUse,
  	         'use_long' =>$between,
  	]);
  }
  
    
}
