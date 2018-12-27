<?php
namespace app\modules\front\controllers;


use app\modules\front\controllers\common\BaseFrontController;
use app\common\services\ConstantMapService;
use app\models\masterfuture\MasterfutureFavExtra;
use app\models\masterfuture\MasterfutureShareTaskExtra;

class FavController extends BaseFrontController{
    
    
//     public function actionIndex() {
//         return $this->render('index');
//     }
    
//     public function actionSet() {
//         return $this->render('set');
//     }
    
    public function actionOps() {
        if( !\Yii::$app->request->isPost ){
            return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        }
        
        $act = $this->post("act","");
        $dataid = intval( $this->post("dataid",0) );
        $favid = intval($this->post('favid',0));
        $date_now = date("Y-m-d H:i:s"); 
        
        if( !in_array( $act,[ "fav","unfav"]) ){
            return $this->renderJSON([],ConstantMapService::$default_syserror.'1',-1);
        }
        
        if( $act=='fav'&&!$dataid ){
            return $this->renderJSON([],ConstantMapService::$default_syserror.'2',-1);
        }
        if( $act=='unfav'&&!$favid ){
            return $this->renderJSON([],ConstantMapService::$default_syserror.'3',-1);
        }
        $user_id = $this->current_user['id'];
    
        //没有的分享不能收藏
        $share_info;
        if($act =='fav'){
            $share_info = MasterfutureShareTaskExtra::find()->where([ 'id' => $dataid])
            ->andWhere(['>','statu','0'])
            ->one();
            if( !$share_info ){
                return $this->renderJSON([],'分享不存在哦',-1);
            }
            //一人只能收藏一次，正常状态
            $exist_fav = MasterfutureFavExtra::find()->where(['share_id'=>$share_info->id,'user_id'=>$user_id,'statu'=>1])->one();
            if($exist_fav ){
                return $this->renderJSON([],'你已经收藏过了，不能重复收藏哦',-1);
            }
        }
        $fav_info;
        if($act=='unfav'){
            //不存在的收藏删除错误
            $fav_info = MasterfutureFavExtra::find()->where(['id'=>$favid,'statu'=>1])->one();
            if( !$fav_info ){
                return $this->renderJSON([],'收藏不存在哦',-1);
            }
            
        }
        $error;
        switch ( $act ){
            case "fav":
                $fav_model = new MasterfutureFavExtra();
                $fav_model->share_id = $share_info->id;
                $fav_model->user_id = $user_id;
                $fav_model->created_time = $date_now;
                $ret = $fav_model->save(0);
                if($ret){ 
                    $share_info->fav_num +=1;
                    $share_info->update(0); 
                } else{
                    $error = $share_info->getErrors();
                }
                break;
            case "unfav":
                $fav_info->statu = 0;
                if($fav_info->update( 0 )){
                    $share_info = $fav_info->share;
                    $share_info->fav_num -=1;
                    $share_info->update(0);
                } 
                break; 
                
        }
        
        return $this->renderJSON(['num'=>$share_info->fav_num],"操作成功~~");
    }
    
    
    
}