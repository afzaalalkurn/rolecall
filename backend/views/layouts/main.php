<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

if (class_exists('backend\assets\AppAsset')) {
    backend\assets\AppAsset::register($this);
} else {
    app\assets\AppAsset::register($this);
}
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>

    <?php if (Yii::$app->user->isGuest && Yii::$app->controller->action->id === 'login') { ?>
    <?= $this->render('skin-blue', ['content' => $content]); ?>
    <?php  } else { ?>
        <div class="wrapper">
            <?= $this->render('header.php'); ?>
            <?= $this->render('left.php'); ?>
            <?= $this->render('content.php', ['content' => $content]) ?>
        </div>
    <?php } ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>