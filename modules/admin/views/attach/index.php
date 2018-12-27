<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
 
use \app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppCssStatic('/css/layui/layui.css', \app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/layui/layui.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/js/admin/page.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/js/admin/attach/index.js",\app\assets\AdminAsset::className() );
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_attach.php", ['current' => 'attach']); ?>

</style>
<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row  m-t p-w-m">
            		<div class="form-group">
                            <select name="status" class="form-control inline">
                                <option value="<?=ConstantMapService::$status_default;?>">请选择状态</option>
                                <?php foreach ($status_mapping as $statu=>$title):?>
                                	<option value="<?=$statu;?>" <?php if($statu==$search_conditions['status'])echo "selected";?>><?=$title;?></option>
                                 <?php endforeach;?>
                            </select>
                    </div>
                   <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="新闻ID\附件名称" class="form-control" value="<?=$search_conditions['mix_kw'];?>">
                        <span class="input-group-btn">
                            <button type="button" class="btn  btn-primary search">
                                <i class="fa fa-search"></i>搜索
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/attach/set");?>">
                        <i class="fa fa-plus"></i>附件
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th class="applog_table-td10">ID</th>               
                <th class="applog_table-td10">新闻ID</th>
                <th class="applog_table-td20">附件名称</th>
                <th class="applog_table-td30">下载地址</th>              
                <th class="applog_table-td10">创建时间</th>
                 <th  >下载次数</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
                    <tr>
                        <td><?= $_item['id'];?></td>                         
                        <td><?= $_item['oldnews_id'] ;?></td>
                        <td><?= $_item['attach_name'] ;?></td>
                        <td><?= $_item['attach_down_url'];?></td>
                        <td><?= $_item['created_time'];?></td>
                        <td><?= $_item['down_count'];?></td>
                        <td>
                           
							<?php if( $_item['status'] ):?>
                            

                                <a class="m-l remove" href="<?=UrlService::buildNullUrl();?>" data="<?=$_item['id'];?>">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
							<?php else:?>
                                <a class="m-l recover" href="<?=UrlService::buildNullUrl();?>" data="<?=$_item['id'];?>">
                                    <i class="fa fa-rotate-left fa-lg"></i>
                                </a>
							<?php endif;?>
                        </td>
                    </tr>
				<?php endforeach;?>
			<?php else:?>
                <tr><td colspan="6">暂无数据</td></tr>
			<?php endif;?>
            </tbody>
        </table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination2.php", [
			'pages' => $pages,
		    'search_conditions'=>$search_conditions,
			'url' => '/attach/index'
		]); ?>

    </div>
</div>
 