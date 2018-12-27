<?php
use \app\common\services\UrlService;
 
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;

StaticSerivce::includeAppCssStatic( "/plugins/tagsinput/jquery.tagsinput.min.css",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/tagsinput/jquery.tagsinput.min.js",\app\assets\AdminAsset::className() );
 
StaticSerivce::includeAppJsStatic( "/js/admin/plans/set.js",\app\assets\AdminAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_plans.php", ['current' => 'plans']); ?>
<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-12">
        <h2 class="text-center">添加物资计划</h2>
        <div class="form-horizontal m-t">
               
            <div class="form-group">
                <label class="col-lg-2 control-label">投资计划:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入新闻名" name="investment_plan" value="<?=$info?$info['investment_plan']:'';?>">
                </div>
            </div>            
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">设备名称:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="name" value="<?=$info?$info['name']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">设备型号:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="equipment_model" value="<?=$info?$info['equipment_model']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">单位:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="unit" value="<?=$info?$info['unit']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">物资编码:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="material_code" value="<?=$info?$info['material_code']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">单价:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="price" value="<?=$info?$info['price']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">生产厂商:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="produce_company" value="<?=$info?$info['produce_company']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">生产日期:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="produce_date" value="<?=$info?$info['produce_date']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">供货商:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="procure_company" value="<?=$info?$info['procure_company']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">联系电话:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="procure_tel" value="<?=$info?$info['procure_tel']:'';?>">
                </div>
            </div> 
            <div class="hr-line-dashed"></div>
             
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">设备标签:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="equip_params" value="<?=$info?$info['equip_params']:'';?>">
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
                    <input type="hidden" name="id" value="<?=($info&&isset($info['id']))?$info['id']:0;?>">                    
                    
                    <button class="btn btn-w-m btn-outline btn-primary save">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>
 