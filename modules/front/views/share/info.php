<?php
 
use \app\common\services\UtilService;
 
use app\common\services\StaticSerivce;
use app\common\services\UrlService;
StaticSerivce::includeAppJsStatic( "/js/front/share/info.js",\app\assets\FrontAsset::className() );
//	StaticSerivce::includeAppCssStatic("/css/web/weiui.css", \app\assets\FrontAsset::className());
$this->title =  Yii::$app->params['title'];
?>

 
    <div class="layui-col-md8 content detail">
      <div class="fly-panel detail-box">
        <h1><?=$share_info['title'];?></h1>
        <div class="fly-detail-info">
           <?php if(1==1):?>
           <span class="layui-badge" style="background-color: #5FB878;">已结</span>  
           <?php else :?>
           <span class="layui-badge" style="background-color: #999;">未结</span>
           
           <?php endif;?>
         
          <div class="fly-admin-box" data-id="123">
          	<?php if($share_info['statu'] ==1):?>
          	<span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="1">加精</span> 
          	 <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="1">置顶</span> 
          	<?php elseif ($share_info['statu'] == 2):?>          	
          	<span class="layui-badge layui-bg-red">精帖</span>
          	<?php elseif ($share_info['statu'] == 3):?>
          	 <span class="layui-badge layui-bg-black">置顶</span>          	
          	<?php endif;?> 
            <span class="layui-btn layui-btn-xs jie-admin" type="del">删除</span> 
          </div>
          <span class="fly-list-nums"> 
          	<a href="#" class="share_fav_btn" data="<?=$share_info['id'];?>"><i class="iconfont" title="收藏">&#xe60c;</i><?=$share_info['fav_num'];?></a>
            <a href="#comment"><i class="iconfont" title="回复">&#xe60c;</i><?=$share_info['reply_num'];?></a>
            <i class="iconfont" title="人气">&#xe60b;</i><?=$share_info['view_num'];?>
          </span>
        </div>
        <div class="detail-about">
          <a class="fly-avatar" href="<?=UrlService::buildFrontUrl('/user/home',['id'=>$share_info['created_user']])?>">
            <img src="<?=UrlService::buildPicUrl( "avatar",$member['avatar'] );?>" alt="<?=$member['nickname'];?>">
          </a>
          <div class="fly-detail-user">
            <a href="<?=UrlService::buildFrontUrl('/user/home',['id'=>$share_info['created_user']])?>" class="fly-link">
              <cite><?=$member['nickname'];?></cite>
              <i class="iconfont icon-renzheng" title="认证信息：{{ rows.user.approve }}"></i>
              <i class="layui-badge fly-badge-vip">VIP3</i>
            </a>
            <span><?=$share_info['created_time'];?></span>
          </div>
          <div class="detail-hits" id="LAY_jieAdmin" data-id="123">
            <span style="padding-right: 10px; color: #FF7200">点赞：<?=$share_info['agree_num'];?></span>  
            <span class="layui-btn layui-btn-xs jie-admin" type="edit"><a href="<?=UrlService::buildFrontUrl('/share/set',['id'=>$share_info['uuid']])?>">编辑此贴</a></span>
          </div>
        </div>
        <div class="detail-body photos">
          <?=nl2br($share_info['snapshot']);?>  
        </div>
         <hr>
         
          <div class="layui-btn-group">
            <button class="layui-btn layui-btn-primary layui-btn-sm">共享</button>
            <button class="layui-btn layui-btn-primary layui-btn-sm">微信分享</button>
            <button class="layui-btn layui-btn-primary layui-btn-sm">微博分享</button>
            <button class="layui-btn layui-btn-primary layui-btn-sm"><i class="layui-icon"></i></button>
          </div>
      </div>

      <div class="fly-panel detail-box" id="flyReply">
        <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
          <legend>回帖</legend>
        </fieldset>
 		
        <ul class="jieda" id="jieda"> 
        <?php if($replys):?>
          <?php foreach ($replys as $_item):?>
        
          <li data-id="111" class="jieda-daan">
            <a name="item-1111111111"></a>
            <div class="detail-about detail-about-reply">
              <a class="fly-avatar" href="<?=UrlService::buildFrontUrl('/user/home',['id'=>$_item['user_id']])?>">
                <img src="<?=UrlService::buildPicUrl( "avatar",$_item['avatar'] );?>" alt="<?=$_item['nickname'];?>">
              </a>
              <div class="fly-detail-user">
                <a href="" class="fly-link">
                  <cite><?=$_item['nickname'];?></cite>
                  <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                  <i class="layui-badge fly-badge-vip">VIP3</i>              
                </a>
                
                <?php if($share_info['created_user'] == $_item['user_id']):?>                
                <span>(楼主)</span>
                <?php endif;?>
                <?php if($_item['user_id'] ==1):?>
                <span style="color:#5FB878">(管理员)</span>
                <span style="color:#FF9E3F">（社区之光）</span>                
                <?php endif;?>
                <?php if($_item['user_statu']==0):?>
                <span style="color:#999">（该号已被封）</span>
                <?php endif;?> 
              </div>

              <div class="detail-hits">
                <span><?=$_item['created_time'];?></span>
              </div> 
              <?php 
              if($_item['isAccept']){
			  		echo '<i class="iconfont icon-caina" title="最佳答案"></i>';
			  	}
			  ?>
            </div>
            <div class="detail-body jieda-body photos">
             <?=nl2br($_item['content']);?>
            </div>
            <div class="jieda-reply">
              <span class="jieda-zan zanok" type="zan" data="<?=$_item['id'];?>">
                <i class="iconfont icon-zan"></i>
                <em><?=$_item['agree_num'];?></em>
              </span>
              <span type="reply" class="reply" nickname="<?=$_item['nickname'];?>"  floor="<?=$_item['floor'];?>">
                <i class="iconfont icon-svgmoban53"></i>
               		 回复
              </span>
              <div class="jieda-admin"> 
                <?php 
                	//回复的拥有者在没有采纳的时候可以编辑，删除 
                	
                	//在没有采纳的时候
                	if(!$_item['isAccept'] ){
                		//reply 拥有者可以编辑，删除
                	    if($_item['user_id'] ==\Yii::$app->view->params['current_user']['id']){
                			echo '<span type="edit">编辑</span>';                			 
                		}
                		//task 拥有者可以删除，采纳
                		if($share_info['created_user']==\Yii::$app->view->params['current_user']['id']){
                		//	echo '<span type="del">删除</span>';
                			echo '<span class="jieda-accept" type="accept" data="'.$_item['id'].'">采纳/屏蔽</span>';                			 
                		}                		
                		        		
                		
                	}                
                ?>                
              </div>
            </div>
          </li>
          <?php endforeach;?>          
          <?php else :?>
          
          <!-- 无数据时 -->
            <li class="fly-none">消灭零回复</li>  
           <?php endif;?>
        </ul>
        
        <div class="layui-form layui-form-pane">
          <form   method="post">
            <div class="layui-form-item layui-form-text">
              <a name="comment"></a>
              <div class="layui-input-block">
                <textarea id="reply_content" name="content" required lay-verify="required" placeholder="请输入内容"  class="layui-textarea fly-editor" style="height: 150px;"></textarea>
              </div>
            </div>
            <div class="layui-form-item">
              <input id="share_id" type="hidden" name="id" value="<?=$share_info['id'];?>" >
              <button id="reply_submit" class="layui-btn"   >提交回复</button>
            </div>
          </form>
        </div>
      </div>
    </div>
 