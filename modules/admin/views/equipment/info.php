<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use app\common\services\ConstantMapService;
 
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_equipment.php", ['current' => 'equipment']); ?>
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
				 
						<a class="btn btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/equipment/set",[ 'id' => $info['id'] ]);?>">
							<i class="fa fa-pencil"></i>编辑
						</a>
					 
					<h2>详情</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="m-t">投资计划：<?=UtilService::encode( $class_info['investment_plan'] ) ;?></p>
				<p>设备名称：<?=UtilService::encode( $class_info['name'] ) ;?></p>
				<p>设备型号：<?=UtilService::encode( $class_info['equipment_model'] ) ;?></p>			
				<p >物资编码：<?=UtilService::encode( $class_info['material_code'] ) ;?> </p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价格：<?=$class_info['price'] ;?></p>
				<p>生产厂家：<?=UtilService::encode( $class_info['produce_company'] ) ;?></p>
				<p>生产日期：<?=UtilService::encode( $class_info['produce_date'] ) ;?></p>
				<p>供货商：<?=UtilService::encode( $class_info['procure_company'] ) ;?></p>
				<p>供货电话：<?=UtilService::encode( $class_info['procure_tel'] ) ;?></p>
				<p>原装参数：<?=UtilService::encode( $class_info['equip_params'] ) ;?></p>
				<hr/>
				 <p>设备使用单位：<?=UtilService::encode( $org_info['name'] ) ;?></p> 
				<p>设备二维码： 
						<img  style="width: 100px;height:100px;"  alt="" src="<?=UrlService::buildWWWUrl('/default/qrcode',['qr_code_url'=>$equip_detail['qr_code_url']]);?>">
						<a  href="<?=UrlService::buildWWWUrl('/default/down_qrcode',['qr_code_url'=>$equip_detail['qr_code_url'],'s'=>10]);?>">下载二维码</a>
				</p>
				
				<p>现设备参数：<?=UtilService::encode( $equip_detail['equip_params'] ) ;?></p>
				<p style="color:red">使用状态：<?= ConstantMapService::$equipment_statu_mapping[ $equip_detail['statu']] ;?></p>
				<p>备注：<?=UtilService::encode( $equip_detail['beizhu'] ) ;?></p> 
			</div>
		</div>
        <div class="row m-t">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab-1" data-toggle="tab" aria-expanded="false">使用记录</a>
                                </li>
                                <li>
                                    <a href="#tab-2" data-toggle="tab" aria-expanded="true">库存变更记录</a>
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
                                        <th>使用人</th>
                                        <th>领用人</th>
                                        <th>备注</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php if(isset($use_logs )):?>
										<?php foreach( $use_logs as $use_log ):?>
                                            <tr>
                                             <td><?=$use_log['id'];?></td>
                                                <td> 
                                                    <?=UtilService::encode( $use_log['created_time']);?>                                                    
                                                </td>                                
                                               
                                                <td><?=$use_log['use_name'];?></td>
                                                <td><?=$use_log['receiver'];?></td>
                                                <td><?=$use_log['beizhu'];?></td>
                                            </tr>
										<?php endforeach;?>
									<?php else:?>
                                        <tr><td colspan="5">暂无使用记录</td></tr>
									<?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>操作人</th>
                                        <th>备注</th>
                                        <th>时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset( $invent_records) ):?>
                                            <?php foreach( $invent_records as $record ):?>
                                                <tr>
                                                    <td><?=$record['id'];?></td>
                                                    <td><?=$record['ops_user'];?></td>
                                                    <td><?=$record['beizhu'];?></td>
                                                    <td><?=$record['ops_time'];?></td>
                                                </tr>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            <tr><td colspan="4">暂无变更</td></tr>
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
