<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\core\models\CoreSocialNetwork */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="core-social-network-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'network')->textInput(['maxlength' => true]);?>
    <?= $form->field($model, 'icons')->fileInput(); ?>
    <?= $form->field($model, 'image')->fileInput(); ?>
    <?= $form->field($model, 'thumb')->fileInput();  ?>
    <?= $form->field($model, 'status')->radioList(['1' => 'Yes', '0' => 'No'], ['prompt'=>'Select Status']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>