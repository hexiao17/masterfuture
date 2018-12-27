<?php
use app\common\services\StaticSerivce;
use app\assets\AdminAsset;
use app\common\services\UrlService;
// 注入js 文件到最后
//StaticSerivce::includeAppJsStatic("/js/admin/access/index.js", AdminAsset::className());

?>
<!-- 通过yii指定方法渲染公共部分 -->
<?=Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_role.php",["current"=>"access"]);?>
<div class="row">
	<div class="col-lg-12">
	 <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/access/set");?>">
                        <i class="fa fa-plus"></i>权限
                    </a>
                </div>
            </div>
		<div class="col-xs-9 col-sm-9 col-md-9  col-lg-9">
			<h5>权限列表</h5>
		</div>
		<table class="table table-bordered m-t">
			<thead>
				<tr>
					<th>权限</th>
					<th>Urls</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
                   <?php if( $list ):?>
			<?php foreach( $list as $_key => $_access_info ):?>
				<?php
                        $tmp_urls = @json_decode($_access_info['urls'], true);
                        $tmp_urls = $tmp_urls ? $tmp_urls : [];
                        ?>
				<tr>
					<td><?=$_access_info['title'];?></td>
					<td><?=implode("<br/>",$tmp_urls);?></td>
					<td><a
						href="<?=UrlService::buildAdminUrl("/access/set",[ 'id' => $_access_info['id'] ]);?>"
						class="btn btn-link">编辑</a></td>
				</tr>
			<?php endforeach;?>
		<?php else:?>
			<tr>
					<td colspan="3">暂无权限</td>
				</tr>
		<?php endif;?>
                   
                    </tbody>
		</table>
		<div class="row">
			<?php 
			   if (isset($pages)):
			?>
			<div class="col-lg-12">
				<span class="pagination_count" style="line-height: 40px;">共<?=$pages['total_count'];?>条记录 | 每页<?=$pages['page_size'];?>条</span>
				<ul class="pagination pagination-lg pull-right" style="margin: 0 0;">
                        	<?php for($_page=1;$_page<= $pages['total_page'];$_page++):?>
                        		<?php if ($_page==$pages['p']):?>
                        			<li class="active"><a
						href="<?=UrlService::buildNullUrl();?>"><?=$_page; ?></a></li>
                        		<?php else:?>
                        			<li><a
						href="<?=UrlService::buildAdminUrl('/account/index',['p'=>$_page]);?>"><?=$_page; ?></a></li>
                        		<?php endif;?>
                            
                            <?php endfor;?>
                  </ul>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>


