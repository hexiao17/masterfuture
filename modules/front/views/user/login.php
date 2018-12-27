<?php
 
use \app\common\services\UrlService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppJsStatic( "/js/front/user/login.js",\app\assets\FrontAsset::className() );
$this->title =  '为了账户安全,请先验证！'.Yii::$app->params['title'];
?>
<div class="fly-panel fly-panel-user" pad20>
	<div class="layui-tab layui-tab-brief" lay-filter="user">
		<ul class="layui-tab-title">
			<li class="layui-this">登入</li>
			<li><a href="<?=UrlService::buildFrontUrl('/user/reg');?>">注册</a></li>
			<li><a href="<?=UrlService::buildAdminUrl('/user/login');?>">后台登录</a></li>
		</ul>
		<div class="layui-form layui-tab-content" id="LAY_ucm"
			style="padding: 20px 0;">
			<div class="layui-tab-item layui-show">
				<div class="layui-form layui-form-pane">
					<form method="post" class="login_form_wrap">
						<div class="layui-form-item">
							<label for="L_email" class="layui-form-label">手机号</label>
							<div class="layui-input-inline">
								<input type="text" id="L_email" name="mobile"   autocomplete="off" class="layui-input">
							</div>
						</div>
						<div class="layui-form-item">
							<label for="L_pass" class="layui-form-label">密码</label>
							<div class="layui-input-inline">
								<input type="password" id="L_pass" name="login_pwd"   autocomplete="off" class="layui-input">
							</div>
						</div>
						<div class="layui-form-item">
							<label for="L_vercode" class="layui-form-label">人类验证</label>
							<div class="layui-input-inline">
								<input type="text" id="L_vercode" name="img_captcha"   autocomplete="off"
									class="layui-input">
							</div>
							<div class="layui-form-mid">							 
								<img id="img_captcha" src="<?=UrlService::buildWwwUrl("/default/img_captcha");?>" onclick="this.src='<?=UrlService::buildWwwUrl("/default/img_captcha");?>?'+Math.random();"/>
							</div>
						</div>
						<div class="layui-form-item">
							<button class="layui-btn dologin"   >立即登录</button>
							<span style="padding-left: 20px;"> <a href="forget.html">忘记密码？</a>
							</span>
						</div>
						<div class="layui-form-item fly-form-app">
							<span>或者使用社交账号登入</span> <a href=""
								onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})"
								class="iconfont icon-qq" title="QQ登入"></a> <a href=""
								onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})"
								class="iconfont icon-weibo" title="微博登入"></a>
						</div>						
					</form>
					<input class="hide_wrap" type="hidden" name="referer" value="">
				</div>
			</div>
		</div>
	</div>
</div>