<?php
use app\common\services\UrlService;
use app\common\services\UtilService;
 
use app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;
  
  StaticSerivce::includeAppJsStatic( "/js/admin/member/index.js", \app\assets\AdminAsset::className());
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_account.php", ['current' => 'trial']); ?>

<div class="row">
    <div class="col-lg-12">
        
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>ID</th>
                <th>会员名称</th>
                <th>试用时间</th>
                <th>到期时间</th>
                <th>改动人</th>       
                <th>改动原因</th>               
            </tr>
            </thead>
            <tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
                    <tr>
                        <td><?= $_item['id'];?></td>
                        <td><?= $_item['nickname'];?></td>
                        <td><?= $_item['created_time'] ;?></td>   
                         <td><?= $_item['expired_time'] ;?></td>     
                          <td><?= $_item['adder'] ;?></td> 
                          <td><?= $_item['beizhu'] ;?></td>                           
                    </tr>
				<?php endforeach;?>
			<?php else:?>
                <tr><td colspan="3">暂无数据</td></tr>
			<?php endif;?>
            </tbody>
        </table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination.php", [
			'pages' => $pages,
			'url' => '/member/trial'
		]); ?>

    </div>
</div>
