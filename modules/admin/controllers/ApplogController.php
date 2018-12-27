<?php
namespace app\modules\admin\controllers;

use app\modules\admin\controllers\common\BaseAdminController;
use app\common\services\ConstantMapService;
use app\models\AppAccessLog;
use app\common\services\UtilService;
use app\models\AppLog;

class ApplogController extends BaseAdminController{
    /**
     * 访问日志
     */
    public function actionAccesslog(){
        
        $created_time = trim( $this->get("created_time",'' ) );       
        $uid = intval( $this->get("uid",0 ) );
        $p = intval( $this->get("p",1) );
        
         
        $query = AppAccessLog::find();
        $p = ( $p > 0 )?$p:1;
        
        if($created_time >ConstantMapService::$default_time_stamps){
            $query->where(['>','created_time',$created_time]);            
        }
        if($uid){
            $query->andWhere(['uid'=>$uid]);
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
                    'uid' => $_item['uid'],
                    'referer_url' =>  UtilService::encode($_item['referer_url']),
                     'target_url' => UtilService::encode($_item['target_url']),
                    'query_params' => UtilService::encode($_item['query_params']) ,
                    'ua' => UtilService::encode($_item['ua']) ,
                    'ip' => $_item['ip'] ,
                    'created_time' =>  $_item['created_time'] 
                ];
            }
        }
        return $this->render('accesslog',[
            'list' => $data,
            'search_conditions' => [
                'created_time' => $created_time,                
                'uid' => $uid,                
            ], 
            'pages' => [
                'total_count' => $total_res_count,
                'page_size' => $this->page_size,
                'total_page' => $total_page,
                'p' => $p
            ]
             
        ]);
       
    }
    /**
     * 错误日志
     */
    public function actionErrorlog(){
        
       $created_time = trim( $this->get("created_time",'' ) );       
        $ip = trim( $this->get("ip",'' ) );
        $p = intval( $this->get("p",1) );
        
         
        $query = AppLog::find();
        $p = ( $p > 0 )?$p:1;
        
        if($created_time >ConstantMapService::$default_time_stamps){
            $query->where(['>','created_time',$created_time]);            
        }
        if($ip){
            $query->andWhere(['ip'=>$ip]);
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
                    'app_name' => $_item['app_name'],
                    'err_name' =>  $_item['err_name'],
                     'http_code' => $_item['http_code'],
                    'err_code' => $_item['err_code'] ,
                    'ua' =>  UtilService::encode($_item['ua']) ,
                    'ip' => UtilService::encode($_item['ip'] ),
                    'content' => UtilService::encode($_item['content']) ,
                    'created_time' =>  $_item['created_time'] 
                ];
            }
        }
        return $this->render('errorlog',[
            'list' => $data,
            'search_conditions' => [
                'created_time' => $created_time,
                'p' => $p,
                'ip' => $ip,                
            ], 
            'pages' => [
                'total_count' => $total_res_count,
                'page_size' => $this->page_size,
                'total_page' => $total_page,
                'p' => $p
            ]
             
        ]);
    }
}

