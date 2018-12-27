<?php

namespace app\modules\front\controllers;

 
use app\common\services\ConstantMapService;
 
use app\models\masterfuture\MasterfutureShareTaskReply;
use app\models\masterfuture\MasterfutureShareTask;
use app\common\services\UrlService;
 
use app\modules\front\controllers\common\BaseFrontController;
 
class SharereplyController extends BaseFrontController{
	
	public function actionOps(){
		if( !\Yii::$app->request->isPost ){
			return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
		}
		 
		$act = $this->post("act","");
		$id = intval( $this->post("id",0) );		 
		 
		$date_now = date("Y-m-d H:i:s");
		if( !in_array( $act,[ "set_zan","isAccept"]) ){
			return $this->renderJSON([],ConstantMapService::$default_syserror.'1',-1);
		}
		 
		if( !$id ){
			return $this->renderJSON([],ConstantMapService::$default_syserror.'2',-1);
		}
// 		if( $act=="edit_type"&&!$group ){
// 			return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
// 		}
// 		if( $act=="edit_weight"&&!$weight ){
// 			return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
// 		}
// 		if( $act=="edit_statu"&&!$statu ){
// 			return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
// 		}
		 
		$user_id = $this->current_user['id'];
		//$task_info = MasterfutureTask::find()->where([ 'id' => $id,'user_id' => $this->current_user['id'] ])->one();
		//只能修改自己的任务
		$reply_info = MasterfutureShareTaskReply::find()->where([ 'id' => $id])->one();
		if( !$reply_info ){
			return $this->renderJSON([],ConstantMapService::$default_syserror.'3',-1);
		}
		 
		switch ( $act ){
			case "set_zan":
				$reply_info->agreeNum += 1;
				$reply_info->update(0);
				break;
			case  "isAccept":
				$reply_info->isAccept = $reply_info->isAccept ==1 ?0:1;
				$reply_info->update(0);
				break;
		}
		 
		return $this->renderJSON(['num'=>$reply_info->agreeNum],"操作成功~~");
	}
	
	public function actionSet(){
		if( !\Yii::$app->request->isPost ){
			return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
		}
		
		$content = $this->post("content","");
		$id = intval( $this->post("id",0) );			
		$date_now = date("Y-m-d H:i:s");		
		//校验
		if(mb_strlen( $content ,"utf-8")  > 500 || mb_strlen( $content ,"utf-8") < 4){
			return $this->renderJson([],"回复内容不能小于2个字符或大于250字".'1',-1);
		}
		//查询任务，
		$task_info = MasterfutureShareTask::find()->where(['id'=>$id])->one();
		if(!$task_info){
			return $this->renderJson([],ConstantMapService::$default_syserror.'2',-1);
		}
		$user_id = $this->current_user['id'];
		$model_reply = New MasterfutureShareTaskReply();
		$model_reply->share_id = $id;
		$model_reply->content = $content;
		$model_reply->user_id = $user_id;
		$model_reply->created_time = $date_now;
	 
		//并且 计算楼层，查询最大楼层+1
		$reply_info = MasterfutureShareTaskReply::find()->where(['share_id'=>$id])->orderBy(['floor'=>SORT_DESC])->one();
		if($reply_info){
			$model_reply->floor = $reply_info->floor + 1;
		}	
		
		if( !$model_reply->save( 0 ) ){
			return $this->renderJSON([],ConstantMapService::$default_syserror.'3',-1);
		}
		$task_info->reply_num = $task_info->reply_num +1;
		$task_info->update( 0 );
		
		//return $this->renderJSON(['uuid'=>$model_reply->$task_info->uuid],"操作成功~~",200);
		
		return $this->redirect( UrlService::buildMUrl('/share/info',['uuid'=>$task_info->uuid]) );
		
	}
	
	
}

?>