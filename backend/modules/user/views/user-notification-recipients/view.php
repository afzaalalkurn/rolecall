<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserNotificationRecipients */

$this->title = $model->message_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Notification Recipients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-notification-recipients-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'message_id' => $model->message_id, 'seq' => $model->seq, 'recipient_id' => $model->recipient_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'message_id' => $model->message_id, 'seq' => $model->seq, 'recipient_id' => $model->recipient_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'message_id',
            'seq',
            'recipient_id',
            'ip',
            'status',
            'time:datetime',
        ],
    ]) ?>

</div>
