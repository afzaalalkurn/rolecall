<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\job\models\JobCategory;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use dosamigos\ckeditor\CKEditor;
use backend\modules\job\models\JobItemFr;

use yii\jui\Tabs;
use kartik\select2\Select2;
use kartik\file\FileInput;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobItem */
/* @var $form yii\widgets\ActiveForm */

$categories = ArrayHelper::map(JobCategory::find()->all(), 'category_id', 'name');

$initialImagePreview  = [];

if( $model->logo ){
    $initialImagePreview[] = Html::img('/uploads/'.$model->logo, ['class' => 'file-preview-image']);
}

?>
<?php Pjax::begin([
    'id' => 'pjax-job-item-form',
    'timeout' => 1,
    'enablePushState' => false,
]); ?>

<div class="job-item-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true]]); ?>

    <div id="content">
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
            <li class="active"><a href="#tab-en" data-toggle="tab">General</a></li>
            <!--<li><a href="#tab-data" data-toggle="tab">Data</a></li>-->
            <li><a href="#tab-option" data-toggle="tab">Additional Details</a></li>
        </ul>
        <div id="my-tab-content" class="tab-content">
            <div class="tab-pane active" id="tab-en">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'basic'
                ]) ?>
            </div>
            <!--<div class="tab-pane" id="tab-data">
                <?=$form->field($model,  'status')->radioList(['1' => 'Yes', '0' => 'No']);?>
            </div>-->
            <div class="tab-pane" id="tab-option">
                <!-- Other Fields -->
                <?= $this->render('partial/_frm_field', [
                    'form' => $form,
                    'model' => $model,
                    'modelJobFields'        => $modelJobFields,
                    'modelJobFieldValues'   => $modelJobFieldValues,
                ]);?>
                <!-- Other Fields -->
            </div>
        </div>
    </div>


    <div class="submit">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php Pjax::end(); ?>