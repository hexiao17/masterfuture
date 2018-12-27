<?php

namespace app\modules\m\controllers;
 
use app\common\services\DataHelper;
 
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
use app\common\services\UrlService;
 
use app\models\masterfuture\MasterfutureTask;

use app\models\masterfuture\MasterfutureCategory;
 
use app\models\equipment\EquipmentDetailExtra;
use app\models\equipment\EquipmentClassInfoExtra;
use app\modules\m\controllers\common\BaseMController;
class ClassController extends BaseMController
{
	  
  public function actionInfo(){
    //只能访问自己的
  	
  	$user_id = $this->current_user['id'];
  	$id = intval($this->get('id','0'));
  	//返回首页		
  	$reback_url = UrlService::buildMUrl('/default/index'); 
  	$class_info = EquipmentClassInfoExtra::find()->where(['id'=>$id])->one(); 
  	if(!$class_info){
  		//是否是拥有者
         return  $this->redirect($reback_url);
   	}   
   	 
  	return $this->render("info",[ 
  	          'class_info'=>$class_info, 
  	]);
  }
  
    
}
