<?php
namespace app\common\services\applog;

use app\models\AppLog;
use app\common\services\UtilService;
use app\models\AppAccessLog;

class AppLogService
{
    //记录错误日志
    public static  function addErrorLog($appname,$content){
        $error = \Yii::$app->errorHandler->exception;
        $model_app_log = new AppLog();
        $model_app_log->app_name = $appname;
        $model_app_log->content = $content;
        
        //获取IP，$_SERVER['REMOTE_ADDR']
        $model_app_log->ip = UtilService::getIP();
        
        if(!empty($_SERVER['HTTP_USER_AGENT'])){
            $model_app_log->ua =UtilService::cutstr( $_SERVER['HTTP_USER_AGENT'],290);
        }
        
        if($error){
            $model_app_log->err_code = $error->getCode();
            if(isset($error->statuCode)){
                $model_app_log->http_code = $error->statuCode;
            }
            
            if(method_exists($error, "getName")){
                $model_app_log->err_name = $error->getName();
            }
        }
        
        $model_app_log->created_time = date("Y-m-d H:i:s");
         $model_app_log->save(0);
        
    }
    
    //记录访问日志
    public static function addAccessLog($uid = 0){
        $get_params = \Yii::$app->request->get();
        $post_parmas = \Yii::$app->request->post();
        
        $target_url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"";
        $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"";
        $ua = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT'] :"";
        
        $accesslog = new AppAccessLog();
        $accesslog->uid = $uid?$uid:0;
        $accesslog->referer_url = UtilService::cutstr(UtilService::encode( $referer ),247,$dot="..");
        $accesslog->target_url = UtilService::cutstr(UtilService::encode( $target_url ),247,$dot="..");
        $accesslog->ua =  UtilService::cutstr(UtilService::encode( $ua ),247,$dot="..");
        $accesslog->query_params = UtilService::cutstr(json_encode(array_merge($get_params,$post_parmas)),2000);
        $accesslog->ip = UtilService::getIP();
        $accesslog->created_time = date("Y-m-d H:i:s");
        $accesslog->save( 0 );      
        
    }
    
    
}

