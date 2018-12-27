<?php
  namespace app\common\components;

  use yii\web\Controller;
  use yii\web\Cookie;

  /**
   * 集成常用的公用方法 提供给所有的controller使用
   * get,post,setCookie,getCookie,removeCookie,renderJson
   * Class BaseWebController
   * @package app\common\components
   */
  class BaseWebController extends Controller{

      public $enableCsrfValidation =false;//g关闭csrf

      //获取http的get参数
      public function get($key,$default_val= ""){
          return \Yii::$app->request->get($key,$default_val);
      }

      //获取http的post参数
      public function post($key,$default_val=""){
          return \Yii::$app->request->post($key,$default_val);
      }

      //设置cookie值
      public function setCookie($name,$value,$expire=0){
          $cookies = \Yii::$app->response->cookies;
          $cookies->add(new Cookie([
              'name'=>$name,
              'value'=>$value,
              'expire'=>$expire
          ]));
      }

      //获取cookie值
      public function getCookie($name,$default_val=""){
          $cookies = \Yii::$app->request->cookies;
          return $cookies->getValue($name,$default_val);
      }

      //删除cookie
      public function removeCookie($name){
          $cookies = \Yii::$app->response->cookies;
          $cookies->remove($name);
      }

      /**
       * api统一返回json格式方法,返回msg和data，不带跳转的URL
       * 
       */
      public function renderJson($data=[],$msg="ok",$code=200){
          header('Content-type:application/json');
          echo json_encode([
              'code'=>$code,
              'msg'=>$msg,
              'data'=>$data,
              'req_id'=>uniqid()
          ]);
      }

      /**
             * 统一js 提醒 跳转到URL
             * 采用 app/views/common.js 文件来显示弹出消息！
       * #注意，$msg和$url 都是单引号的变量。 双引号不知道为什么会错
       * 
       */
      public function renderJs($msg,$url ){
          return $this->renderPartial("@app/views/common/js",['msg'=>$msg,'url'=>$url]);
      }
 
      public function renderData($data=[]){
          
          header('Content-type:application/json');
          echo json_encode($data);
          
      }
      
      
  }
  ?>