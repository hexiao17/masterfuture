<?php
use app\common\services\UrlService;
$tab_list = [
    'admin' => [
        'title' => '微信管理',
        'url' => '/weixin/admin'
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