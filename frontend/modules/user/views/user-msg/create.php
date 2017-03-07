<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserMsg */

$this->title = Yii::t('app', 'Create Msg');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User School Msgs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="user-school-msg-create">
        <?= $this->render('_form', [
            'model'             => $model,
            'job_id'            => $job_id,
            'user_id'           => $user_id,
            'sender_id'         => $sender_id,
            'identifier'        => $identifier,
            'message_id'        => $message_id,
        ]) ?>
    </div>