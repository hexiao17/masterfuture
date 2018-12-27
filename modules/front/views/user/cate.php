<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use app\common\services\StaticSerivce; 
use app\assets\FrontAsset;
StaticSerivce::includeAppJsStatic('/js/front/user/cate.js',FrontAsset::className());
//dtree
StaticSerivce::includeAppCssStatic('/plugins/dtree_v2.4.5/layui_ext/dtree/dtree.css',FrontAsset::className());
StaticSerivce::includeAppCssStatic('/plugins/dtree_v2.4.5/layui_ext/dtree/font/dtreefont.css',FrontAsset::className());
$this->title = "你的主页.".Yii::$app->params['title'];
?>
<div class="layui-col-md8">
 <div class="fly-panel fly-panel-user" pad20>
	  <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
	    <button class="layui-btn layui-btn-danger" id="LAY_delallmsg">清空全部消息</button>
	    <div  id="LAY_minemsg" style="margin-top: 10px;">
          <div style="background: #eee;height: 50px;width: 100%;text-align: center;line-height: 50px;">头部面板</div>
		<div style="display: flex;flex-direction: row;">

		 <div style="height: 550px;overflow: auto;" id="toolbarDiv">
  <ul id="toolbarTree1" class="dtree" data-id="0"></ul>
</div>
		</div>
      	</div>
	  </div>
 </div>
 </div>