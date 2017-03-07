<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserMsgAttachments */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User School Msg Attachments',
]) . $model->attachment_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User School Msg Attachments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->attachment_id, 'url' => ['view', 'id' => $model->attachment_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-school-msg-attachments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
