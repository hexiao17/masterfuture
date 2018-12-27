<?php
use app\common\services\UrlService;
 
    $tab_list = [
        "account"=>[
            "title"=>"系统账户",
            "url"=>"/account/index"
        ],    
        "member"=>[
            "title"=>"普通会员",
            "url"=>"/member/index"
        ], 
        "trial"=>[
            "title"=>"试用记录",
            "url"=>"/member/trial"
        ],
    	 "orderupdate"=>[
    		 "title"=>"订单更新记录",
    		 "url"=>"/member/orderupdate"
    		],
    ];
 
 ?>
 
 
    <div class="row  border-bottom">
            <div class="col-lg-12">
                <div class="tab_title">
                    <ul class="nav nav-pills">
                    	<?php foreach ($tab_list as $_current =>$_item):?>
                    
                        <li  <?php if($current == $_current) echo 'class="current"';?> >
                            <a href="<?=UrlService::buildAdminUrl($_item['url']);?>"><?=$_item['title'];?></a>
                        </li>
                        <?php endforeach;?>
                        
                    </ul>
                </div>
            </div>
        </div>