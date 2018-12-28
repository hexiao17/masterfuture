<?php
//在php.ini中开启时区，date.timezone=Asia/Shanghai  并没什么卵用
ini_set('date.timezone','Asia/Shanghai');//如果PHP.INI没有指定,在此位临时声明也可以
$isdebug = $_SERVER['SERVER_NAME'] == 'www.4gnote.com'?false:true;
//true=测试环境，false=正式环境
if($isdebug){
    define("ISALIYUN", false);
    defined('YII_DEBUG') or define('YII_DEBUG', false);  //上线要改
    defined('YII_ENV') or define('YII_ENV', 'dev');  //上线要改
    require(__DIR__ . '/../vendor/autoload.php');
    require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
   
}else{
    define("ISALIYUN", true);
    require(__DIR__ . '/../../yii2/vendor/autoload.php');
    require(__DIR__ . '/../../yii2/vendor/yiisoft/yii2/Yii.php');
}

$config = require(__DIR__ . '/../config/web.php');
//加入版本号 RELEASE_VERSION
if(file_exists(__DIR__."/../../release_version/sxyz_version")){
    define('RELEASE_VERSION',trim(file_get_contents(__DIR__."/../../release_version/sxyz_version")));
}else{
    define('RELEASE_VERSION',time());
}
 
(new yii\web\Application($config))->run();
 