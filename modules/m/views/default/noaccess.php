<?php
use app\common\services\UtilService;
use app\common\services\UrlService;
$this->title = "你没有访问权限".Yii::$app->params['title'];
?>

<div style="min-height: 500px;">
    <div class="shop_header">
        <i class="shop_icon"></i>
        <strong>无权访问此页面</strong>
    </div> 
    <div id="slideBox" class="slideBox">
        <div class="bd">
            <ul>           
                <li><?=$msg;?></li>
                <li>
                <?php 
                header("refresh:3;url={$tourl}");
                 print('正在加载，请稍等...<br>三秒后自动跳转到会员购买页面~~~');
                 ?>
                </li>             
            </ul>
        </div>
        <div class="hd"><ul></ul>
        </div>
    </div>
  
    
</div>
