 <?php
	use \app\common\services\UrlService;
	use \app\common\services\UtilService;
	//注册默认的css和js
	\app\assets\FrontAsset::register($this);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=$this->title;//Yii::$app->params['title'];?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="keywords" content="fly,layui,前端社区">
  <meta name="description" content="Fly社区是模块化前端UI框架Layui的官网社区，致力于为web开发提供强劲动力">
	<?php $this->head() ?>
</head>
<body style="height: auto;">
<?php $this->beginBody() ?>
<div class="fly-header layui-bg-black">
  <div class="layui-container">
    <a class="fly-logo" href="<?=UrlService::buildWWWUrl('/');?>">
      <img src="<?=UrlService::buildBaseUrl('/').'images/logo.png';?>" alt="layui">
    </a>
    <ul class="layui-nav fly-nav layui-hide-xs">
      <li class="layui-nav-item layui-this">
        <a href="<?=UrlService::buildWWWUrl('/');?>"><i class="iconfont icon-jiaoliu"></i>动态</a>
      </li>
      <li class="layui-nav-item layui-this">
        <a href="<?=UrlService::buildFrontUrl('/task/index');?>"><i class="iconfont icon-jiaoliu"></i>任务</a>
      </li>
      <li class="layui-nav-item">
        <a href="<?=UrlService::buildFrontUrl('/share/index');?>"><i class="iconfont icon-iconmingxinganli"></i>分享</a>
      </li> 
     
    </ul>
    
    <ul class="layui-nav fly-nav-user">
      
      <!-- 未登入的状态 -->
      <?php if(!isset(\Yii::$app->view->params['current_user'])):?>
      <li class="layui-nav-item">
        <a class="iconfont icon-touxiang layui-hide-xs" href="user/login.html"></a>
      </li>
      <li class="layui-nav-item">
        <a href="<?=UrlService::buildFrontUrl('/user/login');?>">登入</a>
      </li>
      <li class="layui-nav-item">
        <a href="<?=UrlService::buildFrontUrl('/user/reg');?>">注册</a>
      </li>
      <li class="layui-nav-item layui-hide-xs">
        <a href="/app/qq/" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" title="QQ登入" class="iconfont icon-qq"></a>
      </li>
      <li class="layui-nav-item layui-hide-xs">
        <a href="/app/weibo/" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" title="微博登入" class="iconfont icon-weibo"></a>
      </li>
      <?php else:?>
      <!-- 登入后的状态 -->      
     <li class="layui-nav-item">
        <a class="fly-nav-avatar" href="javascript:;">
          <?php $login_user = \Yii::$app->view->params['current_user'];
                $user_role = \Yii::$app->view->params['current_user_role'];
          ?>
          <cite class="layui-hide-xs"><?=$login_user['nickname'];?></cite>
          <i class="iconfont icon-renzheng layui-hide-xs" title="过期时间"></i>
          <i class="layui-badge fly-badge-vip layui-hide-xs"><?=$user_role['name'];?></i>
          <img src="<?=UrlService::buildPicUrl( "avatar",$login_user['avatar'] );?>">
        </a>
        <dl class="layui-nav-child">
          <dd><a href="<?=UrlService::buildFrontUrl('/user/set',['id'=>$login_user['id']])?>"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
          <dd><a href="<?=UrlService::buildFrontUrl('/message/index',['user_id'=>$login_user['id']])?>"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>
          <dd><a href="<?=UrlService::buildFrontUrl('/user/home',['id'=>$login_user['id']])?>"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
          <hr style="margin: 5px 0;">
          <dd><a href="<?=UrlService::buildAdminUrl('/dashboard/index')?>"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>后台管理</a></dd>
          <dd><a href="<?=UrlService::buildFrontUrl('/user/logout');?>" style="text-align: center;">退出</a></dd>
        </dl>
      </li>
   	<?php endif;?>
    </ul>
  </div>
</div>


     <?=$content;?>

<div class="site-tree-mobile layui-hide">
  <i class="layui-icon"></i>
</div>

<div class="fly-footer">
  <p><a href="http://fly.layui.com/" target="_blank">Fly社区</a> 2017 &copy; <a href="http://www.layui.com/" target="_blank">layui.com 出品</a></p>
  <p>
    <a href="http://fly.layui.com/jie/3147/" target="_blank">付费计划</a>
    <a href="http://www.layui.com/template/fly/" target="_blank">获取Fly社区模版</a>
    <a href="http://fly.layui.com/jie/2461/" target="_blank">微信公众号</a>
  </p>
</div>
 

<?php $this->endBody() ?>
 
<script>
 
// layui.cache.page = '';
// layui.cache.user = {
//   username: '游客'
//   ,uid: -1
//   ,avatar: '../res/images/avatar/00.jpg'
//   ,experience: 83
//   ,sex: '男'
// };
// layui.config({
//   version: "3.0.0"
//   ,base: './res/mods/' //这里实际使用时，建议改成绝对路径
// }).extend({
//   fly: 'index'
// }).use('fly');
</script>

</body>
</html>
<?php $this->endPage() ?>