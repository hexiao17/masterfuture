<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use app\common\services\StaticSerivce; 
use app\assets\FrontAsset;
StaticSerivce::includeAppJsStatic('/js/front/user/cate.js',FrontAsset::className());
$this->title = "你的主页.".Yii::$app->params['title'];
?>
 <div class="fly-panel fly-panel-user" pad20>
	  <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
	    <button class="layui-btn layui-btn-danger" id="LAY_delallmsg">清空全部消息</button>
	    <div  id="LAY_minemsg" style="margin-top: 10px;">
          <div style="background: #eee;height: 50px;width: 100%;text-align: center;line-height: 50px;">头部面板</div>
		<div style="display: flex;flex-direction: row;">

			<div style="width: 50px;height: 800px;padding: 2px;text-align: center;">
				主题
				<div onclick="changeTheme('normal')" style="width: 30px;height: 30px;background: #3caee4;margin: 5px auto;cursor: pointer;"></div>
				<div onclick="changeTheme('red')" style="width: 30px;height: 30px;background: red;margin: 5px auto;cursor: pointer;"></div>
				<div onclick="changeTheme('green')" style="width: 30px;height: 30px;background: #1ce45a;margin: 5px auto;cursor: pointer;"></div>
				<div onclick="changeTheme('black')" style="width: 30px;height: 30px;background: #000000;margin: 5px auto;cursor: pointer;"></div>
				<div onclick="changeTheme('gray')" style="width: 30px;height: 30px;background: #6f6f6f;margin: 5px auto;cursor: pointer;"></div>

			</div>

			<div style="flex:1;overflow: hidden;display: block;text-align: center;">
				<div id="org_charts"></div>

			</div>
		</div>
      	</div>
	  </div>
 </div>
 