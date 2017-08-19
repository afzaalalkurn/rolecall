<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\file\FileInput;
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 22/9/16
 * Time: 1:25 PM
 */
$initialImagePreview  = [];
$initialCoverPhotoPreview = [];


if( $model->avatar ){
    $initialImagePreview[] = Html::img('/uploads/'.$model->avatar, ['class' => 'file-preview-image', 'width' => '100', 'height' => '100']);
}

if( $model->cover_photo ){
    $initialCoverPhotoPreview[] = Html::img('/uploads/'.$model->cover_photo, ['class' => 'file-preview-image']);
}

?>

<?= $form->field($model, 'gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => '-- Select --']) ?>
<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, "avatar")->widget(FileInput::classname(), [
    'options' => [
        'multiple'  => false,
        'accept'    => 'image/*',
        'class'     => 'option-image'
    ],
    'pluginOptions' => [
        'previewFileType'   => 'image',
        'showCaption'       => false,
        'showUpload'        => false,
        'showRemove'        => false,
        'browseClass'       => 'btn btn-default btn-sm',
        'browseLabel'       => ' Pick image',
        'browseIcon'        => '<i class="glyphicon glyphicon-picture"></i>',
        'removeClass'       => 'btn btn-danger btn-sm',
        'removeLabel'       => ' Delete',
        'removeIcon'        => '<i class="fa fa-trash"></i>',
        'previewSettings'   => [  'image' => ['width' => '100', 'height' => '100'] ],
        'initialPreview' => $initialImagePreview,
        'layoutTemplates' => ['footer' => '']
    ]
]);?>
<?= $form->field($model, 'dob')->widget(DatePicker::className()) ?>

<?=$form->field($model,  'is_deleted')->radioList(['1' => 'Yes', '0' => 'No']);?>

