 <?php
	use \app\common\services\UrlService;
	use \app\common\services\UtilService;
	 \app\assets\FrontAsset::register($this);
?>
<?php  $this->beginContent('@app/modules/front/views/layouts/main.php');?>
 <div class="layui-container fly-marginTop fly-user-main">
  <ul class="layui-nav layui-nav-tree layui-inline  user_left_nav" lay-filter="user">
    <li class="layui-nav-item  nav_home">
      <a href="<?=UrlService::buildFrontUrl('/user/home');?>">
        <i class="layui-icon">&#xe609;</i>
        我的主页
      </a>
    </li>
    <li class="layui-nav-item nav_index ">
      <a href="<?=UrlService::buildFrontUrl('/user/index');?>">
        <i class="layui-icon">&#xe612;</i>
        用户中心
      </a>
    </li>
    <li class="layui-nav-item  nav_set">
      <a href="<?=UrlService::buildFrontUrl('/user/set');?>">
        <i class="layui-icon">&#xe620;</i>
        基本设置
      </a>
    </li>
    <li class="layui-nav-item  nav_cate">
      <a href="<?=UrlService::buildFrontUrl('/user/cate');?>">
        <i class="layui-icon">&#xe857;</i>
        我的分类
      </a>
    </li>
    
     <li class="layui-nav-item  nav_message">
      <a href="<?=UrlService::buildFrontUrl('/user/message');?>">
        <i class="layui-icon">&#xe611;</i>
        我的总结
      </a>
    </li>
     <li class="layui-nav-item  nav_message">
      <a href="<?=UrlService::buildFrontUrl('/user/message');?>">
        <i class="layui-icon">&#xe611;</i>
        我的消息
      </a>
    </li>
  </ul>

  <div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
  </div>
  <div class="site-mobile-shade"></div>
  
  <div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
  </div>
  <div class="site-mobile-shade"></div>
  
     <?=$content;?> 
 
</div> 
<?php $this->endContent();?>