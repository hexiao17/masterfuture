 <?php
	use \app\common\services\UrlService;
	use \app\common\services\UtilService;
	//\app\assets\MAsset::register($this);
	
	//取得配置，交给隐藏表单，然后传递给 common_ops.buildPicUrl 使用
	$upload_config = Yii::$app->params['upload'];
?>
<?php  $this->beginContent('@app/modules/m/views/layouts/main.php');?>
 
   <div class="weui-tab   "> 
       <?=$content;?>
 
      <div class="weui-tabbar weui-footer weui-footer_fixed-bottom ">
        <a href="<?=UrlService::buildMUrl('/default/index');?>" class="weui-tabbar__item nav_default">
          
          <div class="weui-tabbar__icon">
            <img src="/images/m/icon_nav_button.png" alt="">
          </div>
          <p class="weui-tabbar__label">首页</p>
        </a>
        <a href="<?=UrlService::buildMUrl('/equip/info');?>" class="weui-tabbar__item  nav_equip">
          <div class="weui-tabbar__icon">
            <img src="/images/m/icon_nav_msg.png" alt="">
          </div>
          <p class="weui-tabbar__label">设备</p>
        </a>
        <a href="<?=UrlService::buildMUrl('/task/index');?>" class="weui-tabbar__item nav_task">
        <!-- 代办 -->
        <span class="weui-badge" style="position: absolute;top: -.4em;right: 1em;">8</span>
          <div class="weui-tabbar__icon">
            <img src="/images/m/icon_nav_article.png" alt="">
          </div>
          <p class="weui-tabbar__label">任务</p>
        </a>
        <a href="<?=UrlService::buildMUrl('/user/home');?>" class="weui-tabbar__item nav_user">
          <div class="weui-tabbar__icon">
            <img src="/images/m/icon_nav_cell.png" alt="">
          </div>
          <p class="weui-tabbar__label">我</p>
        </a>
      </div>
    </div>
    <div class="hidden_layout_warp hide">
	<!-- value的值一定要用单引号 -->
	<input type="hidden" name="upload_config" value='<?=json_encode($upload_config);?>' />
	</div>
<?php $this->endContent();?>

<div style="height: 800px;"></div>