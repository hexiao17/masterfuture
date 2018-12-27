<?php
use \app\common\services\UrlService;
 
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;
   
StaticSerivce::includeAppJsStatic( "/js/admin/notice/setwx.js",\app\assets\AdminAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_sms.php", ['current' => 'wx_index']); ?>
<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-10">
        <h2 class="text-center">信息设置</h2>
    	<div class="row">

        <div class="col-md-6  wrap_user_list">
            <h2 class="font-bold">接收人</h2>
            <p  >
               <?php foreach ($memeber_list as $_item):?>
                    <input type="checkbox"    name="member_name[]" value="<?= $_item['mobile'];?>"><?= $_item['nickname']."[".$_item['role_name']."]";?><br/>
              <?php endforeach;?>
            </p>
            <p class="text-danger" >             	
                	
                	<input type="checkbox" name="button" id="selAll"  />全选</td>    
                	<button id="add_btn">手动添加号码 </button>            	
            </p>
        </div>
        <div class="col-md-4">
            <div class="ibox-content wrap_book_set">
                
                    <div class="form-group text-center">
                        <h2 class="font-bold"> </h2>
                    </div>
                    <p>模板：已更新招标信息*条,商谈信息*条</p>
                    <div class="form-group">
                       	<input type="text" name="zb_count" class="form-control " placeholder="更新招标信息数量">
                    </div>
                    <div class="form-group">
                        	<input type="text" name="st_count" class="form-control" placeholder="更新商谈信息数量">
                    </div>
                    <input type="hidden" name="id" value="<?=$info?$info['id']:0;?>">
                    <input type="hidden" name="channel" value="<?=$info?$info['channel']:1;?>">
                    <button type="submit" class="btn btn-primary block full-width save">发布</button>
                    
                 
            </div>
        </div>
    </div>
    </div>
</div>
 
