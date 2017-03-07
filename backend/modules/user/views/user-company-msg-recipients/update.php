<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserSchoolMsgRecipients */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User School Msg Recipients',
]) . $model->message_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User School Msg Recipients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->message_id, 'url' => ['view', 'message_id' => $model->message_id, 'seq' => $model->seq, 'recipient_id' => $model->recipient_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-school-msg-recipients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
