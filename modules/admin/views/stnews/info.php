<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
 
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_news.php", ['current' => 'stnews']); ?>
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
					<?php if( $info && $info['status'] ):?>
						<a class="btn btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/stnews/set",[ 'id' => $info['id'] ]);?>">
							<i class="fa fa-pencil"></i>编辑
						</a>
					<?php endif;?>
					<h2>新闻详情</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="m-t">新闻标题：<?=UtilService::encode( $info['title'] ) ;?></p>
				<p>发布单位：<?=UtilService::encode( $info['pub_company'] ) ;?></p>
				<p>发布时间：<?=UtilService::encode( $info['pub_time'] ) ;?></p>
				<p>&nbsp;&nbsp;&nbsp;关键词：<?=UtilService::encode( $info['tags'] ) ;?></p>
				<p style="color:red">过期时间：<?=UtilService::encode( $info['expired_time'] ) ;?> </p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;描述：<?=$info['content'] ;?></p>
			</div>
		</div>
        <div class="row m-t">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab-1" data-toggle="tab" aria-expanded="false">收藏记录</a>
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
                                        <th>会员名称</th>
                                        <th>收藏时间</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php if(isset($fav_data )):?>
										<?php foreach( $fav_data as $fav ):?>
                                            <tr>
                                             <td><?=$fav['id'];?></td>
                                                <td> 
                                                    <?=UtilService::encode( $fav['member_info']['nickname'] );?>                                                    
                                                </td>                                
                                               
                                                <td><?=$fav['created_time'];?></td>
                                            </tr>
										<?php endforeach;?>
									<?php else:?>
                                        <tr><td colspan="4">暂无销售记录</td></tr>
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
