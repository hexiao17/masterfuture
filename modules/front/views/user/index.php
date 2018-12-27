<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use app\common\services\StaticSerivce; 
use app\assets\FrontAsset;
StaticSerivce::includeAppJsStatic('/js/front/user/index.js',FrontAsset::className());
$this->title = "你的主页.".Yii::$app->params['title'];
?>
 <div class="layui-col-md8">
  <div class="fly-panel fly-panel-user" pad20>
    <!--
    <div class="fly-msg" style="margin-top: 15px;">
      您的邮箱尚未验证，这比较影响您的帐号安全，<a href="activate.html">立即去激活？</a>
    </div>
    -->
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title" id="LAY_mine">
        <li data-type="mine-jie" lay-id="index" class="layui-this">我的分享（<span><?=sizeof($list_shares);?></span>）</li>
        <li data-type="collection" data-url="/collection/find/" lay-id="collection">我收藏的帖（<span><?=sizeof($list_favs);?></span>）</li>
      </ul>
      <div class="layui-tab-content" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <ul class="mine-view jie-row">
          	<?php 
          	 if($list_shares):
          	 foreach ($list_shares as $share):
          	
          	?>
            <li>
              <a class="jie-title" href="<?=UrlService::buildFrontUrl('/share/info',['uuid'=>$share->uuid])?>" target="_blank"><?=$share->title;?></a>
              <i><?=$share->created_time;?></i>
              <a class="mine-edit" href="<?=UrlService::buildFrontUrl('/share/set',['uuid'=>$share->uuid])?>">编辑</a>
              <em><?=$share->view_num;?>阅/<?=$share->reply_num;?>答/<?=$share->agree_num;?>赞</em>
            </li>            
            <?php 
                endforeach;
                endif;
            ?> 
          </ul>
          <div id="LAY_page"></div>
        </div>
        <div class="layui-tab-item">
          <ul class="mine-view jie-row">
           	<?php 
          	 if($list_favs):
          	 foreach ($list_favs as $fav):
          	
          	?>
            <li data=<?=$fav->id;?> >
              <a class="jie-title" href="<?=UrlService::buildFrontUrl('/fav/info',['id'=>$fav->id])?>" target="_blank"><?=$fav->share->title;?></a>
              <i>收藏于<?=UtilService::friendlyDate($fav->created_time,'mohu');?></i>  
               <a class="user_fav_unfav"  >删除</a>
            </li>
            <?php 
                endforeach;
                endif;
            ?>
          </ul>
          <div id="LAY_page1"></div>
        </div>
      </div>
    </div>
  </div>
 </div>
