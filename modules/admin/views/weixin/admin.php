<?php
use app\common\services\UrlService;
use app\common\services\UtilService;

use app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;

StaticSerivce::includeAppJsStatic("/js/admin/member/index.js", \app\assets\AdminAsset::className());
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_weixin.php", ['current' => 'admin']); ?>

<div class="row">
	<div class="col-lg-12">
		<form class="form-inline wrap_search">
			<div class="row  m-t p-w-m"></div>
			<hr />
			<div class="row">
				<div class="col-lg-12">

					<a class="btn btn-w-m btn-outline btn-primary "
						href="<?=UrlService::buildAdminUrl("/weixin/menu_set");?>"> <i
						class="fa fa-plus"></i>菜单设置
					</a>
				</div>
			</div>

		</form>

	</div>
</div>
