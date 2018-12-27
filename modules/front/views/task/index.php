<?php
use \app\common\services\UrlService;
 
use app\common\services\StaticSerivce;
use app\common\services\UtilService;
StaticSerivce::includeAppJsStatic( "/js/front/task/index.js",\app\assets\FrontAsset::className() );
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
      <div class="fly-panel">
        <div class="fly-panel-title fly-filter">
          <a>置顶</a>
           
           <div class="layui-btn-group fly-right" id="add_task_index">
			  <button  value='1' class="layui-btn layui-btn-sm"><i class="layui-icon">&#xe654;</i>今</button>
			  <button  value='2' class="layui-btn layui-btn-sm">周</button>
			  <button  value='3' class="layui-btn layui-btn-sm">月</button>
			</div>
        </div>
        <ul class="fly-list">
          <?php 
          	  foreach ($list_top5 as $_item):
          ?>	
          <li>
            <a href="<?=UrlService::buildFrontUrl('/user/info',['id'=>$_item['user_id']]);?>" class="fly-avatar  ">
              <img src="<?=UrlService::buildPicUrl( "avatar",$_item['avatar'] );?>" alt="<?=$_item['username']; ?>">
            </a>
            <h2>
              <a class="layui-badge"><?=$_item['cate_name'];?></a>
              <a href="<?=UrlService::buildFrontUrl('/task/info',['id'=>$_item['id']]);?>"><?php echo $_item['title'];?></a>               
            </h2>
            <div class="fly-list-info  ">
              <a href="<?=UrlService::buildFrontUrl('/user/info',['id'=>$_item['user_id']]);?>"  link>
                <cite><?php echo $_item['username'];?></cite>
                <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                <i class="layui-badge fly-badge-vip">VIP3</i>
              </a>
              <span><?php echo $_item['created_time'];?></span>              
              <span class="fly-list-kiss layui-hide-xs" title="悬赏飞吻"><i class="iconfont icon-kiss"></i> 60</span>
              <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>
              <div class="layui-btn-group  ops_group_statu disabled"  data-id="<?php echo $_item['id'];?>"  >
				   <i value="1" class="layui-icon">&#xe605;</i>
				   <i value="-1" class="layui-icon">&#x1006;</i>			 
			  </div> 
              <div class="layui-btn-group ops_group_group disabled  fly-right"  data-id="<?php echo $_item['id'];?>" >
				  <button  value='1' class="layui-btn layui-btn-sm"><i class="layui-icon">&#xe642;</i>今</button>
				  <button  value='2' class="layui-btn layui-btn-sm">周</button>
				  <button  value='3' class="layui-btn layui-btn-sm">月</button>
			  </div>
               
              <!-- 右侧 -->
              <span class="fly-list-nums"> 
                <i class="iconfont icon-pinglun1" title="分享"></i><?=$_item['isShare'];?>
              </span>
            </div>
            <div class="fly-list-badge">              
              <span class="layui-badge layui-bg-black">置顶</span>
              <span class="layui-badge layui-bg-red">长期</span>
         
            </div>
          </li>
          <?php endforeach;?>
            
        </ul>
      </div>

      <div class="fly-panel" style="margin-bottom: 0;">
        <?php 
            $group = 1;
        	if(isset($_GET['group'])){
        		$group = $_GET['group'];
        	}
        ?>
        <div class="fly-panel-title fly-filter tab_select_group"  selectid="<?=$group;?>">
          <a class="group_1" href="<?=UrlService::buildFrontUrl('/task/index',['group'=>1]); ?>"  >今日</a>
          <span class="fly-mid"></span>
          <a class="group_2" href="<?=UrlService::buildFrontUrl('/task/index',['group'=>2]); ?>">本周</a>
          <span class="fly-mid"></span>
          <a class="group_3" href="<?=UrlService::buildFrontUrl('/task/index',['group'=>3]); ?>">本月</a>
          <span class="fly-mid"></span>
          <a class="group_4" href="<?=UrlService::buildFrontUrl('/task/index',['group'=>5]); ?>">本年</a>
          <span class="fly-mid"></span>
          <a  class="group_0" href="<?=UrlService::buildFrontUrl('/task/index',['statu'=>1,'group'=>0]); ?>">已完成</a>
          <span class="fly-filter-right layui-hide-xs">
            <a href="" class="layui-this">按最新</a>
            <span class="fly-mid"></span>
            <a href="">按重要性</a>
          </span>
        </div>
	<?php 	if ($list):?>
        <ul class="fly-list">    
        <?php 
        	foreach ($list as $_item):
        ?>      
          <li>
            <a href="<?=UrlService::buildFrontUrl('/user/info',['id'=>$_item['user_id']]);?>" class="fly-avatar">
              <img src="<?=UrlService::buildPicUrl( "avatar",$_item['avatar'] );?>" alt="<?=$_item['username']; ?>">
            </a>
            <h2>
              <a class="layui-badge"><?=$_item['cate_name'];?></a>
              <a href="<?=UrlService::buildFrontUrl('/task/info',['id'=>$_item['id']]);?>"><?php echo $_item['title'];?></a>
            </h2>
            <div class="fly-list-info">
              <a href="<?=UrlService::buildFrontUrl('/user/info',['id'=>$_item['user_id']]);?>" link>
                <cite><?php echo $_item['username'];?></cite>
                <!--
                <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                <i class="layui-badge fly-badge-vip">VIP3</i>
                -->
              </a>
              <span><?php echo $_item['created_time'];?></span>
           		<?php if($_item['isShare']):?>
                	<span class="layui-badge fly-badge-accept layui-hide-xs">已分享</span>
                <?php endif;?>
              <div class="layui-btn-group  ops_group_statu disabled"  data-id="<?php echo $_item['id'];?>"  >
				   <i value="1" class="layui-icon">&#xe605;</i>
				   <i value="-1" class="layui-icon">&#x1006;</i>			 
			  </div>
              <div class="layui-btn-group ops_group_group  disabled fly-right"  data-id="<?php echo $_item['id'];?>"  >
				  <button  value='1' class="layui-btn layui-btn-sm"><i class="layui-icon">&#xe642;</i>今</button>
				  <button  value='2' class="layui-btn layui-btn-sm">周</button>
				  <button  value='3' class="layui-btn layui-btn-sm">月</button>
				  <button  value='5' class="layui-btn layui-btn-sm">年</button>
			  </div>
              <span class="fly-list-nums"> 
            
                
              </span>
            </div>
            <div class="fly-list-badge">
              <!--<span class="layui-badge layui-bg-red">精帖</span>-->
            </div>
          </li>
          <?php 
          	endforeach;
          ?>
        </ul>
        <?php else:?>
        <div style="text-align: center">
          <div class="laypage-main">
            <a href="#" class="laypage-next">暂无更多</a>
          </div>
        </div>
	<?php endif;?>
	    <?php echo \Yii::$app->view->renderFile("@app/modules/front/views/common/pagination.php", [
			'pages' => $pages,
		    'condition'=>$search_conditions,
			'url' => '/task/index'
		]); ?> 
      </div>
    </div>
    

    