<?php
namespace app\modules\weixin\controllers;

use app\common\components\BaseWebController;
use app\common\services\UrlService;
use app\models\book\Book;
use Yii;
use yii\log\FileTarget;
use app\models\market\MarketQrcode;
use app\models\market\QrcodeScanHistory;


class MsgController extends BaseWebController {

 
    /**
     * 用于被微信调用的方法
     *  模拟访问地址
     *  http://mir7878.free.idcfengye.com//weixin/msg/index?signature=c0271aa802a79f51c41f2c520317d62ecb8fe068&echostr=281295117908696383&timestamp=1540611390&nonce=1323804390
     */
    public function actionIndex( ){
    	//微信开发者验证
        if( !$this->checkSignature() ){
            $this->record_log( "校验错误" );
            //可以直接回复空串，微信服务器不会对此作任何处理，并且不会发起重试
            return 'error signature ~~';
        }        
        if( array_key_exists('echostr',$_GET) && $_GET['echostr']){//用于微信第一次认证的
            return $_GET['echostr'];
        }
      /////////////////  
        
        //响应微信的各种消息
        //因为很多都设置了register_globals禁止,不能用$GLOBALS["HTTP_RAW_POST_DATA"];
        $xml_data = file_get_contents("php://input");
        // 		$xml_data = "<xml><ToUserName><![CDATA[gh_1b8810b88bff]]></ToUserName>
        // <FromUserName><![CDATA[ozYoMuN47byYrVbX2qfZYiwkOkks]]></FromUserName>
        // <CreateTime>1507356854</CreateTime>
        // <MsgType><![CDATA[text]]></MsgType>
        // <Content><![CDATA[计算机]]></Content>
        // <MsgId>6474048393773525897</MsgId>
        // </xml>";
        //记录日志
        $this->record_log( "[xml_data]:". $xml_data );
        if( !$xml_data ){
            return 'error xml ~~';
        }       
       
        //解析xml数据
        $xml_obj = simplexml_load_string( $xml_data, 'SimpleXMLElement', LIBXML_NOCDATA);    
        	
        $from_username = $xml_obj->FromUserName;
        $to_username = $xml_obj->ToUserName;
        $msg_type = $xml_obj->MsgType;//信息类型
    
        //设置默认返回信息
        $res = [ 'type'=>'text','data'=>$this->defaultTip() ];
        
        switch ( $msg_type ){
            //设计思路：默认回复为会员的购买信息推送。
            case "text":
                if( $xml_obj->Content == "帮助"){
                  //返回默认的$res
                    
                }else{
                    //$kw = trim( $xml_obj->Content );
                    $res = $this->getDefaultTextReply();
                }
                break;
            //事件类型，比如关注，菜单点击
            case "event":
                $res = $this->parseEvent( $xml_obj );
                break;
            default:
                break;
        }
        //统一处理上面的返回动作
        switch($res['type']){
            case "rich":
                return $this->richTpl($from_username,$to_username,$res['data']);
                break;
            default:
                return $this->textTpl($from_username,$to_username,$res['data']);
        }    
    
        return "hello world";
    }
    
    private function search( $kw ){
        $query = Book::find()->where([ 'status' => 1 ]);
        $where_name = [ 'LIKE','name','%'.strtr( $kw ,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
        $where_tag = [ 'LIKE','tags','%'.strtr( $kw ,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
        $query->andWhere([ 'OR',$where_name,$where_tag ]);
        $res = $query->orderBy([ 'id' => SORT_DESC ])->limit( 3 )->all();
        $data = $res?$this->getRichXml( $res ):$this->defaultTip();
        $type = $res?"rich":"text";
        return ['type' => $type ,"data" => $data];
    }
    /**
     * 发送文本信息的默认回复
     * @param unknown $kw
     */
    private function getDefaultTextReply( ){
        $query = Book::find()->where([ 'status' => 1 ]);       
        $res = $query->orderBy([ 'id' => SORT_DESC ])->limit( 3 )->all();
        $data = $res?$this->getRichXml( $res ):$this->defaultTip();
        $type = $res?"rich":"text";
        return ['type' => $type ,"data" => $data];
    }
    private function parseEvent( $dataObj ){
        $resType = "text";
        $resData = $this->defaultTip();
        $event = $dataObj->Event;
        switch($event){
            //关注
            case "subscribe":    
                $resData = $this->subscribeTips();
                //如果是通过营销二维码来扫描关注的，更新信息
                $event_key  = $dataObj->EventKey;
                if($event_key){
                    $openid = $dataObj->FromUserName;
                    $qrcode_key = str_replace("qrscene_", "", $event_key);
                    $qrcode_info = MarketQrcode::findOne(['id'=>$qrcode_key]);
                    if($qrcode_info){
                        $qrcode_info->total_scan_count +=1;
                        $qrcode_info->updated_time = date("Y-m-d H:i:s");
                        $qrcode_info->update( 0 );
                        
                        //保存记录
                        $model_scan_history = new QrcodeScanHistory();
                        $model_scan_history->openid = $openid;
                        $model_scan_history->qrcode_id = $qrcode_info['id'];
                        $model_scan_history->created_time = date("Y-m-d H:i:s");
                        $model_scan_history->save( 0 );
                    }
                }
                break;
            case "CLICK"://自定义菜单点击类型是CLICK的，可以回复指定内容
                $eventKey = trim($dataObj->EventKey);
                switch($eventKey){
                }
                break;
        }
        return [ 'type'=>$resType,'data'=>$resData ];
    }
    
    //文本内容模板
    private function textTpl( $from_username,$to_username,$content )
    {
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        <FuncFlag>0</FuncFlag>
        </xml>";
        return sprintf($textTpl, $from_username, $to_username, time(), "text", $content);
    }
    
    //富文本
    private function richTpl( $from_username ,$to_username,$data){
        $tpl = <<<EOT
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
%s
</xml>
EOT;
        return sprintf($tpl, $from_username, $to_username, time(), $data);
    }
    
    private function getRichXml( $list ){
        $article_count = count( $list );
        $article_content = "";
        foreach($list as $_item){
            $tmp_description = mb_substr( strip_tags( $_item['summary'] ),0,15,"utf-8" );
            $tmp_pic_url = UrlService::buildPicUrl( "book",$_item['main_image'] );
            $tmp_url = UrlService::buildWebUrl( "/product/info",[ 'id' => $_item['id'] ] );
            $article_content .= "
            <item>
            <Title><![CDATA[{$_item['name']}]]></Title>
            <Description><![CDATA[{$tmp_description}]]></Description>
            <PicUrl><![CDATA[{$tmp_pic_url}]]></PicUrl>
            <Url><![CDATA[{$tmp_url}]]></Url>
            </item>";
        }
    
        $article_body = "<ArticleCount>%s</ArticleCount>
<Articles>
%s
</Articles>";
        return sprintf($article_body,$article_count,$article_content);
    }
    
    /**
     * 默认回复语
     */
    private function defaultTip(){     
        $kefu = \Yii::$app->params['about']['kefu'];
        $kefu_str = "";
     foreach ($kefu as $_e){
            $kefu_str .= <<<EOT
{$_e['nickname']},电话:{$_e['tel']}\n
EOT;
        }
        $resData = <<<EOT
你想要的我们都有,请联系客服:
{$kefu_str}
EOT;
        return $resData;
    }
    
    /**
     * 关注默认提示
     */
    private function subscribeTips(){
         
        $company = \Yii::$app->params['about']['company'];
        $kefu = \Yii::$app->params['about']['kefu'];
        $kefu_str = "";
        foreach ($kefu as $_e){
            $kefu_str .= <<<EOT
{$_e['nickname']},电话:{$_e['tel']}\n
EOT;
        }
        $resData = <<<EOT
感谢您关注{$company}的公众号\n
我们是全国首家与微信深度结合的科技型服务公司，专注服务于长庆油田公开招标，商谈信息。针对长庆油田二级单位的物资采购，工程和服务信息即时免费推送。\n
购买VIP服务后，你能拥有一切~
最新活动：绑定登陆即可试用3天！\n
如有疑问，请联系客服:
{$kefu_str}
EOT;
        return $resData;
    }
    
    public function checkSignature(){
        $signature = trim( $this->get("signature","") );
        $timestamp = trim( $this->get("timestamp","") );
        $nonce = trim( $this->get("nonce","") );
        $tmpArr = array( \Yii::$app->params['weixin']['token'],$timestamp,$nonce );
        sort( $tmpArr,SORT_STRING );
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr ==  $signature ){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 使用日志工具记录微信的响应日志
     * @param unknown $msg
     */
    public   function record_log($msg){
        $log = new FileTarget();
        $log->logFile = \Yii::$app->getRuntimePath() . "/logs/weixin_msg_".date("Ymd").".log";
        $request_uri = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
        $log->messages[] = [
            "[url:{$request_uri}][post:".http_build_query($_POST)."] [msg:{$msg}]",
            1,
            'application',
            microtime(true)
            ];
        $log->export();
    }
}
