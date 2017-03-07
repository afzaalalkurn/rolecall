<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 22/9/16
 * Time: 1:25 PM
 */

$initialLogoPreview  = [];
$initialCoverPhotoPreview = [];


if( $model->logo ){
    $initialLogoPreview[] = Html::img('/uploads/'.$model->logo, ['class' => 'file-preview-image']);
}

if( $model->cover_photo ){
    $initialCoverPhotoPreview[] = Html::img('/uploads/'.$model->cover_photo, ['class' => 'file-preview-image']);
}

?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, "logo")->widget(FileInput::classname(), [
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
        'previewSettings'   => [  'image' => ['width' => '138px', 'height' => 'auto'] ],
        'initialPreview' => $initialLogoPreview,
        'layoutTemplates' => ['footer' => '']
    ]
]);?>

<?= $form->field($model, "cover_photo")->widget(FileInput::classname(), [
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
        'previewSettings'   => [  'image' => ['width' => '138px', 'height' => 'auto'] ],
        'initialPreview' => $initialCoverPhotoPreview,
        'layoutTemplates' => ['footer' => '']
    ]
]);?>
<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
