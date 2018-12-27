<?php
namespace app\modules\weixin\controllers;

use app\common\components\BaseWebController;
use app\common\services\weixin\RequestService;
use app\common\services\UrlService;
use app\common\services\BaseService;
/**
 * 设置自定义菜单
 * @author Administrator
 *
 */
class MenuController extends BaseWebController
{
    //设置微信自定义菜单
    public function actionSet(){
        $menu = [
            "button"=>[
               [
					"name"       => "商城",
					"type" => "view",
					"url"  => UrlService::buildWebUrl("/default/index")
				],
				[
					"name" => "我",
					"type" => "view",
					"url" => UrlService::buildWebUrl("/user/index")
				]
                
            ]
        ];
        
        $config  = \Yii::$app->params['weixin'];
        RequestService::setConfig($config['appid'], $config['token'], $config['sk']);
        
        $access_token = RequestService::getAccessToken();
        
        if($access_token){
            $url = "menu/create?access_token={$access_token}";
            $ret = RequestService::send($url,json_encode($menu,JSON_UNESCAPED_UNICODE),"POST");            
            if(!$ret){
                if(BaseService::getLastCode() == 48001){
                    echo "微信公众号没有自定义菜单的权限~~";
                }elseif (BaseService::getLastCode() == 0){
                     echo "自定义菜单设置成功~~";
                }
                else{
                    var_dump(BaseService::getLastErrorMsg());
             }              
            } 
            var_dump($ret);
        }       
    }
}

