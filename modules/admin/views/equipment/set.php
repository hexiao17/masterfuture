<?php
use \app\common\services\UrlService;
 
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppCssStatic( "/plugins/treeSelect/css/layui.css",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppCssStatic( "/plugins/tagsinput/jquery.tagsinput.min.css",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/tagsinput/jquery.tagsinput.min.js",\app\assets\AdminAsset::className() );
 
StaticSerivce::includeAppJsStatic( "/js/admin/equipment/set.js",\app\assets\AdminAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_equipment.php", ['current' => 'use_list']); ?>


<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-12">
        <h2 class="text-center">入库信息</h2>
        <div class="form-horizontal m-t">
               
             <div class="form-group">
                <label class="col-lg-2 control-label">选择库存:</label>
                <div class="col-lg-8  ">               
                	<input type="text" id="invent_id" name="invent_id"  placeholder="模糊查询"  class="layui-input" />
                </div>
            </div>            
            <div class="hr-line-dashed"></div>   
               
            <div class="form-group">
                <label class="col-lg-2 control-label">所在单位:</label>
                <div class="col-lg-10">               
                	<input type="text" id="org_tree"  class="layui-input layui-unselect">
                	<input  type="hidden"  name="organize" value=""> 
                </div>
            </div>            
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">使用人:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入使用人" name="use_name" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">领料人:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入领料人" name="receiver" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">发放人:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发放人，不输入，默认为自己" name="send_name" value="">
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
 