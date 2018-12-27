<?php
use \app\common\services\UrlService;
 
use app\common\services\StaticSerivce;
use app\common\services\UtilService;
StaticSerivce::includeAppJsStatic( "/js/m/task/index.js",\app\assets\MAsset::className() );
$this->title =  Yii::$app->params['title'];
?>
<style>
<!--
/*index mouse color*/
.mouse_color{
	background-color:orange;
}
/*index ops day,week,month*/
.ops_group_group{
	margin-right:25px;
}
-->
</style>


<div class="layui-col-md8">
      <div class="fly-panel" style="margin-bottom: 0;">
        
        <div class="fly-panel-title fly-filter">
          <a href="" class="layui-this">综合</a>
          <span class="fly-mid"></span>
          <a href="">未结</a>
          <span class="fly-mid"></span>
          <a href="">已结</a>
          <span class="fly-mid"></span>
          <a href="">精华</a>
          <span class="fly-filter-right layui-hide-xs">
            <a href="" class="layui-this">按最新</a>
            <span class="fly-mid"></span>
            <a href="">按热议</a>
          </span>
        </div>
		<?php if($list):?>
        <ul class="fly-list">  
        
        	<?php foreach ($list as $_item):?>
                
          <li>
            <a href="<?=UrlService::buildMUrl('/user/home',['id'=>$_item['user_id']])?>" class="fly-avatar">
              <img src="<?=UrlService::buildPicUrl( "avatar",$_item['avatar'] );?>" alt="<?=$_item['nickname'];?>">
            </a>
            <h2>
              <a class="layui-badge"><?=$_item['cate_name'];?></a>
              <a href="<?=UrlService::buildMUrl('/share/info',['uuid'=>$_item['uuid']])?>"><?=$_item['title'];?></a>
            </h2>
            <div class="fly-list-info">
              <a href="<?=UrlService::buildMUrl('/user/home',['id'=>$_item['user_id']])?>" link>
                <cite><?=$_item['nickname'];?></cite>
                <!--
                <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                <i class="layui-badge fly-badge-vip">VIP3</i>
                -->
              </a>
              <span><?=$_item['created_time'];?></span>
              
              <span class="fly-list-kiss layui-hide-xs" title="点赞次数"><i class="iconfont icon-kiss"></i><?=$_item['agree_num'];?></span>
              <!--<span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>-->
              <span class="fly-list-nums"> 
                <i class="iconfont icon-pinglun1" title="回复"></i> <?=$_item['reply_num'];?>
              </span>
            </div>
            <div class="fly-list-badge">
              <?php if($_item['statu'] ==3):?>
              <span class="layui-badge layui-bg-black">置顶</span>
              <?php elseif ($_item['statu'] ==2):?>
               <span class="layui-badge layui-bg-red">精帖</span> 
              <?php endif;?>
            </div>
          </li>
           
          <?php endforeach;?>
           
        </ul>
        <?php else:?>
        <div style="text-align: center">
          <div class="laypage-main">
            <a href="#" class="laypage-next">暂无分享</a>
          </div>
        </div>        
        <?php endif;?>
        <!-- <div class="fly-none">没有相关数据</div> -->
    
         
	    <?php echo \Yii::$app->view->renderFile("@app/modules/m/views/common/pagination.php", [
			'pages' => $pages,
		    'condition'=>$search_conditions,
			'url' => '/share/index'
		]); ?>
	  </div>
    </div>

      