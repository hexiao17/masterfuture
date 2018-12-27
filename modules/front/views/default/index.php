<?php
use app\common\services\UtilService;
use app\common\services\UrlService;
use app\common\services\StaticSerivce;
use app\assets\FrontAsset;
 
StaticSerivce::includeAppJsStatic("/js/front/default/index.js", FrontAsset::className());
$this->title = Yii::$app->params['title'].'成就你的未来！';
?>

<div style="min-height: 500px;max-width:6210px;">
    <div class="shop_header">
        <i class="shop_icon"></i>
        <strong><?//=UtilService::encode($info['name']); ?></strong>
    </div>

    <div class="fastway_list_box">
      
          <?//=$info['description']; ?></li>
       
    </div>
</div>