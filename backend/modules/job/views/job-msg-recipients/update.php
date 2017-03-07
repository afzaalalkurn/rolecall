<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobMsgRecipients */

$this->title = 'Update Job Msg Recipients: ' . $model->message_id;
$this->params['breadcrumbs'][] = ['label' => 'Job Msg Recipients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->message_id, 'url' => ['view', 'message_id' => $model->message_id, 'seq' => $model->seq, 'recipient_id' => $model->recipient_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="job-msg-recipients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
