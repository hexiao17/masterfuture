<?php
$path_const = "/../../masterfuture_bak/config";
$params =  ISALIYUN?require(__DIR__ .$path_const. '/aliyunparams.php'):require(__DIR__ . $path_const.'/test_params.php');
$db = ISALIYUN?require(__DIR__ . $path_const.'/aliyundb.php'):require(__DIR__ . $path_const.'/test_db.php'); 
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            // 初始化项目的cookie
            'cookieValidationKey' => 'ab8U754Poxisx*eRxsYcd',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        //错误处理器
        'errorHandler' => [
             'errorAction' => 'error/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db, 
        'urlManager' => require(__DIR__.$path_const.'/router.php'),
         
    ],
    'params' => $params,
    'modules' => [ 
        //电脑端  前台模块
        'front' => [
            'class' => 'app\modules\front\FrontModule',
        ],    	
    	//手机端 前台模块
        'm' => [
            'class' => 'app\modules\m\MModule',
        ],
        //后台管理模块
        'admin' => [
            'class' => 'app\modules\admin\AdminModule',
        ],
        //微信模块
        'weixin' => [
            'class' => 'app\modules\weixin\WeixinModule',
        ],
    ],
];
    
if (!ISALIYUN) { //这里会显示调试信息
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
         'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
         'allowedIPs' => ['*', '::1'],
    ];
}

return $config;
