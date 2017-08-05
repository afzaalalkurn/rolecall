<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);

//pr(Yii::$app->controller->id,false);
//pr(Yii::$app->controller->action->id);

$currentPage = Yii::t('app', '{ctrl}/{action}', ['ctrl'=>Yii::$app->controller->id,'action' => Yii::$app->controller->action->id]);

$param = '';
$class = '';
$homeUrl = '';
$talentClass = '';
if(!Yii::$app->user->isGuest){
    $role = Yii::$app->user->identity->getRoleName();
    if($role == "Director")
    {
        $class = 'directordiv';
        $job_id = Yii::$app->request->get('id');
        $user_id = Yii::$app->request->get('user_id');
        if(!$job_id){
            $param = 'user/view';
        }
        if($user_id && $currentPage == 'user/view'){
            $talentClass = 'protalentdiv';
        }
        $homeUrl = Url::to(['/site/dashboard']);

    }
    else{
        $homeUrl = Url::to(['/job/job-user-mapper/index',
            'user_id'=>Yii::$app->user->id,
            'status' => 'Pending']);
    }
}

$pages = ['site/index',
    $param,
    'user/update',
    'cms-item/view',
    'job-item/index',
    'site/change-password',
    'site/policy',
    'site/terms',
    'site/contact',
    'site/payment',
    /*'job-item/view',*/
    /*'job-item/update',*/
    'job-item/archive',
    'job-item/create',
    'site/dashboard',
    'user-notification/index',
    'user-msg/index',
    'user-msg/view',
    'user-msg/all-archive',
    'user-notification/view',
    'user/settings',
    'user/delete-user',
];

$staticPages = ['site/index','site/terms','cms-item/view','site/policy','site/contact'];

$seetingsPages = ['user/settings'];
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Rolecall</title>
    <?php $this->head() ?>
<script type='text/javascript'>
/* <![CDATA[ */
    var peThemeOptions = {"animations":"yes"};
/* ]]> */
</script> 
<?= Html::cssFile('@web/css/animate.min.css', ['id' => 'pe_theme_animate_css-css', 'type' => 'text/css', 'media' => 'all']);?>
</head>
<body class="<?=$class;?> <?=$talentClass;?> <?= $this->context->id ?> <?= $this->context->action->id ?>">
<?php $this->beginBody() ?>
<div class="wrap">
    <section class="pe-main-section">
      <!--header section start here-->
        <?= $this->render('header'); ?>
      <!--header section end here -->
    </section>
    <section class="header-sub-banner">
      <div class="head-banner">
        <h1><?= Html::encode($this->title) ?></h1>
      </div>
    </section>
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => Yii::t('yii', 'Home'),
            'url' => $homeUrl,
        ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
    <div class="container middlebody">
        <div class="wrapper">
          
            <?php if (!Yii::$app->user->isGuest && !in_array($currentPage, $pages)){?>
                <?= $this->render('left.php'); ?>
            <? } else if(!Yii::$app->user->isGuest && (in_array($currentPage,$seetingsPages))){
                ?>
                <?= $this->render('left-settings.php'); ?>
                <?php
            }?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div> 
</div>  
<?php $this->endBody();?>
<?php if(Yii::$app->user->isGuest){?>
<?=$this->render('footer');?>
<?}else if(!Yii::$app->user->isGuest && in_array($currentPage,$staticPages)){?>
    <?=$this->render('footer');?>
    <?}?>
</body>
</html>
<?php $this->endPage() ?>
