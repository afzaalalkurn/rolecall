<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\modules\job\models\JobField;
/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobFieldValue */
/* @var $form yii\widgets\ActiveForm */

$fields = ArrayHelper::map(JobField::find()->all(), 'field_id', 'field');
?>

<div class="job-field-value-form">

    <?php $form = ActiveForm::begin(); ?> 
    <?=$form->field($model, 'field_id')->dropDownList($fields, ['prompt' => 'Select Field']);?> 
    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
