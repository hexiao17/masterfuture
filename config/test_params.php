<?php 
define("SERVER_URL", "http://masterfuture.com"); 
//define("SERVER_URL", "http://999love1.vicp.net:20170"); 
//测试url
//define("SERVER_URL", "http://mir7878.free.idcfengye.com");
//web页面的参数在 命令行下面获取不到
return [
    'title'=>'人生规划',
    'desc' =>'掌控时间，规划未来，治愈懒癌患者',
    'author'=>'一棒尻你脑壳上',
    //定义绝对地址，在UrlService中使用
     'domain'=>[
         'base'=>SERVER_URL,
         'www'=>SERVER_URL.'',
         'admin'=>SERVER_URL.'/admin',    
         'front'=>SERVER_URL.'/front',
         'm'=>SERVER_URL.'/m',
     ],
    //avatar,brand,task,share,equipment
    'upload'=>[
        'avatar'=>'/uploads/avatar',
        'brand'=>'/uploads/brand',
        'task'=>'/uploads/task',
        'share'=>'/uploads/share',
        'equipment'=>'/uploads/equipment', 
    ],
      //角色配置
    'role'=>[       
        //默认
        'default'=>[
            'role_id'=>'1',
        ]
        
    ],
    //默认用户状态,0表示需要后台激活才能使用
    'user_active'=>0,
    //微信 基本配置/ 填写服务器配置
    //url http://www.gupingku.com/app/weixin/msg/index
     "weixin"=>[
        "appid"=>'wx0087476f4108ddc5',
        //appsecret 
        "sk" =>"2ce2ff7b9e3cc8b1484a36c378fe53d1",
        "token"=>"0d54d96346d6d850295bb813f406300c",
        "aeskey"=>"ugweOVefOkYVku2NO2G6FurkEAtgeYqmvZaqqcZPM21",
        'pay' => [//微信支付里面
			'key' => '根据实际情况填写',   //key设置路径：微信商户平台(pay.weixin.qq.com)-->账户设置-->API安全-->密钥设置
			'mch_id' => '根据实际情况填写', //商户号
			'notify_url' => [
				'm' => '/pay/callback' //通知地址,接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数。
			]
		],
         //消息提醒的模板id(公众号-模板消息)
         'notice_config'=>[
             'pay_template_id'=>'tlhAvCXaK7q3bbRU6fn7InJvbMTNKir3KOrsCRX0RHE',
             'express_template_id'=>'Cm0CZ_w89vIBLjST90yyFQUm_h77DjKAD5PtPQD_OFU',
             'bind_template_id'=>'cwvYlH89Ppj1Xa_64jV9AJ0hqnvmre9UFUFUbmGl5hA',
             'newsUpdate_template_id'=>'xQNiP23ZHEk334Q8wiiDJDlEUsyY1klZqfRs7VWaWWY',
             'member_expired_id'=>'Sh3vWiXQcAiPCtY4tR64BQLwKpEdcw0qDDoslga-kYk'
         ],
        
    ],
       'sms'=>[
        //更新通知
        'send_sms'=>[
            'accessKeyId'=>'LTAIOkyMMjrJTyHe',
            'accessKeySecret'=>'Df9KXuUWqr5J02t2fTt4weVIG2Qazl',
            'template_id'=>'SMS_106955100',
            'qianming'=>'易中招标信息网'
        ],    
         //过期短信通知
           'expired_sms'=>[
               'accessKeyId'=>'LTAIOkyMMjrJTyHe',
               'accessKeySecret'=>'Df9KXuUWqr5J02t2fTt4weVIG2Qazl',
               'template_id'=>'SMS_126865684',
               'qianming'=>'易中招标信息网'
           ],
        //验证码
        'captcha'=>[
            'accessKeyId'=>'LTAIOkyMMjrJTyHe',
            'accessKeySecret'=>'Df9KXuUWqr5J02t2fTt4weVIG2Qazl',
            'template_id'=>'SMS_106940092',
            'qianming'=>'易中招标信息网',
              'dailyCanDo'=>'10' //每天可用的验证码条数
        ],
        
    ],
    
    //默认的新闻分类
    'news_cate'=>['招标','商谈','公告','邀请招标'],
    
    //客服联系方式
    'about'=>[
        'nickname'=>'小慧',
        'tel'=>'029-86638831',
        'company'=>'陕西易中信息技术有限公司',
    ]
    
    
];
