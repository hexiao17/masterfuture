<?php
 //微信资源文件管理
namespace app\assets;

use yii\web\AssetBundle;


class MAsset extends AssetBundle
{

    public function registerAssetFiles($view)
    {
        //版本号需要计算，或者有其他计算逻辑的时候得这样写
        $release_version = defined('RELEASE_VERSION')?RELEASE_VERSION:time();
        $this->css = [
            'css/m/weui.min.css',             
            'css/m/jquery-weui.min.css',
            'css/m/mini.css?ver='.$release_version,           
        ];
        
        $this->js=[
           // 'http://res.wx.qq.com/open/js/jweixin-1.2.0.js',
            'js/jquery/jquery.min.js', 
            'js/m/jquery-weui.js',
            'js/m/fastclick.js',
            'js/m/common.js?ver='.$release_version, 
        ];
        
        
        parent::registerAssetFiles($view); // TODO: Change the autogenerated stub
    }

}
