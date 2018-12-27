<?php
use \app\common\services\UrlService;
 
use \app\common\services\UtilService;
use app\common\services\StaticSerivce;
   
StaticSerivce::includeAppJsStatic( "/js/admin/notice/setsms.js",\app\assets\AdminAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/tab_sms.php", ['current' => 'sms_index']); ?>
<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-10">
        <h2 class="text-center">信息设置</h2>
    	<div class="row">

        <div class="col-md-6  wrap_user_list">
            <h2 class="font-bold">接收人</h2>
            	   
            	<addr>逗号分隔电话号码</addr><br/>
	            <textarea   name="add_mobile"></textarea>
				<hr/>
            <p  >           		 
               <?php foreach ($memeber_list as $_item):?>
                    <input type="checkbox"    name="member_name[]" value="<?= $_item['mobile'];?>"><?= $_item['nickname']."[".$_item['role_name']."]";?><br/>
              <?php endforeach;?>
              
            </p>
            <p class="text-danger" >             	
                	
                	<input type="checkbox" name="button" id="selAll"  />全选</td>    
                	       	
            </p>
        </div>
        <div class="col-md-4">
            <div class="ibox-content wrap_book_set">
                
                    <div class="form-group text-center">
                        <h2 class="font-bold"> </h2>
                    </div>
                    <div class="form-group">
                       	选择短信模板:
                       	<select name="template_id">
							  <?php 
							  	 foreach ($template as $key=>$value){
							  	 	echo "<option value='".$key."'>".$value."</option>";
							  	 }
							  ?>                     	
                       	</select>
                        
                    </div>
                    <p>模板：{"test":"OK"}</p>
                    <div class="form-group">
                    	
                       	<textarea   name="paramstr" class="form-control " placeholder='添加json参数{"task_id":24,"mobile":"15109463705"}'></textarea>
                    </div>                    
                    
                    <button type="submit" class="btn btn-primary block full-width save">发布</button> 
                 
            </div>
        </div>
    </div>
    </div>
</div>
 
