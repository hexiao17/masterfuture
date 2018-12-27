<?php
 
use \app\common\services\UrlService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppJsStatic( "/js/m/user/login.js",\app\assets\MAsset::className() );
$this->title =  '为了账户安全,请先验证！'.Yii::$app->params['title'];
?>

	<header class='demos-header'>
      <h1 class="demos-title">登陆</h1>
    </header>
   

    <div class="weui-cells__title">表单</div>
    <div class="weui-cells weui-cells_form  m-user-login-form">
      
      <div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd">
          <label class="weui-label">手机号</label>
        </div>
        <div class="weui-cell__bd">
          <input class="weui-input" type="tel" name="mobile" placeholder="请输入手机号">
        </div> 
      </div>
      <div class="weui-cells__tips">请使用手机号和密码登录</div> 
      <div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd">
          <label class="weui-label">密码</label>
        </div>
        <div class="weui-cell__bd">
          <input class="weui-input" type="password" name="login_pwd" placeholder="请输入密码">
        </div> 
      </div>
      <div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
        <div class="weui-cell__bd">
          <input class="weui-input" type="text" name="img_captcha" placeholder="请输入验证码">
        </div>
        <div class="weui-cell__ft">
          <img class="weui-vcode-img" src="<?=UrlService::buildWwwUrl("/default/img_captcha");?>"  onclick="this.src='<?=UrlService::buildWwwUrl("/default/img_captcha");?>?'+Math.random();">
        </div>
      </div>
    </div>
     

    <label for="weuiAgree" class="weui-agree">
      <input id="weuiAgree" type="checkbox" class="weui-agree__checkbox">
      <span class="weui-agree__text">
        阅读并同意<a href="javascript:void(0);">《相关条款》</a>
      </span>
    </label>
	<input class="hide_wrap" type="hidden" name="referer" value="">
    <div class="weui-btn-area m-user-login-btn">
      <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>
    </div>