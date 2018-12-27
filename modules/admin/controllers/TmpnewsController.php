<?php
namespace app\modules\admin\controllers;

use app\modules\admin\controllers\common\BaseAdminController;
use app\common\services\ConstantMapService;
use app\models\tmp\PyspiderZbnewTopic;
use app\common\services\UrlService;
use app\models\tmp\TmpStnews;
use app\models\tmp\TmpZbnews;
use dosamigos\qrcode\lib\Split;
use app\models\news\ZBNews;
/**
 * 临时库中新闻
 * @author Administrator
 *
 */
class TmpnewsController extends BaseAdminController
{
    public function actionSt_index(){
        $mix_kw = trim( $this->get("mix_kw","" ) );
        $status = intval( $this->get("status",ConstantMapService::$status_default) );
    
        $p = intval( $this->get("p",1) );
        $p = ( $p > 0 )?$p:1;
    
        $query = TmpStnews::find();
    
        if( $mix_kw ){
            $where_title = [ 'LIKE','title','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $where_flowname = [ 'LIKE','flowname','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $query->andWhere([ 'OR',$where_title,$where_flowname ]);
        }
    
        if( $status > ConstantMapService::$status_default ){
            $query->andWhere([ 'statu' => $status ]);
        }else{
                $query->andWhere([ 'statu' => 1 ]);
            }
         
        //分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
        //60,60 ~ 11,10 - 1
        $total_res_count = $query->count();
        $total_page = ceil( $total_res_count / $this->page_size );
    
        //如果p>total_page
        if($p > $total_page){
            $p = $total_page;
        }
        $list = $query->orderBy([ 'id' => SORT_DESC ])
        ->offset( ( $p - 1 ) * $this->page_size )
        ->limit($this->page_size)
        ->all( );
    
         
        return $this->render('st_index',[
            'list' => $list,
            'search_conditions' => [
                'mix_kw' => $mix_kw,              
                'status' => $status,
    
            ],
            'status_mapping' => ConstantMapService::$tmpData_status_mapping,
            'pages' => [
                'total_count' => $total_res_count,
                'page_size' => $this->page_size,
                'total_page' => $total_page,
                'p' => $p
            ],
        ]);
    }
    
    public function actionSt_info(){
        $id = intval( $this->get("id", 0) );
        $reback_url = UrlService::buildAdminUrl("/tmpnews/st_index");
        if( !$id ){
            return $this->redirect( $reback_url );
        }
        
        $info = TmpStnews::find()->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->redirect( $reback_url );
        } 
        
        
        return $this->render("st_info",[
            "info" => $info,            
        ]);
        }
        
        public function actionSt_ops(){
            if( !\Yii::$app->request->isPost ){
                return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
            }
        
            $id = $this->post('id',[]);
            $act = trim($this->post('act',''));
            if( !$id ){
                return $this->renderJSON([],"请选择要操作的账号~~",-1);
            }
        
            if( !in_array( $act,['remove','recover' ])){
                return $this->renderJSON([],"操作有误，请重试~~",-1);
            }
        
            $info = TmpStnews::find()->where([ 'id' => $id ])->one();
            if( !$info ){
                return $this->renderJSON([],"指定书籍不存在~~",-1);
            }
        
            switch ( $act ){
                case "remove":
                    $info->statu = 0;
                    break;
                case "recover":
                    $info->statu = 1;
                    break;
            }
            $info->updatetime = date("Y-m-d H:i:s");
            $info->update( 0 );
            return $this->renderJSON( [],"操作成功~~" );
        }
        public function actionZb_index(){
            $mix_kw = trim( $this->get("mix_kw","" ) );
            $status = intval( $this->get("status",ConstantMapService::$status_default) );
        
            $p = intval( $this->get("p",1) );
            $p = ( $p > 0 )?$p:1;
        
            $query = TmpZbnews::find();
        
            if( $mix_kw ){
                $where_title = [ 'LIKE','title','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
                $where_flowname = [ 'LIKE','flowname','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
                $query->andWhere([ 'OR',$where_title,$where_flowname ]);
            }
        
            if( $status > ConstantMapService::$status_default ){
                $query->andWhere([ 'statu' => $status ]);
            }else{
                $query->andWhere([ 'statu' => 1 ]);
            }
             
            //分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
            //60,60 ~ 11,10 - 1
            $total_res_count = $query->count();
            $total_page = ceil( $total_res_count / $this->page_size );
            //如果p>total_page
            if($p > $total_page){
                $p = $total_page;
            }
        
            $list = $query->orderBy([ 'id' => SORT_DESC ])
            ->offset( ( $p - 1 ) * $this->page_size )
            ->limit($this->page_size)
            ->all( );
        
             
            return $this->render('zb_index',[
                'list' => $list,
                'search_conditions' => [
                    'mix_kw' => $mix_kw,                  
                    'status' => $status,        
                ],
                'status_mapping' => ConstantMapService::$tmpData_status_mapping,
                'pages' => [
                    'total_count' => $total_res_count,
                    'page_size' => $this->page_size,
                    'total_page' => $total_page,
                    'p' => $p
                ],
            ]);
        }
        
        public function actionZb_info(){
            $id = intval( $this->get("id", 0) );
            $reback_url = UrlService::buildAdminUrl("/tmpnews/st_index");
            if( !$id ){
                return $this->redirect( $reback_url );
            }
        
            $info = TmpZbnews::find()->where([ 'id' => $id ])->one();
            if( !$info ){
                return $this->redirect( $reback_url );
            }
        
        
            return $this->render("zb_info",[
                "info" => $info,
            ]);
        }
        
        public function actionZb_ops(){
            if( !\Yii::$app->request->isPost ){
                return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
            }
        
            $id = $this->post('id',[]);
            $act = trim($this->post('act',''));
            if( !$id ){
                return $this->renderJSON([],"请选择要操作的账号~~",-1);
            }
        
            if( !in_array( $act,['remove','recover' ])){
                return $this->renderJSON([],"操作有误，请重试~~",-1);
            }
        
            $info = TmpZbnews::find()->where([ 'id' => $id ])->one();
            if( !$info ){
                return $this->renderJSON([],"指定书籍不存在~~",-1);
            }
        
            switch ( $act ){
                case "remove":
                    $info->statu = 0;
                    break;
                case "recover":
                    $info->statu = 1;
                    break;
            }
            $info->updatetime = date("Y-m-d H:i:s");
            $info->update( 0 );
            return $this->renderJSON( [],"操作成功~~" );
        }
        /**
         * 批量删除
         */
        public function actionSt_delmulti(){
            if( !\Yii::$app->request->isPost ){
                return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
            }
            
            $ids = $this->post('delitems',"");     
            
            if( !$ids ){
                return $this->renderJSON([],"请选择要操作的账号~~",-1);
            }
            
            $arr =  explode(',', $ids);
           
            $smStr = "";
            for ($i=0;$i<sizeof($arr);$i++){ 
                $smStr .= intval($arr[$i]).","; 
            }
            
            $instr = substr($smStr,0, mb_strlen($smStr)-1);
            
            $sql = "UPDATE ".TmpStnews::tableName()." set `statu`= -1  where id IN (".$instr.")";
            
            //删除还是改变状态吧！
             $x=TmpStnews::getDb()->createCommand($sql)->execute();
           
            return $this->renderJSON( [],"操作成功~~" );
        }
        
        /**
         * 批量删除
         */
        public function actionZb_delmulti(){
            if( !\Yii::$app->request->isPost ){
                return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
            }
        
            $ids = $this->post('delitems',"");
        
            if( !$ids ){
                return $this->renderJSON([],"请选择要操作的账号~~",-1);
            }
        
            $arr =  explode(',', $ids);
             
            $smStr = "";
            for ($i=0;$i<sizeof($arr);$i++){
                $smStr .= intval($arr[$i]).",";
            }
        
            $instr = substr($smStr,0, mb_strlen($smStr)-1);
        
            $sql = "UPDATE ".TmpZbnews::tableName()." set `statu`= -1  where id IN (".$instr.")";
        
            //删除还是改变状态吧！
            $x=TmpZbnews::getDb()->createCommand($sql)->execute();
             
            return $this->renderJSON( [],"操作成功~~" );
        }
}

