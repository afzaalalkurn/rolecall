<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\cms\models\CmsCategory;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsField */
/* @var $form yii\widgets\ActiveForm */
$categoryList = ArrayHelper::map(CmsCategory::find()->all(),'category_id','name');
?>

<div class="cms-field-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <?= $form->field($model, 'category_id')->dropDownList($categoryList, ['prompt' => 'Select Category']) ?>

    <?= $form->field($model, 'section')->dropDownList([ 'None' => 'None', 'Summary' => 'Summary', 'Requirements' => 'Requirements', 'Skills' => 'Skills', ], ['prompt' => 'Select Section']) ?>

    <?= $form->field($model, 'field')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]);?>

    <?= $form->field($model, 'type')->dropDownList([ 'Text' => 'Text', 'TextArea' => 'TextArea', 'Radio' => 'Radio', 'List' => 'List', 'MultiList' => 'MultiList', ], ['prompt' => 'Select Type']) ?>
    <?= $form->field($model, 'order_by')->textInput(['maxlength' => true]);?>
    <?= $form->field($model, 'status')->radioList([ '1' => 'Yes', '0' => 'No']); ?>


    <?= $this->render('partial/_item', [
        'form' => $form,
        'model' => $model,
        'modelsItem' => $modelsItem,
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
