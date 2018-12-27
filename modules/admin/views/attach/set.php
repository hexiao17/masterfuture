<?php
use \app\common\services\UrlService;
 
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;
 
StaticSerivce::includeAppJsStatic( "/plugins/ueditor/ueditor.config.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/ueditor/ueditor.all.min.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/ueditor/lang/zh-cn/zh-cn.js",\app\assets\AdminAsset::className() );

StaticSerivce::includeAppCssStatic( "/plugins/tagsinput/jquery.tagsinput.min.css",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/tagsinput/jquery.tagsinput.min.js",\app\assets\AdminAsset::className() );

 
StaticSerivce::includeAppJsStatic( "/js/admin/zbnews/set.js",\app\assets\AdminAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_news.php", ['current' => 'zbnews']); ?>
<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-12">
        <h2 class="text-center">新闻设置</h2>
        <div class="form-horizontal m-t">
               
            <div class="form-group">
                <label class="col-lg-2 control-label">新闻名称:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入新闻名" name="title" value="<?=$info?$info['title']:'';?>">
                </div>
            </div>            
            <div class="hr-line-dashed"></div>
          <div class="form-group">
                <label class="col-lg-2 control-label">发布单位:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布单位" name="pub_company" value="<?=$info?$info['pub_company']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">过期时间:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入过期时间,请注意格式是:2017-11-01" name="expired_time" value="<?=$info&&$info['expired_time']?$info['expired_time']:date('Y-m-d');?>">
                </div>
            </div>
             <div class="form-group">
                <label class="col-lg-2 control-label">发布时间:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入发布时间" name="pub_time" value="<?=$info&&$info['pub_time']?$info['pub_time']:date('Y-m-d');?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">内容描述:</label>
                <div class="col-lg-8">
                    <textarea   id="editor"  name="content" style="height: 300px;"><?=$info?$info['content']:'';?></textarea>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
             
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">新闻标签:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="tags" value="<?=$info?$info['tags']:'';?>">
                </div>
            </div>
             <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">附件ID:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="file_key" value="<?=$info?$info['file_key']:'';?>">一般不用管
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-lg-4 col-lg-offset-2">
                    <input type="hidden" name="id" value="<?=($info&&isset($info['id']))?$info['id']:0;?>">
                    <input type="hidden" name="tmpnews_id" value="<?=$tmpnews_id?$tmpnews_id:0;?>">
                    
                    <button class="btn btn-w-m btn-outline btn-primary save">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>

<iframe name="upload_file" class="hide"></iframe>
