<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserAds */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User Ads',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Ads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->ad_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-ads-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
