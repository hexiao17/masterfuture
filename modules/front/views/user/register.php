<?php
 
use \app\common\services\UrlService;
use app\common\services\StaticSerivce;
//通用校验js
StaticSerivce::includeAppJsStatic( "/js/validate.js",\app\assets\FrontAsset::className() );
StaticSerivce::includeAppJsStatic( "/js/front/user/reg.js",\app\assets\FrontAsset::className() );
$this->title =  '为了账户安全,请先验证！'.Yii::$app->params['title'];
?>
<div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li><a href="<?=UrlService::buildFrontUrl('/user/login');?>">登入</a></li>
        <li class="layui-this">注册</li>
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <div class="layui-form layui-form-pane  front_user_reg">
          
              <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">手机号</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_email" name="mobile"   autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">将会成为您唯一的登入名</div>
              </div>
               
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_pass" name="login_pwd"  autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_repass" name="repass"   autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">验证码</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_vercode" name="vercode"   placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">
                  <img src="<?=UrlService::buildWwwUrl("/default/img_captcha");?>" onclick="this.src='<?=UrlService::buildWwwUrl("/default/img_captcha");?>?'+Math.random();"/>
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">短信验证码</label>
                <div class="layui-input-inline">
                  <input type="text" id="captcha_code" name="captcha_code"   placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">
                  <button type="button" class="btn get_captcha">获取验证码</button>
                </div>
              </div>
              
              
              <div class="layui-form-item">
                <button class="layui-btn reg" lay-filter="*" lay-submit>立即注册</button>
              </div>
              <div class="layui-form-item fly-form-app">
                <span>或者直接使用社交账号快捷注册</span>
                <a href="" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" class="iconfont icon-qq" title="QQ登入"></a>
                <a href="" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" class="iconfont icon-weibo" title="微博登入"></a>
              </div>
             
          </div>
        </div>
      </div>
    </div>
  </div>