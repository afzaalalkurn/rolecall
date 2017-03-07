<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Music Teacher</title>
    <?php $this->head() ?>



<script type='text/javascript'>
/* <![CDATA[ */
    var peThemeOptions = {"animations":"yes"};
/* ]]> */
</script> 
<?= Html::cssFile('@web/css/animate.min.css', ['id' => 'pe_theme_animate_css-css', 'type' => 'text/css', 'media' => 'all']);?>
</head>

<body class="<?= $this->context->id ?> <?= $this->context->action->id ?>">
<?php $this->beginBody() ?>

<div class="wrap">
<section class="pe-main-section">
  <!--header section start here-->
    <?= $this->render('header'); ?>
  <!--header section end here --> 
  
	<section class="header-sub-banner">
      <div class="head-banner">
        <h1><?= Html::encode($this->title) ?></h1>
      </div>
    </section> 

    <div class="container middlebody">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>    
</div> 
<?php $this->endBody() ?>
<?= $this->render('footer') ?>
</body>
</html>
<?php $this->endPage() ?>
