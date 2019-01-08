<?php
use app\common\services\UrlService;
use app\common\services\UtilService;
use app\common\services\StaticSerivce;
use app\assets\FrontAsset;
use app\common\services\ConstantMapService;
StaticSerivce::includeAppJsStatic('/js/front/user/index.js', FrontAsset::className());
$this->title = "你的主页." . Yii::$app->params['title'];
?>
<div class="layui-col-md8">
	<div class="fly-panel fly-panel-user" pad20>
		<div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg"
			style="margin-top: 15px;">
			<button class="layui-btn layui-btn-danger" id="LAY_delallmsg">你的全部计数器</button>
			<div id="LAY_minemsg" style="margin-top: 10px;">
				<!--<div class="fly-none">您暂时没有最新消息</div>-->
				<ul class="mine-msg">
					<?php 
					
					foreach ($counters as $counter) :
					
					?>
					<li data-id="123">
						<blockquote class="layui-elem-quote">
							<a href="#"  ><cite><?=$counter['name']?></cite></a>总计<a
								  href="#"><cite><?=$counter['num']?></cite>次</a>
								|目前：<span style="color: red;"><?= ConstantMapService::$usercounter_statu_mapping[$counter['statu']];?></span>
						</blockquote>						
						<?php foreach ($counter->getLogs() as $log) :?>
							<p>
							<span><?=$log->created_time;?></span>
							<a href="javascript:;"
								class="layui-btn layui-btn-small layui-btn-danger fly-delete"><?=$log->log_text;?></a>
							</p>
						<?php endforeach;?>						
					</li>
					<?php 
					   endforeach;
					?>
					
				</ul>
			</div>
		</div>
	</div>
</div>
