<?php
namespace app\common\services\weixin;

use app\common\services\BaseService;
use app\models\member\OauthAccessToken;
use app\common\components\HttpClient;
 
/**
 *  请求工具类
 *  获取和更新 access_token服务
 * @author Administrator
 *
 */
class RequestService extends BaseService
{
    private static  $app_token ="";
    private static  $appid ="";
    private static  $app_secret ="";
    /**
     * base_url 
     * @var string
     */
    private static $url = "https://api.weixin.qq.com/cgi-bin/";
    
    
    /**
     * 全局方法！
     * 从微信服务器获取 access_token
     */
    public static  function getAccessToken(){
        
        $date_now = date("Y-m-d H:i:s");
        
        //1、如果有没有过期的access_token,就直接返回
        $access_token_info = OauthAccessToken::find()->where(['>','expired_time',$date_now])->limit(1)->one();
        if($access_token_info){ 
            return $access_token_info['access_token'];
        }
        
        
        //2、如果没有，调用接口获取access_token，并保存
        $path = "token?grant_type=client_credential&appid=".self::getAppid()."&secret=".self::getApp_secret();
        $res = self::send($path);
        if(!$res){
            return self::_err(self::getLastErrorMsg());
        }
        //更新保存access_token
        $model_access_token = new OauthAccessToken();
        $model_access_token->access_token = $res['access_token'];
        $model_access_token->expired_time = date("Y-m-d H:i:s",$res['expires_in']+time()-200);
        $model_access_token->created_time = $date_now;
        $model_access_token->save( 0 );
        
        return $res['access_token'];       
        
    }
    /**
     * 封装发送请求，并返回结果
     * @param unknown $path
     * @param unknown $data
     * @param string $method
     * @return boolean|mixed
     */
    public static  function  send($path,$data=[],$method='GET'){
        $request_url = self::$url.$path;
        if($method =="POST"){
            $res = HttpClient::post($request_url, $data);
        }else{
            $res = HttpClient::get($request_url,[]);
        }
        
        $ret =  json_decode($res,true);
         
        //errcode = 0 表示成功
        if(!$ret){
            return self::_err("访问结果为空！！网址错误吧~");
        }
        if( (isset($ret['errcode']) && $ret['errcode'])){
            return self::_err($ret['errmsg'],$ret['errcode']);
        }
        return $ret;
    }
    
    public static function setConfig($appid,$app_token,$app_secret){
        self::$appid = $appid;
        self::$app_token = $app_token;
        self::$app_secret = $app_secret;
    }
    /**
     * @return the $app_token
     */
    public static function getApp_token()
    {
        return RequestService::$app_token;
    }

    /**
     * @return the $appid
     */
    public static function getAppid()
    {
        return RequestService::$appid;
    }

    /**
     * @return the $app_secret
     */
    public static function getApp_secret()
    {
        return RequestService::$app_secret;
    }

    
    
}

