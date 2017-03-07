<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\core\models\CoreAdsPlan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="core-ads-plan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_type')->dropDownList([ 'FIXED' => 'FIXED', 'INFINITE' => 'INFINITE', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'payment_type')->dropDownList([ 'TRIAL' => 'TRIAL', 'REGULAR' => 'REGULAR', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'frequency')->dropDownList([ 'Day' => 'Day', 'Month' => 'Month', 'Year' => 'Year', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'frequency_interval')->textInput() ?>

    <?= $form->field($model, 'cycles')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
