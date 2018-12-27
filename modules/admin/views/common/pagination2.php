<?php
use \app\common\services\UrlService;
//需要在view 页面引入几个东西
// StaticSerivce::includeAppCssStatic('/css/layui/layui.css', \app\assets\AdminAsset::className() );
// StaticSerivce::includeAppJsStatic( "/plugins/layui/layui.js",\app\assets\AdminAsset::className() );
// StaticSerivce::includeAppJsStatic( "/js/admin/page.js",\app\assets\AdminAsset::className() );
?>
<div class="row " >
    <div class="col-lg-12">
        <div id="page_demo"></div> 
    </div>
</div>

<div style="display: none;"  >
 	<input type="hidden" id="_url" value='<?=$url;?>' />	 
	<input type="hidden" id="_pages" value='<?=json_encode($pages);?>' />	 
	<input type="hidden" id="_queryParam" value='<?=json_encode($search_conditions);?>' />
</div>