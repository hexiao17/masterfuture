<?php
use \app\common\services\UrlService;
 
use app\common\services\StaticSerivce;
StaticSerivce::includeAppJsStatic( "/js/web/user/fav.js",\app\assets\WebAsset::className() );
$this->title = Yii::$app->params['title'];
?>
<?php if( $list ):?>
<ul class="fav_list">
	<?php foreach( $list as $_item ):?>
	<li>
		<?php if($_item['type'] == 'zb'):?>
			<a href="<?=UrlService::buildWebUrl("/zbnews/info",[ 'id' => $_item['newlist_id'] ]);?>">
		<?php else: ?>
			<a href="<?=UrlService::buildWebUrl("/stnews/info",[ 'id' => $_item['newlist_id'] ]);?>">
		<?php endif;?>			
			<h2><?=$_item["title"];?></h2>
			<b>¥ <?=$_item["pub_company"];?>/<?=$_item["expired_time"];?></b>
		</a>
		 
		<span class="del_fav" xtype="<?=$_item['type'];?>" data="<?=$_item["newlist_id"];?>"><i class="del_fav_icon"></i></span>
	</li>
	<?php endforeach;?>
</ul>
<?php else:?>
    <div class="no-data">
        啥都没有，你瞅撒
    </div>
<?php endif;?>
