<?php
use \app\common\services\UrlService; 
use app\common\services\StaticSerivce;
 
StaticSerivce::includeAppJsStatic( "/js/m/order/set.js",\app\assets\MAsset::className() );
$this->title =  Yii::$app->params['title'];
?>
<header class='demos-header'>
      <h1 class="demos-title"><?=$equip_info->classinfo->equipment_model;?>工单信息</h1>
    </header>

<div  class="m_order_set">

    <div class="weui-cells weui-cells_form order_file_form">
      <div class="weui-cell">
    
       <div class="hr-line-dashed"></div>     
      
        <div class="weui-cell__bd">
          <div class="weui-uploader">
            <div class="weui-uploader__hd">
              <p class="weui-uploader__title">图片上传</p>
              <div class="weui-uploader__info">0/2</div>
            </div>
            <div class="weui-uploader__bd">
             <form class="upload_pic_wrap" target="upload_file" enctype="multipart/form-data" method="POST" action="<?=UrlService::buildAdminUrl("/upload/pic")?>">
                           
              <ul class="weui-uploader__files pic-each" id="uploaderFiles">
                <?php if($info && $info['image']):?> 
								<li class="weui-uploader__file" style="background-image:url(<?=UrlService::buildPicUrl("equipment", $info['image'])?>)"><span class="fa fa-times-circle del del_image" data="<?=$info['image']?>"><i class="weui-icon-cancel"></i></li> 
				 <?php else:?>
				 	 <li class="weui-uploader__file" style="background-image:url(/images/m/pic_160.png)"></li> 
				 	 <li class="weui-uploader__file" style="background-image:url(<?=UrlService::buildPicUrl("equipment", $info['image'])?>)"><span class="fa fa-times-circle del del_image" data="<?=$info['image']?>"><i class="weui-icon-cancel"></i></span></li> 
				 <?php endif;?> 
              </ul>
              <div class="weui-uploader__input-box">
              	 <input type="hidden" name="bucket" value="equipment" />
                 <input type="file" name="pic"  class="weui-uploader__input" accept="image/png, image/jpeg, image/jpg,image/gif"> 
              </div>
               </form>
            </div>
          </div>
        </div>
      </div>
    </div>
     
      <div class="weui-cells__title">故障描述</div>
    <div class="weui-cells weui-cells_form">
      <div class="weui-cell">
        <div class="weui-cell__bd">
          <textarea name="content" class="weui-textarea" placeholder="请输入文本" rows="3"></textarea>
          <div class="weui-textarea-counter"><span>0</span>/200</div>
        </div>
      </div>
    </div>
     <div class="weui-cells__title">预约时间</div>
    <div class="weui-cell">
         
        <div class="weui-cell__bd">
          <input class="weui-input" name="book_time" id="time3" type="text">
        </div>
      </div>
    <div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd">
          <label class="weui-label">手机号</label>
        </div>
        <div class="weui-cell__bd">
          <input class="weui-input" name="mobile" type="tel" placeholder="请输入手机号">
        </div>
        <div class="weui-cell__ft">
          <button class="weui-vcode-btn">获取验证码</button>
        </div>
      </div> 
     <div class="weui-cells__title">部门审批人</div>
    <div class="weui-cells">
      <div class="weui-cell">
        <div class="weui-cell__bd">
          <input class="weui-input" type="text" name="leader" placeholder="请输入姓名">
        </div>
      </div>
    </div>
   <!-- 操作按钮 --> 
   <div class='demos-content-padded'>
      <a href="javascript:;" id='show-actions' fdata="<?=$flow_id;?>"  edata="<?=$equip_info->id;?>" data="<?=$info?$info['id']:0;?>"  class="weui-btn weui-btn_primary save">提交</a> 
    </div>
</div>
   <!-- iframe 中的name 与 form中的target 一致，才能实现无刷新 -->
	<iframe    style="display: none" name="upload_file"></iframe>		