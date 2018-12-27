<?php
use \app\common\services\UrlService;
 
use \app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;
 
StaticSerivce::includeAppJsStatic( "/js/admin/qrcode/set.js",\app\assets\AdminAsset::className() );
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_qrcode.php", ['current' => 'index']); ?>

<div class="row m-t  wrap_qrcode_set">
	<div class="col-lg-12">
		<h2 class="text-center">渠道二维码设置</h2>
		<div class="form-horizontal m-t m-b">
			<div class="form-group">
				<label class="col-lg-2 control-label">渠道名称:</label>
				<div class="col-lg-10">
					<input type="text" name="name" class="form-control" placeholder="请输入渠道名称~~" value="<?=$info?$info['name']:'';?>">
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<div class="form-group">
				<div class="col-lg-4 col-lg-offset-2">
                    <input type="hidden" name="id" value="<?=$info?$info['id']:0;?>">
					<button class="btn btn-w-m btn-outline btn-primary save">保存</button>
				</div>
			</div>
		</div>
	</div>
</div>

