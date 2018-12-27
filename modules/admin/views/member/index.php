<?php
use app\common\services\UrlService;
use app\common\services\UtilService;
 
use app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;
  
  StaticSerivce::includeAppJsStatic( "/js/admin/member/index.js", \app\assets\AdminAsset::className());
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_account.php", ['current' => 'member']); ?>

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
                        <input type="text" name="mix_kw" placeholder="请输入关键字" class="form-control" value="<?=$search_conditions['mix_kw'];?>">
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
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/member/set");?>">
                        <i class="fa fa-plus"></i>会员
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>头像</th>
                <th>姓名</th>
                <th>手机</th>
                <th>性别</th>
                <th>角色名</th>
                <th>到期时间</th>
                <th>状态</th>
 				 <th>[最后登陆]</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
                    <tr>
                        <td><img alt="image" class="img-circle" src="<?= $_item['avatar'] ;?>" style="width: 40px;height: 40px;"></td>
                        <td><?= $_item['nickname'];?></td>
                        <td><?= $_item['mobile'] ;?></td>
                        <td><?= $_item['sex_desc'] ;?></td>
                        <td><?= isset($_item['role'])?$_item['role']['name'] :"";?></td>
                        <td><?= $_item['expired_time'];?></td>
                        <td><?= $_item['status_desc'] ;?></td>
                        <td><?= $_item['updated_time'] ;?></td>
                        <td>
                            <a  href="<?=UrlService::buildAdminUrl("/member/info",[ 'id' => $_item['id'] ] );?>">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
							<?php if( $_item['status'] ):?>
                                <a class="m-l" href="<?=UrlService::buildAdminUrl("/member/set",[ 'id' => $_item['id'] ]);?>">
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
							<a class="m-l" href="<?=UrlService::buildAdminUrl("/member/setrole",['id'=>$_item['id']]);?>">
                                		设置角色
                            </a>
                        </td>
                    </tr>
				<?php endforeach;?>
			<?php else:?>
                <tr><td colspan="9">暂无数据</td></tr>
			<?php endif;?>
            </tbody>
        </table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination.php", [
			'pages' => $pages,
			'url' => '/member/index'
		]); ?>

    </div>
</div>
