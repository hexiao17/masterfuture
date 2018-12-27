<?php
use \app\common\services\UrlService;
use app\common\services\UtilService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppJsStatic( "/js/web/weixin.js",\app\assets\MAsset::className() );
StaticSerivce::includeAppJsStatic( "/js/web/user/invitate.js",\app\assets\MAsset::className() );
$this->title = "油田招标商谈信息聚合平台,你的生意来了~".Yii::$app->params['title'];

?>
<style>
<!--
ul.licss{ margin:0 auto; background:url(ul-bg.gif); width:400px; text-align:left} 
/* 背景只引人图片 不用设置其它参数即可对象内全屏平铺 */ 
ul.licss li{ width:100%; text-indent:10px; height:34px; line-height:34px;color:red} 
/* 高度需要计算好，与布局图片一定关系 */ 
ul.licss li:hover{ background:#EBEBEB} 
 
/* 为了有动感背景变色换色，对li设置hover伪类 */ 
-->
</style>
<div class="row m-t  wrap_qrcode_set ">
	<div class="col-lg-12">
		<div  style="height: 20px"></div>
		<div class="form-horizontal m-t m-b text-center">
			 <img  src="<?=UrlService::buildWwwUrl( "/default/qrcode",[ 'qr_code_url' => $data['qrcode'],'s'=>7 ] );?>"/><br/>
			<h3>微信扫描二维码关注，免费试看3天！</h3>
		</div>
	</div> 
</div>
		
            <?php if ($ismy):?>
            <div  class="text-center">            
                  <span style="color: red;">
        	 		特别提醒：请点击右上角按钮,然后分享到朋友圈。
        	 	 </span>
    	 	 </div>
             <div style="height:10px; " ></div>
           	 <div style="margin:0 auto;width:500px; " >  
            	<p class="name"> 
            		 <h3>你的推广成绩(通过扫描你的二维码)：</h3>
            		 <div  >
                		 <ul class="licss">                		 
                		 <li>关注的人数:<?=$data['total_scan_count'];?>人</li>            		 
                         <li>注册的人数:<?=$data['total_reg_count'];?>人</li>
                         <li>购买的会员:<?=$data['total_pay_count'];?>人</li>
                         </ul>
                         <small>注意：成功购买会员的才算哦~<br/>另外：推荐二维码成功关注的数量，我们也会不定期的发送福利哦 </small>
                     </div>
            		 <h5>需要立即返现的，请拨打客服电话！029-86638831</h5>
            	</p> 
           	 </div>
            <?php else:?>
              <div  class="text-center">
                 <span style="color: red;">
        	 		试用方法：请长按二维码，点击识别二维码，关注，然后绑定登录。
        	 	 </span> 
    	 	 </div>
            <?php endif;?> 
 
<div class="layout_hide_wrap hidden">
	<!-- 分享参数 -->
    <input type="hidden" id="share_info" value='<?=Yii::$app->getView()->params['share_info'];?>'>
</div>

