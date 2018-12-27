<?php

namespace app\modules\m\controllers;
 
use app\common\services\DataHelper;
 
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
use app\common\services\UrlService;
 
use app\models\masterfuture\MasterfutureTask;

use app\models\masterfuture\MasterfutureCategory;
 
use app\models\equipment\EquipmentDetailExtra;
use app\models\equipment\EquipmentOrderExtra;
use app\models\equipment\EquipmentOrderReplyExtra;
use app\models\flow\FlowExtra;
use app\modules\m\controllers\common\BaseMController;
class OrderController extends BaseMController
{
	  
  public function actionInfo(){
      if( \Yii::$app->request->isGet ) {
              //只能访问自己的  	
          
          	$id = intval($this->get('id','0'));
          	//返回首页		
          	$reback_url = UrlService::buildMUrl('/default/index'); 
          	$order_info = EquipmentOrderExtra::find()->where(['id'=>$id])->one(); 
          	if(!$order_info){
          		//是否是拥有者
                 return  $this->redirect($reback_url);
           	}   
           
          	return $this->render("info",[
          	         'order_info'=>$order_info, 
          			 
          	]);
   }
      //post 
       $content = trim( $this->post('content',""));
       $image_key = trim( $this->post('image_key',""));
       $user_list = trim( $this->post('user_list',""));
       $id = intval($this->post('id',0));
       $date_now = date("Y-m-d H:i:s");
       $user_id = $this->current_user['id'];
       
       
       if(mb_strlen($content,"utf-8") <1 ){
           return $this->renderJson([],"请输入合法的故障描述",-1);
       }
       if(mb_strlen($image_key,"utf-8") <1 ){
           return $this->renderJson([],"请上传图片logo",-1);
       }
       //order
       $order_model = EquipmentOrderExtra::find()->where(['id'=>$id])->one();
       if(!$order_model){
           return $this->renderJson([],ConstantMapService::$default_syserror,-1);
       }
      
        $model_reply = new EquipmentOrderReplyExtra();
        $model_reply->created_time = $date_now;
        
        $model_reply->order_id = $id;
        $model_reply->user_id =1;//$user_id;
        $model_reply->flow_step = $order_model->flow_step;
        $model_reply->content= $content; 
        $model_reply->image = $image_key;
        $model_reply->do_user_list = $user_list;   
       //默认处理成功，流程前进一步
      
       $nextStep = $order_model->getNextStep($order_model->flow_step);
      
       if(!$nextStep){
           return $this->renderJson([],"已经完成了，你要弄啥",-1);
       }
       
      
       if($model_reply->save( 0 )){
           $order_model->flow_step = $nextStep->step;
           
           $order_model->save( 0 );
       }
       
       return $this->renderJson(['id'=>$order_model->id],"操作成功~~".$order_model->flow_step,200); 
      
  }
  
  public function actionSet() {
      
      if( \Yii::$app->request->isGet ) {
          $id = intval( $this->get("id", 0) );
          $eid = intval($this->get("eid",0));
          $flow_id = intval($this->get("fid",0));
          $query = EquipmentOrderExtra::find();
          $reback_url = UrlService::buildMUrl('/default/index'); 
          $equip_info = EquipmentDetailExtra::find()->where(['id'=>$eid])->one();
          if(!$equip_info){
              //是否是拥有者
              return  $this->redirect($reback_url);
          }   
          $info = [];
          if ($id){//修改
              $info = $query->where([ 'id' => $id ])->one();
          }else {//新建
              $info = new EquipmentOrderExtra();
          }
          
          return $this->render('set',[
              'info' => $info,
              'equip_info'=>$equip_info,
              'flow_id'=>$flow_id
          ]);
      }
//       image_key:image_key,
//       mobile:mobile,
//       book_time:book_time,
//       content:content,
//       eid:btn_target.val("data")
      
      $eid = intval( $this->post('eid',""));
      $mobile = trim( $this->post('mobile',""));
      $book_time = trim( $this->post('book_time',""));
      $content = trim( $this->post('content',""));
      $image_key = trim( $this->post('image_key',""));
      $leader = trim( $this->post('leader',""));
      $flow_id = intval($this->post('fid',0));
      
      
      $date_now = date("Y-m-d H:i:s");
      
      if($eid <1 ){
          return $this->renderJson([],ConstantMapService::$default_syserror,-1);
      }
      if(mb_strlen($mobile,"utf-8") <1 ){
          return $this->renderJson([],"请输入符合规范的手机号码",-1);
      }
      if(mb_strlen($book_time,"utf-8") <1 ){
          return $this->renderJson([],"请选择正确的预约时间",-1);
      }
      if(mb_strlen($content,"utf-8") <1 ){
          return $this->renderJson([],"请输入合法的故障描述",-1);
      }
      if(mb_strlen($image_key,"utf-8") <1 ){
          return $this->renderJson([],"请上传图片logo",-1);
      }
      //equip
      $equip_model = EquipmentDetailExtra::find()->where(['id'=>$eid])->one();
      if(!$equip_model){
          return $this->renderJson([],ConstantMapService::$default_syserror,-1);
      }
      
      $flow_model = FlowExtra::find()->where(['id'=>$flow_id])->one();
      if(!$flow_model){
          return $this->renderJson([],ConstantMapService::$default_syserror,-1);
      }
     
      $info = EquipmentOrderExtra::find()->where(['id'=>$id])->one();
      if($info){
          $model_order = $info;
      }else {
          $model_order = new EquipmentOrderExtra();
          $model_order->created_time = $date_now;
          //设置默认流程
          $model_order->flow_id = $flow_model->id;
          $model_order->flow_step =$flow_model->getFirstStep()->step;  
      }
      $model_order->content= $content;
     
      $model_order->tel= $mobile;
      $model_order->equip_detail_id = $eid;
      $model_order->org_id = $equip_model->org->id;
      $model_order->book_time = $book_time;
      $model_order->image = $image_key;
      $model_order->leader = $leader; 
      $model_order->updated_time = $date_now;
      $model_order->user_id = 1;//$this->current_user['id'];
      
      $model_order->save( 0 );
      
      return $this->renderJson(['id'=>$model_order->id],"操作成功~~",200); 
  }
  
  
    
}
