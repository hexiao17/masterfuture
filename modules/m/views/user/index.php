<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;
use app\assets\MAsset;
StaticSerivce::includeAppJsStatic('/js/web/user/index.js',MAsset::className());
$this->title = "你的主页.".Yii::$app->params['title'];
?>
<div class="mem_info">
	<span class="m_pic"><img
		src="<?=UrlService::buildPicUrl( "avatar",$current_user['avatar'] );?>" /></span>
	<p>
	
	
	<p class="name">欢迎您，<?=UtilService::encode( $this->params['current_user']["nickname"] );?> <br />
		<a href="<?=UrlService::buildMUrl("/product/index");?>"> <span
			style="color: red;">
       		<?=UtilService::encode( $this->params['current_user_role']["name"] );?>
         .到期时间:<?=UtilService::encode( $this->params['current_user']["expired_time"] );?>
         .续费
        	</span>
		</a>
	</p>
	</p>
</div>
<div class="fastway_list_box">
	<ul class="fastway_list">
		<li><a href="<?=UrlService::buildMUrl("/product/index");?>"><b
				class="sales_icon"></b><i class="right_icon"></i><span style="color:red;">会员购买</span></a></li>
		<li><a href="<?=UrlService::buildMUrl("/product/cart");?>"><b
				class="wl_icon"></b><i class="right_icon"></i><span>购物车</span></a></li>
		<li><a href="<?=UrlService::buildMUrl("/user/order");?>"><b
				class="morder_icon"></b><i class="right_icon"></i><span>我的订单</span></a></li>
		<li><a href="<?=UrlService::buildMUrl("/user/fav");?>"><b
				class="fav_icon"></b><i class="right_icon"></i><span>我的关注</span></a></li>
		
		<li><a href="<?=UrlService::buildMUrl("/user/address");?>"><b
				class="locate_icon"></b><i class="right_icon"></i><span>公司地址</span></a></li>
		<li><a href="<?=UrlService::buildNullUrl();?>" class="do_invitate"><b
				class="locate_icon"></b><i class="right_icon"> </i><span style="color:red;">推荐好友加入</span></a></li>		
				<!-- <li><a href="<?=UrlService::buildMUrl("/user/comment");?>"><b
				class="sales_icon"></b><i class="right_icon"></i><span>我的评论</span></a></li>
				 -->
	</ul>
</div>
