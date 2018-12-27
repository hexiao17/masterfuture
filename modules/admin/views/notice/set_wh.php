<?php
use \app\common\services\UrlService;
 
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;
   
StaticSerivce::includeAppJsStatic( "/js/admin/notice/setwh.js",\app\assets\AdminAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_sms.php", ['current' => 'wx_wh']); ?>
<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-10">
        <h2 class="text-center">维护通知</h2>
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
                    <p>模板：
			
                    您好，平台支付服务暂停使用。<br/>
			类型：硬件升级<br/>
			时间：2014-12-09 14:00<br/>
			您好，为了给您更好的服务体验，支付平台将于12月9日14时-15时进行硬件更新，期间将暂停充值服务，给您带来的不便敬请谅解。<br/>
                    
                    </p>
                    <div class="form-group">
                       	<input type="text" name="str_first" class="form-control " placeholder="您好，平台支付服务暂停使用">
                    </div>
                    <div class="form-group">
                        	<input type="text" name="str_two" class="form-control" placeholder="硬件升级">
                    </div>
                     <div class="form-group">
                        	<input type="text" name="str_three" class="form-control" placeholder="2014-12-09 14:00">
                    </div>
                     <div class="form-group">
                        	<textarea name="str_four" class="form-control" placeholder="100字以内" rows="5" cols="10"></textarea>  
                    </div>
                    <input type="hidden" name="id" value="<?=$info?$info['id']:0;?>">
               
                    <button type="submit" class="btn btn-primary block full-width save">发布</button>
                    
                 
            </div>
        </div>
    </div>
    </div>
</div>
 
