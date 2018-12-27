<?php
use app\common\services\StaticSerivce;
 
    //引入js资源文件
  StaticSerivce::includeAppJsStatic( "/js/admin/role/access.js", \app\assets\AdminAsset::className());
 ?>
      <!-- 通过yii指定方法渲染公共部分 -->
    <?=Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_role.php",["current"=>"access"]);?>  
        <div class="row m-t  role_access_set_wrap">
            <div class="col-lg-12">
               <h2>为 <?=$info["name"];?> 设置权限</h2>
                <div class="form-horizontal m-t m-b">
                    
                    
                      <!--所属角色-->
                    <div class="form-group">
                        <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label" >所属角色</label>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            				 <?php if( $access_list ):?>
                    <?php foreach( $access_list as $_item ):?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="access_ids[]" value="<?=$_item['id'];?>"
                                <?php if( in_array( $_item['id'],$access_ids ) ):?> checked <?php endif;?>
                                >
                                <?=$_item['title'];?>
                            </label>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-lg-offset-2">
                              <input type="hidden" name="id" value="<?=$info['id'];?>">
			<button type="button" class="btn btn-primary pull-right  save">确定</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

