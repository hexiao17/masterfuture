<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
 
use \app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppCssStatic('/css/layui/layui.css', \app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/plugins/layui/layui.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/js/admin/page.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/js/admin/plans/index.js",\app\assets\AdminAsset::className() );
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_plans.php", ['current' => 'plans']); ?>

</style>
<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row  m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline">
                        <option value="<?=ConstantMapService::$status_default;?>">请选择状态</option>
						<?php foreach( $status_mapping as $_status => $_title ):?>
                            <option value="<?=$_status;?>" <?php if( $search_conditions['statu']  == $_status):?> selected <?php endif;?> ><?=$_title;?></option>
						<?php endforeach;?>
                    </select>
                </div>
                 
                 
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="设备名称\型号" class="form-control" value="<?=$search_conditions['mix_kw'];?>">
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
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/plans/set");?>">
                        <i class="fa fa-plus"></i>计划
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
            	<th>ID</th>
            	<th class="applog_table-td10">计划名称</th>
                <th >名称</th>               
                <th class="applog_table-td10">型号</th>
                <th  >单位</th>
                <th class="applog_table-td10">物资编码</th>
                <th  >单价</th>
                <th class="applog_table-td10">生产厂家</th>
                <th class="applog_table-td10">生产时间</th>
                <th class="applog_table-td10">创建人</th>
                <th class="applog_table-td10">创建时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
                    <tr>
                    <td><?= $_item['id'];?></td>
                        <td><?= $_item['investment_plan'];?></td>                         
                        <td><?= $_item['name'] ;?></td>
                        <td><?= $_item['equipment_model'] ;?></td>
                        <td><?= $_item['unit'];?></td>
                        <td><?= $_item['material_code'];?></td>
                        <td><?= $_item['price'];?></td>
                        <td><?= $_item['produce_company'];?></td>
                        <td><?= $_item['produce_date'];?></td>
                        <td><?= $_item['created_user'];?></td>
                        <td><?= $_item['created_time'];?></td>                        
                        <td>
                            <a  href="<?=UrlService::buildAdminUrl("/plans/info",[ 'id' => $_item['id'] ] );?>">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
							<?php if( $_item['statu'] ):?>
                                <a class="m-l" href="<?=UrlService::buildAdminUrl("/plans/set",[ 'id' => $_item['id'] ]);?>">
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
        </table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination2.php", [
			'pages' => $pages,
		    'search_conditions'=>$search_conditions,
			'url' => '/zbnews/index'
		]); ?>

    </div>
</div>
 