<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use backend\modules\core\models\CoreAdsPlan;
use backend\modules\core\models\CoreAdsPosition;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserAds */
/* @var $form yii\widgets\ActiveForm */

$positions = [];
foreach(CoreAdsPosition::find()->all() as $data){
    /*$positions[$data['id']]  = sprintf("%s %dX%d - %d",$data['title'],$data['height'], $data['width'], $data['size']);*/

    $positions[$data['id']]  = sprintf("%s %dX%d",$data['title'],$data['height'], $data['width']);
}

$plans = [];
foreach(CoreAdsPlan::find()->all() as $data){
    $plans[$data['id']]  = sprintf("%s - $%d",$data['name'],$data['price']);
}


?>

<div class="user-ads-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'plan_id')->widget(Select2::classname(), [
        'data' => $plans,
        'options' => ['placeholder' => 'Select a Plan...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Select Plan');?>

    <?= $form->field($model, 'position_id')->widget(Select2::classname(), [
        'data' => $positions,
        'options' => ['placeholder' => 'Select a Position...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Select Position');?>

    <?= $form->field($model, "image")->widget(FileInput::classname(), [
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
            'initialPreviewAsData' => true,
            'browseClass'       => 'btn btn-default btn-sm',
            'browseLabel'       => ' Pick image',
            'browseIcon'        => '<i class="glyphicon glyphicon-picture"></i>',
            'removeClass'       => 'btn btn-danger btn-sm',
            'removeLabel'       => ' Delete',
            'removeIcon'        => '<i class="fa fa-trash"></i>',
            'previewSettings'   => [
                'image' => ['width' => '138px', 'height' => 'auto']
            ],
            'initialPreview' => !empty( $model->image ) ? '/uploads/'.$model->image : '',
            'layoutTemplates' => ['footer' => '']
        ]
    ]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $this->render('partial/_transaction', [
        'form' => $form,
        'modelUserTransaction' => $modelUserTransaction,
    ]);?>

    <?=$form->field($model,  'status')->radioList(['1' => 'Yes', '0' => 'No']);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
