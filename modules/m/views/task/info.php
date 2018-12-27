<?php
 
use \app\common\services\UtilService;
 
use app\common\services\StaticSerivce;
use app\common\services\UrlService;
StaticSerivce::includeAppJsStatic( "/js/m/task/info.js",\app\assets\MAsset::className() );
$this->title =  Yii::$app->params['title'];
?>

<div class="layui-col-md8 content detail">
      <div class="fly-panel detail-box">
        <h1><?=UtilService::encode( $task_model['title'] )?></h1>
        <div class="fly-detail-info">
          
          <span class="layui-badge layui-bg-green fly-detail-column">动态</span>
          <?php if($task_model['weight']==90):?>
          <span class="layui-badge layui-bg-black">置顶</span>
          <?php endif;?>
           
          <div class="fly-admin-box" data-id="<?=$task_model['id'];?>">
          	<span class="layui-btn  layui-bg-red" id="del_task" >删除</span>
          </div>
          <span class="fly-list-nums"> 
            <i class="iconfont" title="人气">&#xe60b;</i> <?=UtilService::encode( $task_model['viewNum'] )?>
          </span>
        </div>
        <div class="detail-about">
          <a class="fly-avatar" href="<?=UrlService::buildMUrl('/user/home',['id'=>$share_info['created_user']])?>">
            <img src="<?=UrlService::buildPicUrl( "avatar",$user_avatar);?>" alt="<?=$user_name;?>">
          </a>
          <div class="fly-detail-user">
            <a href="<?=UrlService::buildMUrl('/user/home',['id'=>$share_info['created_user']])?>" class="fly-link">
              <cite><?=$user_name;?></cite>
              <i class="iconfont icon-renzheng" title="认证信息：{{ rows.user.approve }}"></i>
              <i class="layui-badge fly-badge-vip">VIP?</i>
            </a>
            <span title="发布时间"><?=UtilService::encode( $task_model['created_time'] )?></span> ||
             <span title="完成时间"><?=UtilService::encode( $task_model['end_date']?$task_model['end_date']:'未设置' )?></span>
          </div>
          <div class="detail-hits" id="LAY_jieAdmin" data-id="123">
            <span style="padding-right: 10px; color: #FF7200">分享价值：60RMB</span>  
            <span class="layui-btn layui-btn-xs jie-admin" type="edit"><a href="<?=UrlService::buildMUrl('/task/set',['id'=>$task_model['id']])?>">编辑此贴</a></span>
          </div>
        </div>
        <div class="detail-body photos">
      	<?=nl2br($task_model->task_desc);?> 
        </div>
        <hr>
         
          <div class="layui-btn-group">
            <button  act="<?=$task_model->isShare?'del':'add';?>"  data="<?=$task_model->id;?>" id="task_do_share" class="layui-btn layui-btn-primary layui-btn-sm"><?=$task_model->isShare?'删除共享':'一键共享';?></button>
            <button class="layui-btn layui-btn-primary layui-btn-sm">微信分享</button>
            <button class="layui-btn layui-btn-primary layui-btn-sm">微博分享</button>
            <button class="layui-btn layui-btn-primary layui-btn-sm"><i class="layui-icon"></i></button>
          </div>
          <hr>
          <?php if($task_model->isShare)
              $url  = UrlService::buildMUrl('/share/info',['uuid'=>$task_model->share_id]);
              echo "分享你的智慧:<a href='{$url}'>".$url."</a>";
             
            ?>  
       	  <a class="layui-btn layui-btn-xs" id="getAccessPwd" data=<?=$task_model->id;?>>点击查看密码</a>	
      </div>
		
       
    </div>