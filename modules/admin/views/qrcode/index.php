<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use Faker\Provider\bn_BD\Utils;
use app\common\services\ConstantMapService;
 
?>

<?php echo Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_qrcode.php",[ 'current' => 'index' ]);?>

<div class="row">
	<div class="col-lg-12">
        <div class="row m-t">
            <div class="col-lg-12">
                <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/qrcode/set");?>">
                    <i class="fa fa-plus"></i>二维码
                </a>
            </div>
        </div>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>渠道名称</th>
                <th>会员ID</th>
                <th>二维码</th>
                 <th>更大尺寸</th>
                <th>扫码总数</th>
                <th>注册总数</th>
                 <th>付款总数</th>
                  <th>类型</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if( $list ):?>
                <?php foreach( $list as $_item ):?>
                <tr>
                    <td><?=UtilService::encode( $_item['name'] );?></td>
                    <td><?=$_item['member_id'];?></td>
                    <td>
                        <img style="width: 100px;height: 100px;" src="<?=UrlService::buildWwwUrl( "/default/qrcode",[ 'qr_code_url' => $_item['qrcode'] ] );?>"/>
                    </td>
                    <td>
                        <a href="<?=UrlService::buildWwwUrl( "/default/qrcode",[ 'qr_code_url' => $_item['qrcode'],'s'=>5 ] );?>">205x205</a><br/>
                    	<a href="<?=UrlService::buildWwwUrl( "/default/qrcode",[ 'qr_code_url' => $_item['qrcode'],'s'=>8 ] );?>">328x328</a><br/>
                    	<a href="<?=UrlService::buildWwwUrl( "/default/qrcode",[ 'qr_code_url' => $_item['qrcode'],'s'=>10 ] );?>">410x410</a><br/>
                    	<a href="<?=UrlService::buildWwwUrl( "/default/qrcode",[ 'qr_code_url' => $_item['qrcode'],'s'=>20 ] );?>">820x820</a><br/>
                    </td>
                    <td><?=UtilService::encode( $_item['total_scan_count'] );?></td>
                    <td><?=UtilService::encode( $_item['total_reg_count'] );?></td>
                     <td><?=UtilService::encode( $_item['total_pay_count'] );?></td>
                     <td><?=UtilService::encode(ConstantMapService::$market_qrcode_type_mapping[$_item['type']]);?></td>
                    <td>
                        <a class="m-l" href="<?=UrlService::buildAdminUrl("/qrcode/set",[ 'id' => $_item['id'] ]);?>">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr><td colspan="5">暂无数据</td></tr>
            <?php endif;?>
            </tbody>
        </table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination.php", [
		        'pages' => $pages,
				'url' => '/qrcode/index'
        ]); ?>
	</div>
</div>

