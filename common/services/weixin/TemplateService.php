<?php

namespace app\common\services\weixin;

use app\common\services\BaseService;
use app\common\services\DataHelper;
use app\common\services\UrlService;
use app\models\book\Book;
use app\models\member\Member;
use app\models\member\OauthMemberBind;
use \app\models\pay\PayOrder;
use app\models\pay\PayOrderItem;
use Yii;
use app\models\market\QrcodeScanHistory;
use app\models\market\MarketQrcode;
use app\models\member\MemberAddress;

/**
 * 要注意 $template_id  哪里来的
 * @author Administrator
 *
 */
class TemplateService extends  BaseService
{
    /**
     * 支付完成提醒
     */
    public static function payNotice( $pay_order_id ){

        $pay_order_info =PayOrder::findOne( $pay_order_id );
        
        if( !$pay_order_info ){
            return false;
        } 
		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] ); 
        $open_id = self::getOpenId( $pay_order_info['member_id'] ); 
        if(!$open_id){
            return  false;
        } 
		$template_id = \Yii::$app->params['weixin']['notice_config']['pay_template_id'];
        $pay_money = $pay_order_info["pay_price"];
        
        $member = Member::findOne(['id'=>$pay_order_info->member_id]);
        
        //---更新推广数量,为什么在这里，因为他要获取openid 
        //步奏是：根据openid 查询他是扫描的那个二维码（注意时间排序，以最新的为准）
        $scan_info = QrcodeScanHistory::find()->where([ 'openid' => $open_id ])->orderBy(['id'=>SORT_DESC])->one();
          if(  $scan_info ){        
            $qrcode_info = MarketQrcode::find()->where([ 'id' => $scan_info['qrcode_id'] ])->one(); 
            if( $qrcode_info ){
                 $qrcode_info->total_pay_count += 1;
                 $qrcode_info->update( 0 );
            } 
        }
        //-- 
        
        $data = [
            "first" => [
                "value" => "尊敬的{$member->nickname}, 恭喜您会员购买/续费成功！",
                "color" => "#173177"
            ],
			"keyword1" =>[
				"value" => $member->nickname,
				"color" => "#173177"
			],
            "keyword2" =>[
                "value" => $pay_order_info->note,
                "color" => "#173177"
            ],
            "keyword3" =>[
                "value" => $pay_money,
                "color" => "#173177"
            ],
            "keyword4" =>[
                "value" => date("Y-m-d H:i",strtotime( $pay_order_info['pay_time'] ) ),
                "color" => "#173177"
            ],
            "remark" => [
                "value" => "订单编号:".$pay_order_info->order_sn.",点击查看详情",
                "color" => "#173177"
            ]
        ];

        return self::send($open_id,$template_id,UrlService::buildWebUrl( "/user/index" ),$data);
    }

	/**
	 * 发货通知提醒
	 */
	public static function expressNotice( $pay_order_id ){

		$pay_order_info = PayOrder::findOne( $pay_order_id );
		if( !$pay_order_info ){
			return self::_err( "订单不存在~~" );
		}

		$pay_order_items = PayOrderItem::find()->where([ 'pay_order_id' => $pay_order_id ])->all();
		if( !$pay_order_items ){
			return self::_err( "订单不存在~~" );
		}

		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );

		$open_id = self::getOpenId( $pay_order_info['member_id'] );
		if( !$open_id ){
			return self::_err( "openid 没找到~~" );
		}

		$template_id = \Yii::$app->params['weixin']['notice_config']['express_template_id'];
		$pay_money = $pay_order_info["pay_price"];

		$book_items = [];
		$book_mapping = DataHelper::getDicByRelateID( $pay_order_items,Book::className(),"target_id","id",[ 'name' ] );
		foreach( $pay_order_items as $_pay_order_item_info ){
			if( !isset( $book_mapping[ $_pay_order_item_info['target_id'] ]) ){
				continue;
			}
			$book_items[] = $book_mapping[ $_pay_order_item_info['target_id'] ]['name'];
		}
        
		//memeber
		$member = Member::findOne(['id'=>$pay_order_info->member_id]);
		
		$address_info = MemberAddress::findOne(['id'=>$pay_order_info->express_address_id]);
		
		$data = [
			"first" => [
				"value" => "尊敬的{$member->nickname}, 你的发票已邮寄",
				"color" => "#173177"
			],
			"keyword1" =>[
			    "value" => $pay_order_info->express_info,
			    "color" => "#173177"
			],
			"keyword2" =>[
			    "value" => $address_info->nickname,
			    "color" => "#173177"
			],
			"keyword3" =>[
			    "value" => $address_info->mobile,
			    "color" => "#173177"
			],
			"keyword4" =>[
			    "value" => $address_info->address,
			    "color" => "#173177"
			],			 
			"remark" => [
				"value" => "请注意查收,如有疑问,请联系客服妹妹",
				"color" => "#173177"
			]
		];

		return self::send($open_id,$template_id,UrlService::buildWebUrl( "/user/index" ),$data);
	}

	/**
	 * 微信绑定通知提醒
	 */
	public static function bindNotice( $member_id ){

		$member_info  = Member::findOne( [ 'id' => $member_id ] );
		if( !$member_info ){
			return false;
		}

		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );

		$open_id = self::getOpenId( $member_id );
		if(!$open_id){
			return false;
		}

		 $template_id = \Yii::$app->params['weixin']['notice_config']['bind_template_id'];

		$data = [
			"first" => [
				"value" => "您好，您已注册并成功绑定微信",
				"color" => "#173177"
			],
			"keyword1" =>[
				"value" => $member_info['mobile'],
				"color" => "#173177"
			],
		    "keyword2" =>[
		        "value" => $member_info['nickname'],
		        "color" => "#173177"
		    ],
			"keyword3" =>[
				"value" => date("Y-m-d H:i",strtotime( $member_info['created_time'] ) ),
				"color" => "#173177"
			],
			"remark" => [
				"value" => "感谢您支持".Yii::$app->params['title'],
				"color" => "#173177"
			]
		];

		return self::send($open_id,$template_id,UrlService::buildWebUrl( "/user/index" ),$data);
	}
    /**
     * 新闻更新提醒
     * @param unknown 
     */
	public static function newsUpdateNotice( $data ){
	    $member_info  = Member::findOne( [ 'mobile' => $data['mobile'] ] );
	    if( !$member_info ){
	        return false;
	    }
	    
	    $config = \Yii::$app->params['weixin'];
	    RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );
	    
	    $open_id = self::getOpenId( $member_info->id );
	    if(!$open_id){
	        return false;
	    }
	    
	    $template_id = \Yii::$app->params['weixin']['notice_config']['newsUpdate_template_id'];
	    
	    $data = [
	        "first" => [
	            "value" => "您好，您订购的招标信息已更新！",
	            "color" => "#173177"
	        ],
	        "keyword1" =>[
	            "value" => date("Y-m-d",time() )."更新",
	            "color" => "#173177"
	        ],
	       
	        "keyword2" =>[
	            "value" => $data['content'],
	            "color" => "#173177"
	        ],
	        "remark" => [
	            "value" => "感谢您支持".Yii::$app->params['title'],
	            "color" => "#173177"
	        ]
	    ];
	    
	    return self::send($open_id,$template_id,UrlService::buildWebUrl( "/zbnews/index" ),$data);
	    
	}
	
	/**
	 * 服务暂停通知
	 * @param unknown
	 */
	public static function stopServiceNotice( $data ){
		$member_info  = Member::findOne( [ 'mobile' => $data['mobile'] ] );
		if( !$member_info ){
			return false;
		}
		 
		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );
		 
		$open_id = self::getOpenId( $member_info->id );
		if(!$open_id){
			return false;
		}
		 
		$template_id = \Yii::$app->params['weixin']['notice_config']['stopService_id'];
		 
		$data = [
				"first" => [
						"value" =>   $data['first'],
						"color" => "#173177"
				],
				"keyword1" =>[
						"value" =>  $data['two'],
						"color" => "#173177"
	        ],
	
			 "keyword2" =>[
								"value" => $data['three'],
										"color" => "#173177"
								],
			 "remark" => [
								"value" =>  $data['four'],
										"color" => "#173177"
								]
		    ];
						 
		    return self::send($open_id,$template_id,UrlService::buildWebUrl( "/zbnews/index" ),$data);
		     
	}
	/*
	 * 会员过期提醒
	 */
	public static function memberExpiredNotice( $data ){
	    $member_info  = $data;
	     
	    $config = \Yii::$app->params['weixin'];
	    RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );
	     
	    $open_id = self::getOpenId( $member_info['id'] );
	    if(!$open_id){
	        return false;
	    }
	    //过期模板
	    $template_id = $config['notice_config']['member_expired_id'];
	   
	    $data = [
	        "first" => [
	            "value" => "陕西易中信息科技，提醒您:".$member_info['nickname'],
	            "color" => "#173177"
	        ], 
	        "name" =>[
	            "value" =>"招标、商谈信息[会员服务]",
	            "color" => "#173177"
	        ],
	        "expDate" =>[
	            "value" => $member_info['expired_time'],
	            "color" => "#173177"
	        ],
	        "remark" => [
	            "value" => "请即时点击续费，以免贻误商机！",
	            "color" => "#173170"
	        ]
	    ];
	     
	    return self::send($open_id,$template_id,UrlService::buildWebUrl( "/product/index" ),$data);
	     
	}
	
	/**
	 * 推广成绩提醒
	 * @param unknown
	 */
	public static function invitateUserNotice( $data ){
	    $member_info  = Member::findOne( [ 'mobile' => $data['mobile'] ] );
	    if( !$member_info ){
	        return false;
	    }
	     
	    $config = \Yii::$app->params['weixin'];
	    RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );
	     
	    $open_id = self::getOpenId( $member_info->id );
	    if(!$open_id){
	        return false;
	    }
	     
	    $template_id = \Yii::$app->params['weixin']['notice_config']['newsUpdate_template_id'];
	     
	    $data = [
	        "first" => [
	            "value" => "你的推广奖励已发放！",
	            "color" => "#173177"
	        ],
	        "keyword1" =>[
	            "value" => "时间:".$data['invitate_time'],
	            "color" => "#173177"
	        ],
	
	            "keyword2" =>[
	            "value" => "成功邀请[".$data['invitate_user']."],奖励会员时长:".$data['invitate_add']."天",
	                "color" => "#173177"
	        ],
	                "remark" => [
	                    "value" => "请继续加油哦，感谢您支持".Yii::$app->params['title'],
	                    "color" => "#173177"
	                    ]
	                    ];
	                     
		    return self::send($open_id,$template_id,UrlService::buildWebUrl( "/zbnews/index" ),$data);
		  
		}
	
    /**
     * 获取微信公众平台的微信公众号id
     */
    protected static function getOpenId( $member_id ){
        $open_infos = OauthMemberBind::findAll([ 'member_id' => $member_id,'type' => 1 ]);

        if( !$open_infos ){
            return false;
        }

        foreach($open_infos as $open_info){
            if( self::getPublicByOpenId($open_info['openid']) ) {
                return $open_info['openid'];
            }
        }
        return false;
    }

    public  static function send($openid,$template_id,$url,$data){
        $msg = [
            "touser" => $openid,
            "template_id" => $template_id,
            "url" => $url,
            "data" => $data
        ];

        $token = RequestService::getAccessToken();
        
        return RequestService::send("message/template/send?access_token=".$token,json_encode( $msg ),'POST');
    }


    protected static function getPublicByOpenId($openid){
        $token = RequestService::getAccessToken();
		$info = RequestService::send("user/info?access_token={$token}&openid={$openid}&lang=zh_CN","GET");
        if(!$info || isset($info['errcode']) ){
            return false;
        }

        if($info['subscribe']){
            return true;
        }
        return false;
    }
}

