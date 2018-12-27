
 <?php
	use \app\common\services\UrlService;
	use \app\common\services\UtilService;
	\app\assets\FrontAsset::register($this);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?//=$this->title;//Yii::$app->params['title'];?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="keywords" content="fly,layui,前端社区">
  <meta name="description" content="Fly社区是模块化前端UI框架Layui的官网社区，致力于为web开发提供强劲动力">
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="fly-header layui-bg-black">
  <div class="layui-container">
    <a class="fly-logo" href="<?=UrlService::buildBaseUrl('/');?>">
      <img src="<?=UrlService::buildBaseUrl('/').'images/logo.png';?>" alt="layui">
    </a>
    <ul class="layui-nav fly-nav layui-hide-xs">
      <li class="layui-nav-item layui-this">
        <a href="<?=UrlService::buildWWWUrl('/');?>"><i class="iconfont icon-jiaoliu"></i>动态</a>
      </li>
      <li class="layui-nav-item  ">
        <a href="<?=UrlService::buildFrontUrl('/task/index');?>"><i class="iconfont icon-jiaoliu"></i>任务</a>
      </li>
      <li class="layui-nav-item">
        <a href="<?=UrlService::buildFrontUrl('/share/index');?>"><i class="iconfont icon-iconmingxinganli"></i>分享</a>
      </li>
      
    </ul>
    
    <ul class="layui-nav fly-nav-user">
      
      <!-- 未登入的状态
      <li class="layui-nav-item">
        <a class="iconfont icon-touxiang layui-hide-xs" href="user/login.html"></a>
      </li>
      <li class="layui-nav-item">
        <a href="user/login.html">登入</a>
      </li>
      <li class="layui-nav-item">
        <a href="user/reg.html">注册</a>
      </li>
      <li class="layui-nav-item layui-hide-xs">
        <a href="/app/qq/" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" title="QQ登入" class="iconfont icon-qq"></a>
      </li>
      <li class="layui-nav-item layui-hide-xs">
        <a href="/app/weibo/" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" title="微博登入" class="iconfont icon-weibo"></a>
      </li>
       -->
      <!-- 登入后的状态 -->
      <!--
      <li class="layui-nav-item">
        <a class="fly-nav-avatar" href="javascript:;">
          <cite class="layui-hide-xs">贤心</cite>
          <i class="iconfont icon-renzheng layui-hide-xs" title="认证信息：layui 作者"></i>
          <i class="layui-badge fly-badge-vip layui-hide-xs">VIP3</i>
          <img src="https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg">
        </a>
        <dl class="layui-nav-child">
          <dd><a href="user/set.html"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
          <dd><a href="user/message.html"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>
          <dd><a href="user/home.html"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
          <hr style="margin: 5px 0;">
          <dd><a href="/user/logout/" style="text-align: center;">退出</a></dd>
        </dl>
      </li>
      -->
    </ul>
  </div>
</div>

 <div class="fly-case-header">
  <p class="fly-case-year">年度最佳分享评选</p> 
  <div class="fly-case-btn">
    <a href="javascript:;" class="layui-btn layui-btn-big fly-case-active" data-type="push">提交案例</a>
    <a href="" class="layui-btn layui-btn-primary layui-btn-big">我的案例</a>    
    <a href="http://fly.layui.com/jie/11996/" target="_blank" style="padding: 0 15px; text-decoration: underline">案例要求</a>
  </div>
</div>

<div class="layui-container">  
	 
  <div class="layui-row  layui-col-md-offset3 layui-col-space15"> 
    <div class=" layui-col-sm4  layui-hide-xs">

      <div class="fly-panel">
        <h3 class="fly-panel-title">本月总结</h3>
        <ul class="fly-panel-main fly-list-static">
          <li>
            <a href="http://fly.layui.com/jie/4281/" target="_blank">layui 的 GitHub 及 Gitee (码云) 仓库，欢迎Star</a>
          </li>
          <li>
            <a href="http://fly.layui.com/jie/5366/" target="_blank">
              layui 常见问题的处理和实用干货集锦
            </a>
          </li>
           
        </ul>
      </div>


      <div class="fly-panel fly-signin">
        <div class="fly-panel-title">
          签到
          <i class="fly-mid"></i> 
          <a href="javascript:;" class="fly-link" id="LAY_signinHelp">说明</a>
          <i class="fly-mid"></i> 
          <a href="javascript:;" class="fly-link" id="LAY_signinTop">活跃榜<span class="layui-badge-dot"></span></a>
          <span class="fly-signin-days">已连续签到<cite>16</cite>天</span>
        </div>
        <div class="fly-panel-main fly-signin-main">
          <button class="layui-btn layui-btn-danger" id="LAY_signin">今日签到</button>
          <span>可获得<cite>5</cite>飞吻</span>
          
          <!-- 已签到状态 -->
          <!--
          <button class="layui-btn layui-btn-disabled">今日已签到</button>
          <span>获得了<cite>20</cite>飞吻</span>
          -->
        </div>
      </div>

      <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
        <h3 class="fly-panel-title">回贴周榜</h3>
        <dl>
          <!--<i class="layui-icon fly-loading">&#xe63d;</i>-->
          <dd>
            <a href="user/home.html">
              <img src=""><cite>贤心</cite><i>106次回答</i>
            </a>
          </dd>
           
        </dl>
      </div>

      <dl class="fly-panel fly-list-one">
        <dt class="fly-panel-title">本周热议</dt>
        <dd>
          <a href="jie/detail.html">基于 layui 的极简社区页面模版</a>
          <span><i class="iconfont icon-pinglun1"></i> 16</span>
        </dd>
         

        <!-- 无数据时 -->
        <!--
        <div class="fly-none">没有相关数据</div>
        -->
      </dl>

      <div class="fly-panel">
        <div class="fly-panel-title">
          	这里可作为广告区域
        </div>
        <div class="fly-panel-main">
          <a href="http://layim.layui.com/?from=fly" target="_blank" class="fly-zanzhu" time-limit="2017.09.25-2099.01.01" style="background-color: #5FB878;">LayIM 3.0 - layui 旗舰之作</a>
        </div>
      </div>
      
      <div class="fly-panel fly-link">
        <h3 class="fly-panel-title">友情链接</h3>
        <dl class="fly-panel-main"> 
          <dd><a href="http://www.layui.com/laydate/" target="_blank">layDate</a><dd>
          <dd><a href="mailto:xianxin@layui-inc.com?subject=%E7%94%B3%E8%AF%B7Fly%E7%A4%BE%E5%8C%BA%E5%8F%8B%E9%93%BE" class="fly-link">申请友链</a><dd>
        </dl>
      </div>

    </div>
    <?=$content;?>
    
    
  </div>
</div>
<div class="site-tree-mobile layui-hide">
  <i class="layui-icon"></i>
</div>

<div class="fly-footer">
  <p><a href="http://fly.layui.com/" target="_blank">Fly社区</a> 2017 &copy; <a href="http://www.layui.com/" target="_blank">layui.com 出品</a></p>
  <p>
    <a href="http://fly.layui.com/jie/3147/" target="_blank">付费计划</a>
    <a href="http://www.layui.com/template/fly/" target="_blank">获取Fly社区模版</a>
    <a href="http://fly.layui.com/jie/2461/" target="_blank">微信公众号</a>
  </p>
</div>
 

<?php $this->endBody() ?>
 
<script>
 
// layui.cache.page = '';
// layui.cache.user = {
//   username: '游客'
//   ,uid: -1
//   ,avatar: '../res/images/avatar/00.jpg'
//   ,experience: 83
//   ,sex: '男'
// };
// layui.config({
//   version: "3.0.0"
//   ,base: './res/mods/' //这里实际使用时，建议改成绝对路径
// }).extend({
//   fly: 'index'
// }).use('fly');
</script>

</body>
</html>
<?php $this->endPage() ?>



