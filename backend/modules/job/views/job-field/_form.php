<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\modules\job\models\JobCategory;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobField */
/* @var $form yii\widgets\ActiveForm */

$categoryList = ArrayHelper::map(JobCategory::find()->all(),'category_id','name');

$dependList = ArrayHelper::map($model::find()->all(), 'field_id', 'name');
unset($dependList[$model->field_id]);
reset($dependList);
$validationList =  ['boolean' => 'boolean',
    'captcha' => 'captcha',
    'compare' => 'compare',
    'date' => 'date',
    'datetime' => 'datetime',
    'time' => 'time',
    'default' => 'default',
    'double' => 'double',
    'each' => 'each',
    'email' => 'email',
    'exist' => 'exist',
    'file' => 'file',
    'filter' => 'filter',
    'image' => 'image',
    'in' => 'in' ,
    'integer' => 'integer' ,
    'match' => 'match' ,
    'required' => 'required',
    'safe' => 'safe' ,
    'string' => 'string' ,
    'trim' => 'trim' ,
    'unique' => 'unique' ,
    'url' => 'url' ,
    'ip' => 'ip'
];

$model->is_serialize = ( $model->is_serialize ) ? $model->is_serialize : '0';
$model->is_searchable = ( $model->is_searchable ) ? $model->is_searchable : '0';
$model->for_gender = ( $model->for_gender ) ? $model->for_gender : 'None';

?>
<div class="job-field-form">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <!--<div class="col-sm-6">
            <?= $form->field($model, 'category_id')->dropDownList($categoryList, ['prompt' => 'Select Category']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'section')->dropDownList(['None'=>'None','Summary'=>'Summary', 'Body Information'=>'Body Information'], ['prompt' => 'Select Section']) ?>
        </div>-->
        <div class="col-sm-4">
            <?= $form->field($model, 'depend')->dropDownList($dependList, ['prompt' => 'Select Depend or Parent Option']);?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'section')->dropDownList(['User'=>'Talent', 'Director'=>'Director'], ['prompt' => 'Select Type']) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'layout')->dropDownList(
                ['Project Overview'=>'Project Overview',
                    'Role Overview'=>'Role Overview',
                    'Talent Appearance'=>'Talent Appearance',
                    'Vehicle Appearance'=>'Vehicle Appearance',
                ],
                ['prompt' => 'Select Layout']);?>
        </div>
    </div>

        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'field')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'type')->dropDownList([
                    'Text' => 'Text',
                    'TextArea' => 'TextArea',
                    'Radio' => 'Radio',
                    'List' => 'List',
                    'MultiList' => 'MultiList',
                    'DatePicker' => 'DatePicker',
                    'DropdownRange' => 'DropdownRange',
                    'TextRange' => 'TextRange',
                    'DateRange' => 'DateRange',
                ],
                    ['prompt' => 'Select Type']);
                ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'validation')->dropDownList($validationList, ['prompt' => 'Select Validation']);?>
            </div>
        </div>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'order_by')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->radioList([ '1' => 'Yes', '0' => 'No']); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'is_searchable')->radioList([ '1' => 'Yes', '0' => 'No']); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'is_serialize')->radioList([ '1' => 'Yes', '0' => 'No']); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'for_gender')->radioList([ 'None' => 'None', 'Male' => 'Male','Female'=>'Female','Both' => 'Both']); ?>
        </div>
    </div>

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