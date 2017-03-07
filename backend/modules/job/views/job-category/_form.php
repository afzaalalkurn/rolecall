<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-category-form">

    <?php $form = ActiveForm::begin(); ?> 


    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#en">EN</a></li>
        <li><a data-toggle="tab" href="#fr">FR</a></li>
    </ul>

    <div class="tab-content">
        <div id="en" class="tab-pane fade in active">            <p>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'basic'
                ]) ?>

                <!--- Template tab Starts -->

                <?= $form->field($modelJobCategoryTemplate, 'description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'basic'
                ]) ?>


                <?= $form->field($modelJobCategoryTemplate, 'responsibility')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'custom'
                ]) ?>

                <?= $form->field($modelJobCategoryTemplate, 'requirement')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'custom'
                ])?>

                <!--- Template tab Ends -->

            </p>
        </div>

        <div id="fr" class="tab-pane fade">

            <p>
                <!--- French tab Start -->
                <?= $form->field($modelJobCategoryFr, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($modelJobCategoryFr, 'description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'basic'
                ]) ?>
                <!--- French tab Ends -->

                <!--- TemplateFr tab Starts -->
                <?= $form->field($modelJobCategoryTemplateFr, 'description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'basic'
                ]) ?>


                <?= $form->field($modelJobCategoryTemplateFr, 'responsibility')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'custom'
                ]) ?>

                <?= $form->field($modelJobCategoryTemplateFr, 'requirement')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'custom'
                ])?>

                <!--- TemplateFr tab Ends -->

            </p>
        </div>
    </div>





    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div> 
    <?php ActiveForm::end(); ?>
</div>






