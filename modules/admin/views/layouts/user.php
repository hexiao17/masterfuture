<?php
//引入资源文件管理器
use app\assets\AdminAsset;
//注册当前文件
AdminAsset::register($this);

?>
<?php $this->beginPage();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>管理后台</title>
    <?php $this->head(); ?>
</head>

<body class="gray-bg">
<?php $this->beginBody();?>
<!-- 不同部分begin -->

<?=$content;?>
<!-- 不同部分end -->
<?php $this->endbody();?>
</body>
</html>
<?php $this->endPage();?>