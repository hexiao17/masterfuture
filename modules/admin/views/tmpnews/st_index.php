<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
 
use \app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppCssStatic('/css/layui/layui.css', \app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/layui/layui.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/js/admin/page.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/js/admin/tmpnews/stindex.js",\app\assets\AdminAsset::className() );
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_tmpnews.php", ['current' => 'st']); ?>

<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row  m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline">
                        <option value="<?=ConstantMapService::$status_default;?>">请选择状态</option>
						<?php foreach( $status_mapping as $_status => $_title ):?>
                            <option value="<?=$_status;?>" <?php if( $search_conditions['status']  == $_status):?> selected <?php endif;?> ><?=$_title;?></option>
						<?php endforeach;?>
                    </select>
                </div>
                 
                 
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="标题\发布单位" class="form-control" value="<?=$search_conditions['mix_kw'];?>">
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
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/stnews/set");?>">
                        <i class="fa fa-plus"></i>新闻
                    </a>
                </div>
            </div>
			
        </form>
        <h3>由于采集的时间可能不规则，所以不能以业主发布时间排序，只能发布时手动填写发布时间排序,请按时间先后顺序依次发布</h3>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
            	<th>ID</th>
                <th>新闻标题</th>
                <th>分类名称</th>
                <th>发布人</th>       
                 <th>业主发布时间</th>        
                <th>采集时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
                    <tr>
                    	<td align="center"><input type="checkbox"  name="checkbox" value="<?=$_item['id'];?>" /><?=$_item['id'];?></td>
                        <td><?=UtilService::cutstr($_item['title'],64);?></td>
                        <td><?= $_item['flowname'] ;?></td>
                        <td><?= $_item['username'] ;?></td>  
                         <td><?= $_item['pubtime'];?></td>                     
                        <td><?= $_item['updatetime'];?></td>
                        
                        <td>
                            <a  href="<?=UrlService::buildAdminUrl("/tmpnews/st_info",[ 'id' => $_item['id'] ] );?>">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
							<?php if( $_item['statu'] ):?>
                                <a class="m-l" href="<?=UrlService::buildAdminUrl("/stnews/set",[ 'tmpnews_id' => $_item['id'],'type'=>'st' ]);?>">
                                    <i class="fa fa-edit fa-lg"></i>
                                </a>

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
            <tfoot>
            <tr>
            	<td align="center" width="6%"><input type="checkbox" name="button" id="selAll"  />全选</td>
              <td width="26%"> 
              		<button id="del_btn">点击删除选中的表格 </button>
              </td>  
            </tr>
            </tfoot>
        </table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination2.php", [
			'pages' => $pages,
		    'search_conditions'=>$search_conditions,
			'url' => '/tmpnews/st_index'
		]); ?>

    </div>
</div>

