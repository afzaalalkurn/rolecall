<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\user\models\UserSubscription;

use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;

$this->title = Yii::t('job', 'Update Profile');
$this->params['breadcrumbs'][] = $this->title; 

?>
<div class="site-update">
<div class="loginregistration">
<fieldset class="scheduler-border">
<legend class="scheduler-border"><?= Html::encode($this->title) ?></legend>
	<p><strong><?= Yii::t('job', 'Please fill out the following fields');?>:</strong></p>
    <?php $form = ActiveForm::begin(
        ['id' => 'form-update',
        'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
				 
    <?= $form->field($model, 'first_name')->textInput(['autofocus' => true])?>
    <?= $form->field($model, 'last_name')->textInput()?>

    <?= $form->field($model, "avatar")->widget(FileInput::classname(), [
        'options' => [
            'multiple'  => true,
            'accept'    => 'image/*',
            'class'     => 'option-image'
        ],
        'pluginOptions' => [
            'previewFileType'   => 'image',
            'showCaption'       => false,
            'showUpload'        => false,
            'showRemove'        => false,
            'initialPreviewAsData'=>true,
            'browseClass'       => 'btn btn-default btn-sm',
            'browseLabel'       => ' Pick image',
            'browseIcon'        => '<i class="glyphicon glyphicon-picture"></i>',
            'removeClass'       => 'btn btn-danger btn-sm',
            'removeLabel'       => ' Delete',
            'removeIcon'        => '<i class="fa fa-trash"></i>',
            'previewSettings'   => [ 'image' => ['width' => '138px', 'height' => 'auto'] ],
            'initialPreview' => '/uploads/'.$model->avatar,
            'layoutTemplates' => ['footer' => '']
        ]
    ]) ?>

    <?= $form->field($model, "cover_photo")->widget(FileInput::classname(), [
        'options' => [
            'multiple'  => true,
            'accept'    => 'image/*',
            'class'     => 'option-image'
        ],
        'pluginOptions' => [
            'previewFileType'   => 'image',
            'showCaption'       => false,
            'showUpload'        => false,
            'showRemove'        => false,
            'initialPreviewAsData'=>true,
            'browseClass'       => 'btn btn-default btn-sm',
            'browseLabel'       => ' Pick image',
            'browseIcon'        => '<i class="glyphicon glyphicon-picture"></i>',
            'removeClass'       => 'btn btn-danger btn-sm',
            'removeLabel'       => ' Delete',
            'removeIcon'        => '<i class="fa fa-trash"></i>',
            'previewSettings'   => [ 'image' => ['width' => '138px', 'height' => 'auto'] ],
            'initialPreview' => '/uploads/'.$model->cover_photo,
            'layoutTemplates' => ['footer' => '']
        ]
    ]) ?>


    <?= $form->field($model, 'about_us')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'basic'
    ]) ?>
    <div class="submit">
    <div class="form-group">
    <?= Html::submitButton('Update',
        ['class' => 'btn btn-primary',
            'name' => 'update-button'
        ])
    ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>
        </fieldset>
	</div>
</div>
