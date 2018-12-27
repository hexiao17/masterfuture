<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
 
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_inventory.php", ['current' => 'inventory']); ?>
<style type="text/css">
	.wrap_info img{
		width: 70%;
	}
</style>
<div class="row m-t wrap_info">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="m-b-md">
				 
						<a class="btn btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/inventory/set",[ 'id' => $info['id'] ]);?>">
							<i class="fa fa-pencil"></i>编辑
						</a>
					 
					<h2>详情</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="m-t">投资计划：<?=UtilService::encode( $class_model['investment_plan'] ) ;?></p>
				<p>设备名称：<?=UtilService::encode( $class_model['name'] ) ;?></p>
				<p>设备型号：<?=UtilService::encode( $class_model['equipment_model'] ) ;?></p>
				<p>库存数量：<?=UtilService::encode( $info['total'] ) ;?></p>
				<p>库存地点：<?=UtilService::encode( $info['inventory_addr'] ) ;?></p>
				<p >物资编码：<?=UtilService::encode( $class_model['material_code'] ) ;?> </p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价格：<?=$class_model['price'] ;?></p>
				<p>生产厂家：<?=UtilService::encode( $class_model['produce_company'] ) ;?></p>
				<p>生产日期：<?=UtilService::encode( $class_model['produce_date'] ) ;?></p>
				<p>供货商：<?=UtilService::encode( $class_model['procure_company'] ) ;?></p>
				<p>供货电话：<?=UtilService::encode( $class_model['procure_tel'] ) ;?></p>
				<p>更新时间：<?=UtilService::encode( $info['updated_time'] ) ;?></p>
				<p>备注：<?=UtilService::encode( $info['beizhu'] ) ;?></p>
				<p style="color:red">设备参数：<?=UtilService::encode( $class_model['equip_params'] ) ;?></p>
				 
			</div>
		</div>
        <div class="row m-t">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab-1" data-toggle="tab" aria-expanded="false">库存变更</a>
                                </li>
                                <li>
                                    <a href="#tab-2" data-toggle="tab" aria-expanded="true">访问历史</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>时间</th>
                                        <th>数量</th>
                                        <th>操作人</th>
                                        <th>备注</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php if(isset($records )):?>
										<?php foreach( $records as $record ):?>
                                            <tr>
                                             <td><?=$record['id'];?></td>
                                                <td> 
                                                    <?=UtilService::encode( $record['created_time']);?>                                                    
                                                </td>                                
                                               
                                                <td><?=$record['updateNum'];?></td>
                                                <td><?=$record['user_id'];?></td>
                                                <td><?=$record['beizhu'];?></td>
                                            </tr>
										<?php endforeach;?>
									<?php else:?>
                                        <tr><td colspan="5">暂无销售记录</td></tr>
									<?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>变更</th>
                                        <th>备注</th>
                                        <th>时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset( $stock_change_list) ):?>
                                            <?php foreach( $stock_change_list as $_stock_info ):?>
                                                <tr>
                                                    <td><?=$_stock_info['unit'];?></td>
                                                    <td><?=$_stock_info['note'];?></td>
                                                    <td><?=$_stock_info['created_time'];?></td>
                                                </tr>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            <tr><td colspan="3">暂无变更</td></tr>
                                        <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
