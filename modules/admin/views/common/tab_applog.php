<?php
use app\common\services\UrlService;

$tab_list = [
    "accesslog" => [
        "title" => "访问日志",
        "url" => "/applog/accesslog"
    ],
    "errorlog" => [
        "title" => "错误日志",
        "url" => "/applog/errorlog"
    ]
];

?>


<div class="row  border-bottom">
	<div class="col-lg-12">
		<div class="tab_title">
			<ul class="nav nav-pills">
                    	<?php foreach ($tab_list as $_current =>$_item):?>
                    
                        <li
					<?php if($current == $_current) echo 'class="current"';?>><a
					href="<?=UrlService::buildAdminUrl($_item['url']);?>"><?=$_item['title'];?></a>
				</li>
                        <?php endforeach;?>
                        
                    </ul>
		</div>
	</div>
</div>