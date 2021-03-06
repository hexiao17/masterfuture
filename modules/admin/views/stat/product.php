<?php
use \app\common\services\UrlService;
 
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;
 
StaticSerivce::includeAppJsStatic( "/plugins/highcharts/highcharts.js",\app\assets\AdminAsset::className() );

StaticSerivce::includeAppCssStatic( "/plugins/datetimepicker/jquery.datetimepicker.min.css",\app\assets\AdminAsset::className() );

StaticSerivce::includeAppJsStatic( "/plugins/datetimepicker/jquery.datetimepicker.full.min.js",\app\assets\AdminAsset::className() );


StaticSerivce::includeAppJsStatic( "/js/admin/chart.js",\app\assets\AdminAsset::className() );
StaticSerivce::includeAppJsStatic( "/js/admin/stat/product.js",\app\assets\AdminAsset::className() );
?>

<?php echo Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_stat.php",[ 'current' => 'product' ]);?>

<div class="row m-t">
	<div class="col-lg-12 m-t">
		<form class="form-inline" id="search_form_wrap">
			<div class="row p-w-m">
				<div class="form-group">
					<div class="input-group">
						<input type="text" placeholder="请选择开始时间" name="date_from" class="form-control"  value="<?=$search_conditions['date_from'];?>">
					</div>
				</div>
				<div class="form-group m-r m-l">
					<label>至</label>
				</div>
				<div class="form-group">
					<div class="input-group">
						<input type="text" placeholder="请选择结束时间" name="date_to" class="form-control" value="<?=$search_conditions['date_to'];?>">
					</div>
				</div>
				<div class="form-group">
					<a class="btn btn-w-m btn-outline btn-primary search">搜索</a>
				</div>
			</div>
			<hr/>
		</form>
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>日期</th>
				<th>图书名称</th>
				<th>当日销售数量</th>
				<th>当日销售总额</th>
			</tr>
			</thead>
			<tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
					<tr>
						<td><?=$_item['date'];?></td>
						<td>
							<?php if(  $_item['book_info'] ):?>
								<a href="<?=UrlService::buildAdminUrl("/book/info",[ 'id' => $_item['book_id'] ]);?>"><?=UtilService::encode( $_item['book_info']['name'] );?></a>
							<?php endif;?>
						</td>
						<td><?=$_item['total_count'];?></td>
						<td><?=$_item['total_pay_money'];?></td>
					</tr>
				<?php endforeach;?>
			<?php else:?>
				<tr> <td colspan="5">暂无数据</td> </tr>
			<?php endif;?>
			</tbody>
		</table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination.php", [
			'pages' => $pages,
			'url' => '/stat/product'
		]); ?>
	</div>
</div>
