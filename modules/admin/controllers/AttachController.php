<?php
namespace app\modules\admin\controllers;
use app\modules\admin\controllers\common\BaseAdminController;
use app\models\news\ZbnewsAttach;
use app\common\services\UtilService;
use app\common\services\ConstantMapService;

/**
 * 附件控制器
 * @author Administrator
 *
 */
class AttachController extends BaseAdminController
{
    public function actionIndex(){
         
        $status = intval($this->get("status",ConstantMapService::$status_default));
        $mix_kw = trim( $this->get("mix_kw","" ) );       
        $p = intval( $this->get("p",1) );    
         
        $query = ZbnewsAttach::find();
        $p = ( $p > 0 )?$p:1;
        if($status  > ConstantMapService::$status_default){
            $query->andWhere(['status'=>$status]);
        }
        if( $mix_kw ){
            $where_newid = [ 'LIKE','oldnews_id','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $where_name = [ 'LIKE','attach_name','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $query->andWhere([ 'OR',$where_newid,$where_name ]);
        } 
    
        //分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
        //60,60 ~ 11,10 - 1
        $total_res_count = $query->count();
        $total_page = ceil( $total_res_count / $this->page_size );
    
    
        $list = $query->orderBy([ 'id' => SORT_DESC ])
        ->offset( ( $p - 1 ) * $this->page_size )
        ->limit($this->page_size)
        ->all( );
    
        $data = [];
    
        if( $list ){
            foreach( $list as $_item ){
                $data[] = [
                    'id' => $_item['id'],
                    'oldnews_id' =>  $_item['oldnews_id'], 
                    'attach_name' => UtilService::encode( $_item['attach_name'] ),
                    'attach_down_url' =>$_item['attach_down_url'] ,
                    'created_time' => UtilService::encode( $_item['created_time'] ),
                     'down_count' =>  $_item['down_count'],
                    'status'=>$_item['status']
                ];
            }
        }
        return $this->render('index',[
            'list' => $data,
            "status_mapping"=>ConstantMapService::$status_mapping,
            'search_conditions' => [
                'mix_kw' => $mix_kw, 
                'status'=> $status
            ], 
            'pages' => [
                'total_count' => $total_res_count,
                'page_size' => $this->page_size,
                'total_page' => $total_page,
                'p' => $p
            ]
             
        ]);
    }
    
    public function actionOps(){
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
    
        $query = ZbnewsAttach::find();
        $info =$query->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->renderJSON([],"指定附件不存在~~",-1);
        }
    
        switch ( $act ){
            case "remove":
                $info->status = 0;
                break;
            case "recover":
                $info->status = 1;
                break;
        }
     
        $info->update( 0 );
        return $this->renderJSON( [],"操作成功~~" );
    }
    
}

