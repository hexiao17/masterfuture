<?php
use \app\common\services\UrlService;
 
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;

StaticSerivce::includeAppCssStatic( "/plugins/tagsinput/jquery.tagsinput.min.css",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/tagsinput/jquery.tagsinput.min.js",\app\assets\AdminAsset::className() );
 
StaticSerivce::includeAppJsStatic( "/js/admin/inventory/set.js",\app\assets\AdminAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_inventory.php", ['current' => 'inventory']); ?>
<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-12">
        <h2 class="text-center">入库信息</h2>
        <div class="form-horizontal m-t">
               
            <div class="form-group">
                <label class="col-lg-2 control-label">选择计划:</label>
                <div class="col-lg-10">
                	<select	name="plan"  class="form-control" >
                			<option value="">请选择一个计划</option>
                			<?php 
                			foreach ($plans as $plan){
                			         echo  ' <option value="'.$plan->id.'">'.$plan->name.'</option>';
                			}?> 
                			<option value="-1">添加新的计划</option>
                	</select> 
                </div>
            </div>            
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">增加数量:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="updateNum" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">库存地点:</label>
                <div class="col-lg-10">
                	<select	name="inventory_addr"  class="form-control" >
                			<option value="">请选择一个库存地点</option>
                			<?php 
                			foreach ($addrs as $addr){
                			    echo  ' <option value="'.$addr->id.'">'.$addr->factory.'</option>';
                			}?> 
                			<option value="-1">添加新的地点</option>
                	</select>  
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">收货人:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="receiver" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">收货时间:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="receive_time" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
           
            <div class="form-group">
                <label class="col-lg-2 control-label">备注:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="beizhu" value="<?=$info?$info['beizhu']:'';?>"> 
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-lg-4 col-lg-offset-2">
                    
                    <button class="btn btn-w-m btn-outline btn-primary save">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>
 