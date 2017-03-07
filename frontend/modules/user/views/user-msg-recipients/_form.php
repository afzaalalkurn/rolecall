<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserMsgRecipients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-school-msg-recipients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seq')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Read' => Yii::t('app','Read'), 'UnRead' => Yii::t('app','UnRead'), 'Deleted' => Yii::t('app', 'Deleted'), ], ['prompt' => '']) ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
