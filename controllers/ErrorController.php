<?php

namespace app\controllers;

 
use app\common\components\BaseWebController;
use yii\log\FileTarget;
use app\common\services\applog\AppLogService;

 

class ErrorController extends BaseWebController
{



    public function actionError(){
         //记录错误信息到文件和数据库
         $error = \Yii::$app->errorHandler->exception;
         $err_msg = "";
         if($error){
             $file= $error->getFile();
             $line = $error->getLine();
             $message = $error->getMessage();
             $code = $error->getCode();
            //文件处理类
             $log = new FileTarget();
             $log->logFile = \Yii::$app->getRuntimePath().'/logs/err.log';

             $err_msg = $message." [file:{$file}][line:{$line}][code:{$code}][url:{$_SERVER['REQUEST_URI']}][DATA:".http_build_query($_POST)."]";

             $log->messages[] = [
                 $err_msg,
                 1,
                 'application',
                microtime(true),
             ];
             //执行写入
             $log->export();
            //todo 写入到数据库
            AppLogService::addErrorLog(\Yii::$app->id, $err_msg);
         }

         return $this->render('error',['err_msg'=>$err_msg]);

     }
     //无权限访问页面
     public function actionForbidden(){
         return $this->render("forbidden");
     }
}
