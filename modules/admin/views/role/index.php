<?php
use app\common\services\UrlService;
use app\common\services\UtilService;
 
use app\common\services\ConstantMapService;
use app\common\services\StaticSerivce;
  
  StaticSerivce::includeAppJsStatic( "/js/admin/role/index.js", \app\assets\AdminAsset::className());
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_role.php", ['current' => 'index']); ?>

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
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildAdminUrl("/role/set");?>">
                        <i class="fa fa-plus"></i>角色
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>角色名称</th>
                <th>等级</th>
                <th >有限天数</th>
              <th>角色分类</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
                    <tr>
                        <td><?=$_item['name'];?> </td>
                        <td><?= $_item['pos'];?></td>
                        <td style="width: 10%;"><?= $_item['valid_days'];?> </td>
                        <td style="width: 10%;"><?= ConstantMapService::$role_tab_role_cate_mapping[$_item['cate']];?> </td>
                       
                        <td><?=$status_mapping[$_item['status']];?></td>
                        
                        <td>
                            <a  href="<?=UrlService::buildAdminUrl("/role/info",[ 'id' => $_item['id'] ] );?>">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
							<?php if( $_item['status'] ):?>
                                <a class="m-l" href="<?=UrlService::buildAdminUrl("/role/set",[ 'id' => $_item['id'] ]);?>">
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
							 <a  href="<?=UrlService::buildAdminUrl("/role/access",[ 'id' => $_item['id'] ] );?>">
                               		  设置访问列表
                            </a>
                        </td>
                    </tr>
				<?php endforeach;?>
			<?php else:?>
                <tr><td colspan="8">暂无数据</td></tr>
			<?php endif;?>
            </tbody>
        </table>
		  
    </div>
</div>
