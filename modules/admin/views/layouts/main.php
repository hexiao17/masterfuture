<?php 
//引入资源管理器
use app\assets\AdminAsset;
use app\common\services\UrlService;
//注册本页面
AdminAsset::register($this);
//取得配置，交给隐藏表单，然后传递给 common_ops.buildPicUrl 使用
$upload_config = Yii::$app->params['upload'];

?>
<?php $this->beginPage();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>管理后台</title>
     
    <?php $this->head();?>
</head>

<body>
<?php $this->beginBody();?>
<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="profile-element text-center">
                        <img alt="image" class="img-circle" src="<?=UrlService::buildWwwUrl("/images/web/logo.png");?>" />
                        <p class="text-muted"><?=Yii::$app->params['title'];?></p>
                    </div>
                    <div class="logo-element">
                        <img alt="image" class="img-circle" src="<?=UrlService::buildWwwUrl("/images/web/logo.png");?>"  />
                    </div>
                </li>
                 <li class="admin_url_separated">
                    <a href="#"><i class="fa fa-arrow-down fa-lg"></i>
                        <span class="nav-label">普通类</span></a>
                </li> 
                <li class="news">
                    <a href="<?=UrlService::buildAdminUrl('/plans/index');?>"><i class="fa fa-book fa-lg"></i> <span class="nav-label">计划管理</span></a>
                </li>
                <li class="tmpnews">
                    <a href="<?=UrlService::buildAdminUrl('/inventory/index');?>"><i class="fa fa-book fa-lg"></i> <span class="nav-label">库存管理</span></a>
                </li>
               <li class="attach">
                    <a href="<?=UrlService::buildAdminUrl('/equipment/index');?>"><i class="fa fa-download fa-lg"></i> <span class="nav-label">设备管理</span></a>
                </li>
                <li class="attach">
                    <a href="<?=UrlService::buildAdminUrl('/userorder/index');?>"><i class="fa fa-download fa-lg"></i> <span class="nav-label">工单管理</span></a>
                </li> 
                 <li class="admin_url_separated">
                    <a href="#"><i class="fa fa-arrow-down fa-lg"></i>
                        <span class="nav-label">系统类</span></a>
                </li> 
                <li class="dashboard">
                    <a href="<?=UrlService::buildAdminUrl('/dashboard/index');?>"><i class="fa fa-dashboard fa-lg"></i>
                        <span class="nav-label">仪表盘</span></a>
                </li>
                  <li class="weixin">
                    <a href="<?=UrlService::buildAdminUrl('/weixin/admin');?>"><i class="fa fa-random fa-lg"></i> <span class="nav-label">公众号设置</span></a>
                </li>
                <li class="account">
                    <a href="<?=UrlService::buildAdminUrl('/account/index');?>"><i class="fa fa-user fa-lg"></i> <span class="nav-label">账号管理</span></a>
                </li>
                <li class="brand">
                    <a href="<?=UrlService::buildAdminUrl('/brand/info');?>"><i class="fa fa-cog fa-lg"></i> <span class="nav-label">品牌设置</span></a>
                </li>
                <li class="sms">
                    <a href="<?=UrlService::buildAdminUrl('/notice/index_wx');?>"><i class="fa fa-volume-up fa-lg"></i> <span class="nav-label">系统通知</span></a>
                </li>
                <li class="book">
                    <a href="<?=UrlService::buildAdminUrl('/book/index');?>"><i class="fa fa-money fa-lg"></i> <span class="nav-label">商品管理</span></a>
                </li>
                
                <li class="role">
                    <a href="<?=UrlService::buildAdminUrl('/role/index');?>"><i class="fa fa-users fa-lg"></i> <span class="nav-label">角色管理</span></a>
                </li> 
                <li class="stat">
                    <a href="<?=UrlService::buildAdminUrl('/stat/index');?>"><i class="fa fa-bar-chart fa-lg"></i> <span class="nav-label">统计管理</span></a>
                </li>
                <li class="applog">
                    <a href="<?=UrlService::buildAdminUrl('/applog/accesslog');?>"><i class="fa fa-file-text-o fa-lg"></i> <span class="nav-label">访问日志</span></a>
                </li>
            </ul>

        </div>
    </nav>
    

    <div id="page-wrapper" class="gray-bg" style="background-color: #ffffff;">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:void(0);"><i class="fa fa-bars"></i> </a>

                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
						<span class="m-r-sm text-muted welcome-message">
                            欢迎使用【<?=Yii::$app->params['title'];?>】管理后台
                        </span>
                    </li>
                    <li class="hidden">
                        <a class="count-info" href="javascript:void(0);">
                            <i class="fa fa-bell"></i>
                            <span class="label label-primary">8</span>
                        </a>
                    </li>


                    <li class="dropdown user_info">
                        <a  class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                            <img alt="image" class="img-circle" src="<?=UrlService::buildPicUrl('avatar', $this->params['current_user']['avatar']);?>" />
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    	姓名：<?=$this->params['current_user']['nickname'];?> <a href="<?=UrlService::buildAdminUrl('/user/edit');?>" class="pull-right">编辑</a>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    手机号码：<?=$this->params['current_user']['mobile'];?>                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="link-block text-center">
                                    <a class="pull-left" href="<?=UrlService::buildAdminUrl('/user/reset-pwd');?>">
                                        <i class="fa fa-lock"></i> 修改密码
                                    </a>
                                    <a class="pull-right" href="<?=UrlService::buildAdminUrl('/user/logout');?>">
                                        <i class="fa fa-sign-out"></i> 退出
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>

            </nav>
        </div>
        <!-- 不同的内容begin -->
        <?=$content;?>
        <!-- 不同的内容end -->
       </div>
        

</div>
<div class="hidden_layout_warp hide">
	<!-- value的值一定要用单引号 -->
	<input type="hidden" name="upload_config" value='<?=json_encode($upload_config);?>' />
</div>
<?php $this->endBody();?>
<div>
	<center><i class="fa fa-copyright"></i><?=RELEASE_VERSION;?></center>
</div>
</body>
</html>
<?php $this->endPage();?>