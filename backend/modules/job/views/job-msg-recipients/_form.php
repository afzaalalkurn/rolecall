<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobMsgRecipients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-msg-recipients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seq')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Read' => 'Read', 'UnRead' => 'UnRead', 'Deleted' => 'Deleted', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
