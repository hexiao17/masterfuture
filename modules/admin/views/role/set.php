<?php
use app\common\services\UrlService; 
use app\common\services\UtilService;
use app\common\services\StaticSerivce;
use app\common\services\ConstantMapService;
StaticSerivce::includeAppJsStatic( "/js/admin/role/set.js",\app\assets\AdminAsset::className() );

?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_role.php", ['current' => 'index']); ?>

<div class="row mg-t20 wrap_member_set">
	<div class="col-lg-12">
		<h2 class="text-center">角色设置</h2>
		<div class="form-horizontal m-t">
			<div class="hr-line-dashed"></div>
			<div class="form-group">
				<label class="col-lg-2 control-label">角色名称:</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" placeholder="请输入角色名称" name="name" value="<?=$info?$info['name']:'';?>">
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			
			<div class="form-group">
				<label class="col-lg-2 control-label">角色等级:</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" placeholder="请输入等级，数组越大，权限越高" name="pos" value="<?=$info?$info['pos']:'';?>">
				</div>
			</div> 
			<div class="hr-line-dashed"></div>
			<div class="form-group">
				<label class="col-lg-2 control-label">有效期:(天)</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" placeholder="请输入有效的天数" name="valid_days" value="<?=$info?$info['valid_days']:'';?>">
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<div class="form-group">
				<label class="col-lg-2 control-label">角色分类:(天)</label>
				<div class="col-lg-10">
					 <select name="cate" class="form-control inline">
                                <option value="<?=ConstantMapService::$status_default;?>">请选择状态</option>
                                <?php foreach (ConstantMapService::$role_tab_role_cate_mapping as $val=>$key):?>
                                	<option value="<?=$val;?>" <?php 
                                	if($info){
                                	    if($val==$info['cate'])echo "selected";
                                	}                                	
                                	?>>
                                	<?=$key;?>
                                	</option>
                                 <?php endforeach;?>
                            </select>
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
