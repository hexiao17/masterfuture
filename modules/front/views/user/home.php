<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use app\common\services\StaticSerivce; 
use app\assets\FrontAsset;
StaticSerivce::includeAppJsStatic('/js/front/user/home.js',FrontAsset::className());
$this->title = "你的主页.".Yii::$app->params['title'];
?>
 
<div class="fly-home fly-panel" style="background-image: url();">
  <img src="<?=UrlService::buildPicUrl('avatar', $current_user->avatar);?>" alt="<?=$current_user->nickname;?>">
  <i class="iconfont icon-renzheng" title="Fly社区认证"></i>
  <h1>
   <?=$current_user->nickname;?>
    <i class="iconfont icon-nan"></i>
    <!-- <i class="iconfont icon-nv"></i>  -->
    <i class="layui-badge fly-badge-vip">VIP3</i>
    <!--
    <span style="color:#c00;">（管理员）</span>
    <span style="color:#5FB878;">（社区之光）</span>
    <span>（该号已被封）</span>
    -->
  </h1>

  <p style="padding: 10px 0; color: #5FB878;">认证信息：layui 作者</p>

  <p class="fly-home-info">
    <i class="iconfont icon-kiss" title="飞吻"></i><span style="color: #FF7200;">66666 飞吻</span>
    <i class="iconfont icon-shijian"></i><span><?=$current_user->created_time;?> 加入</span>
    <i class="iconfont icon-chengshi"></i><span>最后登陆IP：<?=$current_user->reg_ip;?></span>
  </p>

  <p class="fly-home-sign">（<?=$current_user->personal;?>）</p>

  <div class="fly-sns" data-user="">
    <a href="javascript:;" class="layui-btn layui-btn-primary fly-imActive" data-type="addFriend">加为好友</a>
    <a href="javascript:;" class="layui-btn layui-btn-normal fly-imActive" data-type="chat">发起会话</a>
  </div>

</div>

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md6 fly-home-jie">
      <div class="fly-panel">
        <h3 class="fly-panel-title"><?=$current_user->nickname;?> 最近完成的任务</h3>
        <ul class="jie-row">
        <?php 
        if ($last_finish_tasks) :
            foreach ($last_finish_tasks as $task) :
        ?>
          <li>
            <span class="fly-jing">精</span>
            <a href="<?=UrlService::buildFrontUrl('/task/info',['id'=>$task->id]);?>" class="jie-title"><?=$task->title;?></a>
            <i>刚刚</i>
            <em class="layui-hide-xs">完成时间：<?=$task->finish_time;?>/<?=$task->isShare==1?'已分享':'未分享';?></em>
          </li>
          
          <?php 
            endforeach;            
          else:          
          ?> 
           <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有记录任何任务</i></div> 
           <?php 
                endif;
          ?>
        </ul>
      </div>
    </div>
    
    <div class="layui-col-md6 fly-home-da">
      <div class="fly-panel">
        <h3 class="fly-panel-title"><?=$current_user->nickname;?> 最近的回答</h3>
        <ul class="home-jieda">
        <?php 
        if ($last_replys) :
        foreach ($last_replys as $reply) :
        ?> 
          <li>
          <p>
          <span><?=UtilService::friendlyDate(strtotime($reply->created_time),'mohu')?></span>
          在<a href="<?=UrlService::buildFrontUrl('/share/info',['uuid'=>$reply->share->uuid]);?>" target="_blank"><?=$reply->share->title;?></a>中#<?=$reply->floor;?>楼回答：
          </p>
          <div class="home-dacontent">
             <?=$reply->content;?> 
          
          </div>
        </li>
        <?php 
            endforeach;            
          else:          
          ?> 
        <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><span>没有回答任何问题</span></div> 
        <?php 
                endif;
          ?>
         
        </ul>
      </div>
    </div>
  </div>
</div>
