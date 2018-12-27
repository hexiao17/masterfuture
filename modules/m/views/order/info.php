<?php
use \app\common\services\UrlService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppJsStatic( "/js/m/order/info.js",\app\assets\MAsset::className() );
$this->title =  Yii::$app->params['title'];
?>
<style>
      .placeholder {
        margin: 5px;
        padding: 0 10px;
        background-color: #ebebeb;
        height: 2.3em;
        line-height: 2.3em;
        text-align: center;
        color: #cfcfcf;
      }
      .now_step{
         background-color: red;
      }
    </style>
<header class='demos-header'>
      <h1 class="demos-title"><?=$this->title?></h1>
 </header>
 <div class="page__bd">
 	<div class="weui-panel">
        <div class="weui-panel__hd">故障工单</div>
        <div class="weui-panel__bd">
          <div class="weui-media-box weui-media-box_text">
            <h4 class="weui-media-box__title">预约单位:<?='['.$order_info->org->name.']';?></h4>
            <h4 class="weui-media-box__title">预约时间：<span style="color:red"><?=$order_info->book_time;?></span></h4>
            <p class="weui-media-box__desc">
            	<div class="weui-cells__title">故障描述</div>
            	<?=nl2br($order_info->content);?> <br/>
            	<img style="max-width: 400px;" alt="" src="<?=UrlService::buildPicUrl('equipment', $order_info->image);?>">
            </p>            
            <ul class="weui-media-box__info">
              <li class="weui-media-box__info__meta"><?=$order_info->creater->nickname;?></li>
              <li class="weui-media-box__info__meta"><?=$order_info->created_time;?></li>
              <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">其它信息</li>
            </ul>
            <p  >
              <div class="  weui-loadmore_line">
                <span class="weui-loadmore__tips">[<?=$order_info->flow->title;?>]最新流程状态</span>
              </div> 
              	<?=$order_info->flowBeauty;?> 
            </p>
          </div>
        </div>
      </div>

    
    <!-- 所有记录 -->
 <div class="weui-panel weui-panel_access"> 
 	<?php $replys = $order_info->getReplys(1)->all(); 	
 	      if($replys):
 	?> 
        <div class="weui-cells__title">未读数红点跟在主题信息后，统一在列表左侧</div>
          <?php foreach ($replys as $_reply):?>
          
          
            <div class="weui-cells">
              <div class="weui-cell">
                <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                  <img src="<?=UrlService::buildPicUrl('equipment', $_reply->image);?>" style="width: 50px;display: block">
                  
                </div>
                <div class="weui-cell__bd">
                  <p><?=$_reply['do_user_list'];?></p>
                  <p style="font-size: 13px;color: #888888;"><?=nl2br($_reply->content); ?></p>
                </div>
               
                <div class="weui-cell__bd">
                  <span style="vertical-align: middle">评分：</span>
                  <?php if($_reply->score==0):?>
                   <a href="javascript:;" class=" weui-btn weui-btn_mini weui-btn_primary"  style="vertical-align: middle" >打分</a>
                  <?php else :?>
                  <span class="weui-badge" style="margin-left: 5px;"><?=$_reply->score;?></span>
                  <?php endif;?>
                   
                  <span style="vertical-align: middle">维修时间：</span>
                  <span style="margin-left: 5px;"><?=$_reply->created_time;?></span>
                </div>
                 
              </div> 
              </div>
          <?php endforeach;?>
       </div>
       
       <?php endif;?>
 </div>  
    

<!-- 回复部分 -->

<div  class="m_order_set"> 
    <div class="weui-cells weui-cells_form order_file_form">
    <div class="weui-panel__hd">工单维护</div>
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
     
      <div class="weui-cells__title">处理内容</div>
    <div class="weui-cells weui-cells_form">
      <div class="weui-cell">
        <div class="weui-cell__bd">
          <textarea name="content" class="weui-textarea" placeholder="请输入文本" rows="3"></textarea>
          <div class="weui-textarea-counter"><span>0</span>/200</div>
        </div>
      </div>
    </div>
   
     
     <div class="weui-cells__title">维修人员</div>
    <div class="weui-cells">
      <div class="weui-cell">
        <div class="weui-cell__bd">
          <input class="weui-input" type="text" name="user_list" placeholder="请输入姓名，逗号分隔">
        </div>
      </div>
    </div>
   <!-- 操作按钮 --> 
   <div class='demos-content-padded'>
      <a href="javascript:;" id='show-actions'    data="<?=$order_info?$order_info['id']:0;?>"  class="weui-btn weui-btn_primary save">提交</a> 
    </div>
</div>
    </div>
   <!-- iframe 中的name 与 form中的target 一致，才能实现无刷新 -->
	<iframe    style="display: none" name="upload_file"></iframe>	
    