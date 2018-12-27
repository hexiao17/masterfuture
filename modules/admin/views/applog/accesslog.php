<?php
use app\common\services\UrlService;
use app\common\services\UtilService;

use app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppCssStatic('/css/layui/layui.css', \app\assets\AdminAsset::className());
StaticSerivce::includeAppJsStatic("/plugins/layui/layui.js", \app\assets\AdminAsset::className());
StaticSerivce::includeAppJsStatic("/js/admin/page.js", \app\assets\AdminAsset::className());
StaticSerivce::includeAppJsStatic("/js/admin/applog/access.js", \app\assets\AdminAsset::className());
?> 
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_applog.php", ['current' => 'accesslog']); ?>

<div class="row">
	<div class="col-lg-12">
		<form class="form-inline wrap_search">
			<div class="row  m-t p-w-m">
				<div class="form-group">
					<div class="input-group">
						<input type="text" name="uid" placeholder="用户ID"
							class="form-control" value="<?=$search_conditions['uid'];?>">
					</div>
					<div class="input-group">
						<input type="text" name="created_time" placeholder="起始时间"
							class="form-control"
							value="<?=$search_conditions['created_time'];?>"> <span
							class="input-group-btn">
							<button type="button" class="btn  btn-primary search">
								<i class="fa fa-search"></i>搜索
							</button>
						</span>
					</div>
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="col-lg-12">
					<a class="btn btn-w-m btn-outline btn-primary pull-right"
						href="<?=UrlService::buildAdminUrl("/stnews/set");?>"> <i
						class="fa fa-plus"></i>新闻
					</a>
				</div>
			</div>

		</form>
		<table
			class="table table-bordered m-t col-lg-12 table-fixed table-break">
			<thead>
				<tr>
					<th class="applog_table-td10">访问用户</th>
					<th class="applog_table-td10">ip</th>
					<th class="applog_table-td20">来源地址</th>
					<th class="applog_table-td10">去向地址</th>
					<th class="applog_table-td20">参数</th>
					<th class="applog_table-td20">ua</th>
					<th>时间</th>
				</tr>
			</thead>
			<tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
                    <tr>
					<td><?= $_item['uid'];?></td>
					<td><?= $_item['ip'] ;?></td>
					<td><?= $_item['referer_url'] ;?></td>
					<td><?= $_item['target_url'];?></td>
					<td><?= $_item['query_params'];?></td>
					<td><?= $_item['ua'];?></td>
					<td><?= $_item['created_time'];?></td>
				</tr>
				<?php endforeach;?>
			<?php else:?>
                <tr>
					<td colspan="6">暂无数据</td>
				</tr>
			<?php endif;?>
            </tbody>
		</table>
		<?php

echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination2.php", [
    'pages' => $pages,
    'search_conditions' => $search_conditions,
    'url' => '/applog/accesslog'
]);
?>

    </div>
</div>
