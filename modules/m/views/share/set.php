  <?php
use \app\common\services\UrlService;
 
use app\common\services\StaticSerivce;
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
StaticSerivce::includeAppJsStatic( "/js/m/task/set.js",\app\assets\MAsset::className() );
$this->title =  Yii::$app->params['title'];
?>		    
<div class="layui-col-md8 content detail  fly-marginTop">
 <div class="fly-panel" pad20 style="padding-top: 5px;">
    <!--<div class="fly-none">没有权限</div>-->
    <div class="layui-form layui-form-pane">
      <div class="layui-tab layui-tab-brief" lay-filter="user">
        <ul class="layui-tab-title">
          <li class="layui-this">发表新帖<!-- 编辑帖子 --></li>
        </ul>
        <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
          <div class="layui-tab-item layui-show">
            <div id="task_set_form" action="#" method="post">
              <div class="layui-row layui-col-space15 layui-form-item">
                <div class="layui-col-md4">
                  <label class="layui-form-label">任务分组</label>
                  <div class="layui-input-block">
                    <select id="task_taskgroup" name="task_group"  > 
                    	<?php 
                    		$selected = $info['task_group'];
                    		foreach (ConstantMapService::$task_taskgroup_mapping as $key=>$value){
                    			$mark = $key == $selected ? ' selected':'';
                    			echo ' <option value="'.$key.'" '.$mark .' >'.$value.'</option> ';                    			 
                    		}
                    	 ?> 
                    </select>
                  </div>
                </div>
                <div class="layui-col-md8">
                  <label for="L_title" class="layui-form-label"  >标题</label>
                  <div class="layui-input-block">
                    <input type="text" id="L_title" value="<?=$info?$info['title']:'';?>" name="title"  autocomplete="off" class="layui-input">
                    <!-- <input type="hidden" name="id" value="{{d.edit.id}}"> -->
                  </div>
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">起止时间</label>
                <div class="layui-input-inline">
                  <input type="text" id="task_endtime_limit" name="data_str" value="<?=$info?$info['start_date']:'';?> <?=$info?$info['end_date']:'';?>"    placeholder="请选择起止时间"  class="layui-input">
                </div> 
              </div>
              <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                   <textarea class="layui-textarea fly-editor" id="LAY_demo1" name="task_desc"  style="height: 260px;display: none">  
					  <?=$info?$info['task_desc']:'';?>
					</textarea>
                </div>
                
              </div>
              <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">是否公开</label>
                  <div class="layui-input-inline" style="width: 190px;">
                    <select name="pubLevel">
                      	<?php 
                    		$selected = $info['pubLevel'];
                    		foreach (ConstantMapService::$task_pubLevel_mapping as $key=>$value){
                    			$mark = $key == $selected ? ' selected':'';
                    			echo ' <option value="'.$key.'" '.$mark .' >'.$value.'</option> ';                    			 
                    		}
                    	 ?> 
                    </select>
                  </div>
                  <div class="layui-form-mid layui-word-aux">公开可以分享给朋友</div>
                </div>
              </div>
              
               <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">设置权重</label>
                <div class="layui-input-inline">
                  <input type="text" name="weight" value="<?=$info?$info['weight']:'';?>"     placeholder="默认是1-10,99-100为置顶"  class="layui-input">                    
                </div> 
              </div>
              <!-- 隐藏属性 -->
              <input type="hidden" name="id" value="<?=$info['id'];?>">
              <input type="hidden" name="addr_method" value="set">
              <div class="layui-form-item">
                <button class="layui-btn save" >立即发布</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 
 