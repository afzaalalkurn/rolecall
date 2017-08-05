<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserMsg */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User School Msg',
]) . $model->message_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User School Msgs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->message_id, 'url' => ['view', 'id' => $model->message_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-school-msg-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
