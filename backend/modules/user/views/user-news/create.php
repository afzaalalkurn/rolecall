<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserNews */

$this->title = Yii::t('app', 'Create User News');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-news-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUserNewsFr' => $modelUserNewsFr,
    ]) ?>

</div>
