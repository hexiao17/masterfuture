<?php
namespace app\modules\admin\controllers;

use app\modules\admin\controllers\common\BaseAdminController;
use app\common\services\weixin\RequestService;
use app\common\services\BaseService;
use app\common\services\UrlService;
use yii\log\FileTarget;
use app\models\book\Book;
use app\models\market\MarketQrcode;
use app\models\market\QrcodeScanHistory;
/**
 * 涉及微信的相关方法
 * ：因为要在后台统一管理，所有搬到这里
 * admin :操作主页
 * menu_set:菜单设置 
 * 
 * @author Administrator
 *
 */
class WeixinController extends BaseAdminController{
    
    public function actionAdmin(){
        
        return $this->render('admin');
    }
    
    /**
     * 菜单设置
     * 还需改进
     */
    public function actionMenu_set(){        
    $menu = [
            "button"=>[
               [
					"name" => "公司简介",
					"type" => "view",
					"url"  =>UrlService::buildWebUrl('/default/index')
				],
                [
                "name" => "服务APP",
                "type" => "view",
                "url"  => UrlService::buildWebUrl('/zbnews/index')
                ],
				[
					"name" => "绑定",
					"type" => "view",
					"url" => UrlService::buildWebUrl("/user/bind")
				]
                
            ]
        ];
        
        $config  = \Yii::$app->params['weixin'];
        RequestService::setConfig($config['appid'], $config['token'], $config['sk']);
        
        $access_token = RequestService::getAccessToken();
        
        if($access_token){
            $url = "menu/create?access_token={$access_token}";
            $ret = RequestService::send($url,json_encode($menu,JSON_UNESCAPED_UNICODE),"POST");            
            $msg = "没有设置成功，产生意外了";
            if($ret){                
                if(BaseService::getLastCode() == 48001){
                   $msg = "微信公众号没有自定义菜单的权限~~";
                }elseif (BaseService::getLastCode() == 0){                   
                    $msg="自定义菜单设置成功~~";                     
                }else{
                     $msg=BaseService::getLastErrorMsg();
                } 
            } 
            return  $this->renderJs($msg, UrlService::buildAdminUrl('/weixin/admin'));            
        }  
    }
   
    
    
}

