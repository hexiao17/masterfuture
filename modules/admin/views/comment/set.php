<?php
use \app\common\services\UrlService;
 
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppCssStatic( "/plugins/select2/select2.min.css",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/select2/select2.pinyin.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/select2/zh-CN.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/select2/pinyin.core.js",\app\assets\AdminAsset::className() );

StaticSerivce::includeAppJsStatic( "/js/admin/comment/set.js",\app\assets\AdminAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_comment.php", ['current' => 'set']); ?>
<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-12">
        <h2 class="text-center">模拟评论</h2>
        <div class="form-horizontal m-t">
            <div class="form-group">
                <label class="col-lg-2 control-label">选择产品:</label>
                <div class="col-lg-10">
                    <select name="book" class="form-control">
                        <option value="0">请选择产品</option>
                        <?php foreach( $book_list as $_book_info ):?>
                            <option value="<?=$_book_info['id'];?>" <?php if( $info &&  $_book_info['id'] == $info['book_id'] ):?> selected <?php endif;?> ><?=UtilService::encode( $_book_info['name'] );?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            
            <div class="hr-line-dashed"></div> 
            <div class="form-group">
                <label class="col-lg-2 control-label">评分:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="评分0-10" name="score" value="<?=$info?$info['score']:'';?>">
                </div>
            </div> 
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">评论:</label>
                <div class="col-lg-8">
                    <textarea   id="editor"  name="content" style="height: 100px;width:100%;"><?=$info?$info['content']:'';?></textarea>
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
 
