<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
 
use \app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppJsStatic( "/js/admin/comment/index.js",\app\assets\AdminAsset::className() );
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_comment.php", ['current' => 'index']); ?>

<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row  m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline">
                        <option value="<?=ConstantMapService::$status_default;?>">请选择状态</option>
						<?php foreach( $status_mapping as $_status => $_title ):?>
                            <option value="<?=$_status;?>" <?php if( $search_conditions['status']  == $_status):?> selected <?php endif;?> ><?=$_title;?></option>
						<?php endforeach;?>
                    </select>
                </div> 
                <div class="form-group">
                    <div class="input-group">
                         <span class="input-group-btn">
                            <button type="button" class="btn  btn-primary search">
                                <i class="fa fa-search"></i>搜索
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/comment/set");?>">
                        <i class="fa fa-plus"></i>模拟评论
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>ID</th>
                <th>会员</th>
                 <th>商品</th>
                <th>评分</th>               
                <th>评论内容</th>
                <th>创建时间</th>  
                <th>类型</th>              
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if( $comments ):?>
				<?php foreach( $comments as $_item ):?>
                    <tr>
                        <td><?= $_item['id'];?></td>
                        <td><?= $_item['nickname'] ;?></td>
                        <td><?= $_item['bookname'] ;?></td>
                        <td><?= $_item['score'] ;?></td>
                        <td><?= $_item['content'] ;?></td>
                        <td><?= $_item['created_time'];?></td>     
                        <td><?= $_item['type'];?></td>                              
                        <td>
                            
							<?php if( $_item['status'] ):?>
                                <a class="m-l" href="<?=UrlService::buildAdminUrl("/comment/set",[ 'id' => $_item['id'] ]);?>">
                                    <i class="fa fa-edit fa-lg"></i>
                                </a>

                                <a class="m-l remove" href="<?=UrlService::buildNullUrl();?>" data="<?=$_item['id'];?>">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
							<?php else:?>
                                <a class="m-l recover" href="<?=UrlService::buildNullUrl();?>" data="<?=$_item['id'];?>">
                                    <i class="fa fa-rotate-left fa-lg"></i>
                                </a>
							<?php endif;?>
                        </td>
                    </tr>
				<?php endforeach;?>
			<?php else:?>
                <tr><td colspan="8">暂无数据</td></tr>
			<?php endif;?>
            </tbody>
        </table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination.php", [
			'pages' => $pages,
			'url' => '/comment/index'
		]); ?>

    </div>
</div>
