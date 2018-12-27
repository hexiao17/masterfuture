<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
//注册默认的css和js
\app\assets\MAsset::register($this);
$upload_config = Yii::$app->params['upload'];
?>

<!DOCTYPE html>
<html>
  <head>
     <title><?=$this->title;//Yii::$app->params['title'];?></title>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">
 <?php $this->head() ?>

  </head>

  <body ontouchstart>
	<?php $this->beginBody() ?>
    

    

<?=$content;?>

    
<?php $this->endBody() ?>
  </body>

</html>
<?php $this->endPage() ?>