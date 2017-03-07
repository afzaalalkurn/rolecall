<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserSubscriptionMapper */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User Subscription Mapper',
]) . $model->subscription_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Subscription Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subscription_id, 'url' => ['view', 'id' => $model->subscription_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-subscription-mapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
