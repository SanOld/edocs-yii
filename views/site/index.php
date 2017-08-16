<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
//AppAsset::register($this);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include(Yii::$app->basePath.'/views/layouts/head.php'); ?>
</head>
<body id="bd">

<?php include(Yii::$app->basePath.'/views/layouts/navbar.php'); ?>

<div id="layoutObj">    
<div id="page">
   <?php include(Yii::$app->basePath.'/views/layouts/menu.php'); ?>
</div>

  <div id="uploadWindow" ></div>
</div>  

</body>


</html>


