<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserNews */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User News',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-news-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUserNewsFr' => $modelUserNewsFr,
    ]) ?>

</div>
