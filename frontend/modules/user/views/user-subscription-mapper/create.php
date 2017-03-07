<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserSubscriptionMapper */

$this->title = Yii::t('app', 'Create User Subscription Mapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Subscription Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-subscription-mapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
