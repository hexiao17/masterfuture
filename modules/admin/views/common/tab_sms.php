<?php
use app\common\services\UrlService;
$tab_list = [
    'wx_index' => [
        'title' => '微信通知列表',
        'url' => '/notice/index_wx'
    ],

    'sms_index' => [
        'title' => '短信通知列表',
        'url' => '/notice/index_sms'
    ],
    'wx_wh' => [
        'title' => '维护通知(微信)',
        'url' => '/notice/set_wh'
    ]
];
?>
<div class="row  border-bottom">
	<div class="col-lg-12">
		<div class="tab_title">
			<ul class="nav nav-pills">
				<?php foreach( $tab_list as  $_current => $_item ):?>
				<li <?php if( $current == $_current ):?> class="current"
					<?php endif;?>><a
					href="<?=UrlService::buildAdminUrl( $_item['url'] );?>"><?=$_item['title'];?></a>
				</li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
</div>