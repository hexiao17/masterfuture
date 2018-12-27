<?php
use app\common\services\StaticSerivce;
use app\common\services\ConstantMapService;
    //引入js资源文件
    StaticSerivce::includeAppJsStatic("/js/admin/member/setrole.js",app\assets\AdminAsset::className());
 ?>
      <!-- 通过yii指定方法渲染公共部分 -->
    <?=Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_account.php",["current"=>"member"]);?>  
        <div class="row m-t  wrap_account_set">
            <div class="col-lg-12">
                <h2 class="text-center">账号设置</h2>
                <div class="form-horizontal m-t m-b">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">姓名:</label>
                        <div class="col-lg-10">
                           <label><?=$info['nickname'];?></label>
                        </div>
                    </div>
                    <P>这里要注意：我们一般只给前台用户分一个角色,应该是单选！！</P>
                     <div class="hr-line-dashed"></div>
                      <!--所属角色-->
                    <div class="form-group">
                        <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label" >所属角色</label>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            				<?php if( $role_list ):?>
            					<?php foreach( $role_list as $_role_item ):?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="role_ids[]" value="<?=$_role_item['id'];?>"
                                            <?php if( in_array( $_role_item['id'] ,$related_role_ids ) ):?> checked <?php endif;?>
                                            />
            								<?=$_role_item['name'];?>
            								<strong>
                                        	<?=ConstantMapService::$role_tab_role_cate_mapping[$_role_item['cate']];?>
                                       		</strong>
                                        </label>                                        
                                    </div>
            					<?php endforeach;?>
            				<?php endif;?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-lg-offset-2">
                            <input type="hidden" name="id" value="<?=$info?$info['id']:0;?>">
                            <button class="btn btn-w-m btn-outline btn-primary save">保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 