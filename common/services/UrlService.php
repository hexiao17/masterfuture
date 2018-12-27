<?php

namespace app\common\services;


//构建连接
use yii\helpers\Url;

class UrlService
{
    //构建网站主页
    public static function buildBaseUrl($path,$params=[]){
        $domain_cofig= \Yii::$app->params['domain'];
        $path=   Url::toRoute(array_merge([$path],$params));
        return $domain_cofig['base'].$path;
    }
    
    //构建电脑前端  所有连接
    public static function buildFrontUrl($path,$params=[]){
        $domain_cofig= \Yii::$app->params['domain'];
        $path=Url::toRoute(array_merge([$path],$params));
        return $domain_cofig['front'].$path;
    }
    //构建 微信端的所有连接
    public static function buildMUrl($path,$params=[]){
        $domain_cofig= \Yii::$app->params['domain'];
        $path=Url::toRoute(array_merge([$path],$params));
        return $domain_cofig['m'].$path;
    }
    
    //构建admin的所有连接
    public static function buildAdminUrl($path,$params=[]){
        $domain_cofig= \Yii::$app->params['domain'];
        $path=   Url::toRoute(array_merge([$path],$params));

        return $domain_cofig['admin'].$path;
    }

    //构建官网的所有连接
    public static function buildWWWUrl($path,$params=[]){
        $domain_cofig= \Yii::$app->params['domain'];
        $path=   Url::toRoute(array_merge([$path],$params));
        return  $domain_cofig['www'].$path;
    }

    //构建空连接
    public static function buildNullUrl(){

        return "javascript:void(0);";
    }
    
    public static function buildPicUrl($bucket,$image_key){
        $domain_config = \Yii::$app->params['domain'];
        $upload_config = \Yii::$app->params['upload'];
        return $domain_config['www'].$upload_config[$bucket]."/".$image_key;
    }
    
    
    
}