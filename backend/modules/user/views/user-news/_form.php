<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserNews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'create_date')->widget(DatePicker::classname(), [])?>

    <?= $form->field($model, 'modified_date')->widget(DatePicker::classname(), []) ?>

    <?= $form->field($model, 'publish_date')->widget(DatePicker::classname(), [])?>

    <!-- French Tab Start -->

    <?= $form->field($modelUserNewsFr, 'name')->textInput(['maxlength' => true]) ?>

     <?= $form->field($modelUserNewsFr, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <!-- French Tab Ends -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
