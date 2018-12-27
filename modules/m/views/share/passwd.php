  <?php
use \app\common\services\UrlService;
 
use app\common\services\StaticSerivce;
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
StaticSerivce::includeAppJsStatic( "/js/m/share/passwd.js",\app\assets\MAsset::className() );
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
                  <label class="layui-form-label">名称</label>
                  <div class="layui-input-block">
                  
                  </div>
                </div>
                <div class="layui-col-md8">
                  <label for="L_title" class="layui-form-label"  >输入访问密码</label>
                  <div class="layui-input-block">
                    <input type="text" id="L_title" value="" name="passwd"  autocomplete="off" class="layui-input"> 
                  </div>
                </div>
              </div> 
              <!-- 隐藏属性 -->
              <input type="hidden" name="uuid" value="<?=$uuid;?>"> 
              <div class="layui-form-item">
                <button class="layui-btn save" >访问</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 
 