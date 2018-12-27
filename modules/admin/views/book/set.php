<?php
use \app\common\services\UrlService;
 
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;
 
StaticSerivce::includeAppJsStatic( "/plugins/ueditor/ueditor.config.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/ueditor/ueditor.all.min.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/ueditor/lang/zh-cn/zh-cn.js",\app\assets\AdminAsset::className() );

StaticSerivce::includeAppCssStatic( "/plugins/tagsinput/jquery.tagsinput.min.css",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/tagsinput/jquery.tagsinput.min.js",\app\assets\AdminAsset::className() );

StaticSerivce::includeAppCssStatic( "/plugins/select2/select2.min.css",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/select2/select2.pinyin.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/select2/zh-CN.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/select2/pinyin.core.js",\app\assets\AdminAsset::className() );

StaticSerivce::includeAppJsStatic( "/js/admin/book/set.js",\app\assets\AdminAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_book.php", ['current' => 'book']); ?>
<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-12">
        <h2 class="text-center">商品设置</h2>
        <div class="form-horizontal m-t">
            <div class="form-group">
                <label class="col-lg-2 control-label">产品分类:</label>
                <div class="col-lg-10">
                    <select name="cat_id" class="form-control">
                        <option value="0">请选择分类</option>
                        <?php foreach( $cat_list as $_cat_info ):?>
                            <option value="<?=$_cat_info['id'];?>" <?php if( $info &&  $_cat_info['id'] == $info['cat_id'] ):?> selected <?php endif;?> ><?=UtilService::encode( $_cat_info['name'] );?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">产品名称:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入商品名" name="name" value="<?=$info?$info['name']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div> 
            <div class="form-group">
                <label class="col-lg-2 control-label">商品原价:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入商品售价" name="origin_price" value="<?=$info?$info['origin_price']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">销售价格:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入商品售价" name="price" value="<?=$info?$info['price']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">封面图:</label>
                <div class="col-lg-10">
                    <form class="upload_pic_wrap" target="upload_file" enctype="multipart/form-data" method="POST" action="<?=UrlService::buildAdminUrl("/upload/pic");?>">
                        <div class="upload_wrap pull-left">
                            <i class="fa fa-upload fa-2x"></i>
                            <input type="hidden" name="bucket" value="book" />
                            <input type="file" name="pic" accept="image/png, image/jpeg, image/jpg,image/gif">
                        </div>
                        <?php if( $info && $info['main_image'] ):?>
                        <span class="pic-each">
							<img src="<?=UrlService::buildPicUrl("book",$info['main_image']);?>" alt="120*200">
							<span class="fa fa-times-circle del del_image" data="<?=$info['main_image'];?>"><i></i></span>
						</span>
                        <?php endif;?>
                    </form>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">产品描述:</label>
                <div class="col-lg-8">
                    <textarea   id="editor"  name="summary" style="height: 300px;"><?=$info?$info['summary']:'';?></textarea>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">库存:</label>
                <div class="col-lg-2">
                    <div class="input-group">
                        <div class="input-group-addon hidden">
                            <a class="disabled" href="<?=UrlService::buildNullUrl();?>">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                        <input type="text" name="stock" class="form-control" value="<?=$info?$info['stock']:1;?>">
                        <div class="input-group-addon hidden">
                            <a href="<?=UrlService::buildNullUrl();?>">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">商品标签:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="tags" value="<?=$info?$info['tags']:'';?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">关联的角色:</label>
                <div class="col-lg-10">
                    <select name=related_role_id class="form-control">
                        <option value="0">请选择角色</option>
                        <?php foreach( $role_list as $_role_info ):?>
                            <option value="<?=$_role_info['id'];?>" <?php if( $info &&  $_role_info['id'] == $info['related_role_id'] ):?> selected <?php endif;?> ><?=UtilService::encode( $_role_info['name'] );?></option>
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

<iframe name="upload_file" class="hide"></iframe>
