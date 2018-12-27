<?php
use \app\common\services\UrlService; 
use app\common\services\StaticSerivce;
 
StaticSerivce::includeAppJsStatic( "/js/m/equip/info.js",\app\assets\MAsset::className() );
$this->title =  Yii::$app->params['title'];
?>
<header class='demos-header'>
      <h1 class="demos-title"><?=$class_info->equipment_model;?></h1>
    </header>

    <div class="weui-cells">
      <div class="weui-cell weui-cell_access">
        <div class="weui-cell__bd"><?=$class_info->name;?></div>
        <div class="weui-cell__ft" style="font-size: 0">
          <span id="m-equip-toclass" style="vertical-align:middle; font-size: 17px;" data="<?=$class_info->id;?>">详细信息</span>
          <span class="weui-badge weui-badge_dot" style="margin-left: 5px;margin-right: 5px;"></span>
        </div>
      </div>
    </div> 
    <div class="weui-cells">
      <div class="weui-cell">
        <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
          <?php if($equip_info->image):?>
          <img src="<?=UrlService::buildPicUrl('equipment', $equip_info->image);?>" style="width: 50px;display: block">
          <?php else:?>
          <img src="/images/m/default_equip.png" style="width: 50px;display: block">          
          <?php endif;?>
        </div>
        <div class="weui-cell__bd">
          <p>使用人:<?=$use_log->use_name;?></p>
          <p style="font-size: 13px;color: #888888;"><?=$equip_info->equip_params;?></p>
        </div>
      </div>
      <div class="weui-cell weui-cell_access">
        <div class="weui-cell__bd">
          <span style="vertical-align: middle">出厂日期：<?=$class_info->produce_date;?></span>
          <span class="weui-badge" style="margin-left: 5px;">已使用<?=$use_long; ?>年</span>
          
        </div> 
      </div>
      <div class="weui-cell weui-cell_access">
        <div class="weui-cell__bd">
          <span style="vertical-align: middle">责任单位:<?=$org_info->name;?> </span>
        </div> 
      </div>
      <div class="weui-cell weui-cell_access">
        <div class="weui-cell__bd">
          <span style="vertical-align: middle">维修记录</span>
          <span class="weui-badge" style="margin-left: 5px;">New</span>
        </div>
        <div class="weui-cell__ft"></div>
      </div>
    </div>
   
   <!-- 操作按钮 --> 
   <div class='demos-content-padded'>
      <a href="javascript:;" id='show-actions'  data="<?=$equip_info->id; ?>" class="weui-btn weui-btn_primary">操作</a> 
    </div>
 
 <div class="page__bd">
      <div class="weui-panel weui-panel_access">
        <?php $orders = $equip_info->getOrders(1)->all();
        
            if($orders):
        ?>
        <div class="weui-panel__hd">待处理故障列表</div>
        <div class="weui-panel__bd">
        <?php foreach ($orders as $_order):?>
          <a href="<?=UrlService::buildMUrl('/order/info',['id'=>$_order['id']]);?>" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
              <img class="weui-media-box__thumb" src="<?=UrlService::buildPicUrl('equipment', $_order['image']);?>" alt="">
            </div>
            <div class="weui-media-box__bd">
              <h4 class="weui-media-box__title"><?=$_order['book_time'];?></h4>
              <p class="weui-media-box__desc"><?=nl2br($_order['content']);?></p> 
            </div>
          </a> 
        <?php endforeach;?>
        
        
        </div>
        <?php endif;?>
        <div class="weui-panel__ft">
          <a href="javascript:void(0);" class="weui-cell weui-cell_access weui-cell_link">
            <div class="weui-cell__bd">查看全部</div>
            <span class="weui-cell__ft"></span>
          </a>    
        </div>
      </div>
 
 
 
 </div>
 
 