 
<?php
use \app\common\services\UrlService;
 
use app\common\services\StaticSerivce;
use app\common\services\UtilService;
//StaticSerivce::includeAppJsStatic( "/js/front/task/index.js",\app\assets\FrontAsset::className() );
$this->title =  Yii::$app->params['title'];
?>
 
 
<div class="layui-col-md8 fly-main" style="overflow: hidden;">

  <div class="fly-tab-border fly-case-tab">
    <span>
      <a href="" class="tab-this">2018年度</a>
      <a href="">2017年度</a>
    </span>
  </div>
  <div class="layui-tab layui-tab-brief">
    <ul class="layui-tab-title">
      <li class="layui-this"><a href="">按提交时间</a></li>
      <li><a href="">按点赞排行</a></li>
    </ul>
  </div>

  <ul class="fly-case-list">
   <?php 
   if($shares):
    foreach ($shares as $_item)  :
   ?>
    <li data-id="123">
      <a class="fly-case-img" href="<?=UrlService::buildFrontUrl('/share/info',['uuid'=>$_item['uuid']])?>" target="_blank" >
        <img src="<?=UrlService::buildPicUrl('share', $_item['image'])?>" alt="Fly社区">
        <cite class="layui-btn layui-btn-primary layui-btn-small">去围观</cite>
      </a>
      <h2><a href="<?=UrlService::buildFrontUrl('/share/info',['uuid'=>$_item['uuid']])?>" target="_blank"><?=UtilService::cutstr($_item['title'], 16);?></a></h2>
      <p class="fly-case-desc"><?=UtilService::cutstr($_item['snapshot'], 400);?></p>
      <p>获得<a class="fly-case-nums fly-case-active" href="javascript:;" data-type="showPraise" style=" padding:0 5px; color: #01AAED;"><?=$_item->agree_num;?></a>个赞</p>
      <div class="fly-case-info">
        <a href="#" class="fly-case-user" target="_blank"><img src="<?=UrlService::buildPicUrl('avatar', $_item->user->avatar);?>"></a>
        <p class="layui-elip" style="font-size: 12px;"><span style="color: #666;"><?=$_item->user->nickname;?></span>  </p>        
        <button class="layui-btn layui-btn-primary fly-case-active" data-type="praise">点赞</button>
        <!-- <button class="layui-btn  fly-case-active" data-type="praise">已赞</button> -->
      </div>
    </li>
    <?php endforeach;?>
     
  </ul>
 
 	<?php else:?>
        <div style="text-align: center">
          <div class="laypage-main">
            <blockquote class="layui-elem-quote layui-quote-nm">暂无数据</blockquote> 
          </div>
	<?php endif;?>
	    <?php echo \Yii::$app->view->renderFile("@app/views/common/pagination.php", [
			'pages' => $pages,
		    'condition'=>$search_conditions,
			'url' => '/default/index'
		]); ?> 
      </div>

</div>
 