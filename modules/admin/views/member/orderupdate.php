<?php
use app\common\services\UrlService;
use app\common\services\UtilService;

use app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;

StaticSerivce::includeAppJsStatic("/js/admin/member/index.js", \app\assets\AdminAsset::className());
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_account.php", ['current' => 'orderupdate']); ?>

<div class="row">
	<div class="col-lg-12">

		<table class="table table-bordered m-t">
			<thead>
				<tr>
					<th>ID</th>
					<th>支付编号</th>
					<th>会员名称</th>
					<th>更新之前角色</th>
					<th>之前过期时间</th>
					<th>角色</th>
					<th>过期时间</th>
					<th>修改时间</th>
				</tr>
			</thead>

			<tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
                    <tr>
					<td><?= $_item['id'];?></td>
					<td><?= $_item['pay_order_id'];?></td>
					<td><?= $_item['nickname'] ;?></td>
					<td><?= $_item['before_role'] ;?></td>
					<td><?= $_item['before_expired_time'] ;?></td>
					<td><?= $_item['update_role'] ;?></td>
					<td><?= $_item['update_expired_time'] ;?></td>
					<td><?= $_item['created_time'] ;?></td>

				</tr>
				<?php endforeach;?>
			<?php else:?>
                <tr>
					<td colspan="3">暂无数据</td>
				</tr>
			<?php endif;?>
            </tbody>
		</table>
		<?php

echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination.php", [
    'pages' => $pages,
    'condition' => [
        'member_id' => $condition["member_id"]
    ],
    'url' => '/member/orderupdate'
]);
?>

    </div>
</div>
