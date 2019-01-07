<?php
namespace app\modules\front\controllers;

use app\modules\front\controllers\common\BaseFrontController;
use app\common\services\ConstantMapService;
use app\models\masterfuture\MasterfutureUserCounterExtra;
use app\models\masterfuture\MasterfutureCounterLogExtra;
use app\common\services\UtilService;
use app\common\services\ValidateService;

class UsercounterController extends  BaseFrontController{
    
    
    public function actionSet() {
       
        $now_date = date("Y-m-d H:i:s");
        
        if(\Yii::$app->request->isPost){
            $user = $this->current_user;
            
            $name = trim($this->post('name',""));
            $unit = trim($this->post('unit',""));
            $node_icon = trim($this->post('node_icon',''));
            
            if (!ValidateService::strLength( $name,10,2 ) ) {
                return $this->renderJSON([],'记录的长度必须大于2个字符小于10个字符',-1);;
            }
            if (!ValidateService::strLength( $unit,4,1 ) ) {
                return $this->renderJSON([],'单位的长度必须大于1个字符小于4个字符',-1);;
            }
            if (!ValidateService::strLength( $node_icon,20,1 ) ) {
                return $this->renderJSON([],'符号的长度必须大于1个字符小于20个字符',-1);;
            }
            
            $counter_model = new MasterfutureUserCounterExtra();
            $counter_model->name = $name;
            $counter_model->num = 0;
            $counter_model->unit = $unit;
            $counter_model->user_id = $user['id'];
            $counter_model->node_icon = $node_icon;
            $counter_model->updated_time =$now_date;
            $counter_model->save(  0 );     
            
            return $this->renderJson(['id'=>$counter_model->id,'num'=>$counter_model->num,'node_icon'=>$counter_model->node_icon,'name'=>$counter_model->name],"操作成功~~",200); 
        }
        return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        ;
    }
    
    
    
    public function actionAjaxadd() {
         
        $now_date = date("Y-m-d H:i:s");
        
        if(\Yii::$app->request->isPost){
            $data_id = intval($this->post('data_id'));
            $content = trim($this->post('content'));
            $user = $this->current_user;
            $statu = intval($this->post('statu',0));
            
            
            if (!$data_id) {
                return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
            }
            if (mb_strlen( $content,"utf-8" ) < 2) {
                return $this->renderJSON([],'记录的长度必须大于2个字符',-1);;
            }
            
            $counter_model = MasterfutureUserCounterExtra::find()->where(['user_id'=>$user['id'],'statu'=>'0','id'=>$data_id])->one();
            if(!$counter_model){
                return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
            }
            if(!in_array($statu, ['0','1'])){
                return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
            }
            ///todo
            $counterlog = new MasterfutureCounterLogExtra();
            $counterlog->log_text = $content;
            $counterlog->counter_id = $counter_model->id;
            $counterlog->created_time = $now_date;
            if($counterlog->save( 0 )){
                $counter_model->num = $counter_model->num +1;
                $counter_model->updated_time = $now_date;
                
                //是否完成
                if($statu ==1){
                    $counter_model->statu = 1;
                }
                $counter_model->update( 0  );
                return $this->renderJson(['id'=>$counter_model->id,'num'=>$counter_model->num,'node_icon'=>$counter_model->node_icon,'name'=>$counter_model->name],"操作成功~~",200); 
            } 
            return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        } 
        
         
    }
    
    
}

