<?php
use app\common\services\UrlService;
use app\common\services\StaticSerivce;
StaticSerivce::includeAppJsStatic( "/js/front/summary/index.js",\app\assets\FrontAsset::className() );
$this->title =  Yii::$app->params['title'];
?>
<div class="layui-col-md8">

		<div class="fly-panel">
			<div class="fly-panel-title fly-filter">
				<div class="layui-form-item summary_index_from">
					<div class="layui-inline">
						<label class="layui-form-label">日期范围</label>
						<div class="layui-input-inline">
							<input type="text" name="summary_str" class="layui-input" id="test6"
								placeholder=" - ">
						</div>
					</div>
					<div class="layui-inline">
						<div class="layui-input-inline">						
							<button class="layui-btn save">生成总结</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<table class="layui-table layui-text">
			<colgroup>
				<col width="10">
				<col width="80">
				<col width="150">
				<col width="150">
			</colgroup>
			<thead>
				<tr>
					<th>ID</th>
					<th>时间</th>
					<th>总结名称</th>
					<th>产生时间</th>
				</tr>
			</thead>
			<tbody>
    
      <?php
    foreach ($summarys as $_item) :
        ?>
      <tr>
					<td><?=$_item['id'];?></td>
					<td><?=$_item['year_month']?></td>
					<td><a
						href="<?=UrlService::buildFrontUrl('/summary/info',['id'=>$_item['id']])?>"><?=$_item['title']?></td>
					<td><?=$_item['created_time'];?></td>
				</tr>
      
     <?php endforeach;?>  
    </tbody>
		</table>
	</div>
