<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
 
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_tmpnews.php", ['current' => 'st']); ?>
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
					<?php if( $info && $info['statu'] ):?>
						<a class="btn btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/stnews/set",[ 'tmpnews_id' => $info['id'],'type'=>'st' ]);?>">
							<i class="fa fa-pencil"></i>编辑->生成新闻
						</a>
					<?php endif;?>
					<h2>新闻详情</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="m-t">新闻标题：<?=UtilService::encode( $info['title'] ) ;?></p>
				<p>发布单位：<?=UtilService::encode( $info['flowname'] ) ;?></p>
				<p>发布时间：<?=UtilService::encode( $info['pubtime'] ) ;?></p>
				<p>&nbsp;&nbsp;&nbsp;关键词：<?=UtilService::encode( $info['tags'] ) ;?></p>
				<p style="color:red">过期时间：<?=UtilService::encode( $info['updatetime'] ) ;?> </p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;描述：<?=$info['content'] ;?></p>
			</div>
		</div>
         
	</div>
</div>
