 <?php
use app\common\services\UrlService;
use app\common\services\UtilService;
\app\assets\FrontAsset::register($this);
?>
<?php  $this->beginContent('@app/modules/front/views/layouts/main.php');?>
<div class="fly-panel fly-column">
	<div class="layui-container">
		<ul class="layui-clear">
			<li class="layui-hide-xs layui-this"><a href="/">首页</a></li>
			<li><a href="jie/index.html">提问</a></li>
			<li><a href="jie/index.html">分享<span class="layui-badge-dot"></span></a></li>
			<li><a href="jie/index.html">讨论</a></li>

			<li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><span
				class="fly-mid"></span></li>

			<!-- 用户登入后显示 -->
			<li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a
				href="user/index.html">我发表的贴</a></li>
			<li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a
				href="user/index.html#collection">我收藏的贴</a></li>
		</ul>

		<div class="fly-column-right layui-hide-xs">
			<span class="fly-search"><i class="layui-icon"></i></span> <a
				href="<?=UrlService::buildFrontUrl('/task/set');?>"
				class="layui-btn">发表新帖</a>
		</div>
		<div class="layui-hide-sm layui-show-xs-block"
			style="margin-top: -10px; padding-bottom: 10px; text-align: center;">
			<a href="<?=UrlService::buildFrontUrl('/task/set');?>"
				class="layui-btn">发表新帖</a>
		</div>
	</div>
</div>
<div class="layui-container">

	<div class="layui-row  layui-col-md-offset3 layui-col-space12">

		<div class=" layui-col-sm4  layui-hide-xs">
			<div class="fly-panel fly-signin">
				<ul class="layui-nav  layui-inline  user_left_nav" lay-filter="user">
					<li class="layui-nav-item  nav_home"><a
						href="<?=UrlService::buildFrontUrl('/user/home');?>"> <i
							class="layui-icon">&#xe609;</i> 我的主页
					</a></li>
					<li class="layui-nav-item nav_index "><a
						href="<?=UrlService::buildFrontUrl('/user/index');?>"> <i
							class="layui-icon">&#xe612;</i> 用户中心
					</a></li>
					<li class="layui-nav-item  nav_set"><a
						href="<?=UrlService::buildFrontUrl('/user/set');?>"> <i
							class="layui-icon">&#xe620;</i> 基本设置
					</a></li>
					<li class="layui-nav-item  nav_cate"><a
						href="<?=UrlService::buildFrontUrl('/user/cate');?>"> <i
							class="layui-icon">&#xe857;</i> 我的分类
					</a></li>

					<li class="layui-nav-item  nav_summary"><a
						href="<?=UrlService::buildFrontUrl('/summary/index');?>"> <i
							class="layui-icon">&#xe611;</i> 我的总结
					</a></li>
					<li class="layui-nav-item  nav_message"><a
						href="<?=UrlService::buildFrontUrl('/user/counter');?>"> <i
							class="layui-icon">&#xe611;</i> 计数器
					</a></li>
				</ul>
				<div class="fly-panel">
					<div class="fly-panel-title">这里可作为广告区域</div>

				</div>

				<div class="fly-panel fly-link">
					<h3 class="fly-panel-title">友情链接</h3>
					<dl class="fly-panel-main">
						<dd>
							<a href="http://www.layui.com/laydate/" target="_blank">layDate</a>
						<dd>				
						
						<dd>
							<a
								href="mailto:xianxin@layui-inc.com?subject=%E7%94%B3%E8%AF%B7Fly%E7%A4%BE%E5%8C%BA%E5%8F%8B%E9%93%BE"
								class="fly-link">申请友链</a>
						<dd>
					
					</dl>
				</div>
			</div>
		</div>
     <?=$content;?> 
  </div>
</div>
<?php $this->endContent();?>