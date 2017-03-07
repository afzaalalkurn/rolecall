<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('job', 'Change Password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-changepassword">
<div class="loginregistration">
<div class="formicon"></div>
<h1><?= Html::encode($this->title) ?></h1>
   
    <p style="margin: 20px 0 25px"><strong><?= Yii::t('job', 'Please fill out the following fields');?>:</strong></p>

    <?php $form = ActiveForm::begin([
        'id'=>'changepassword-form',
        'options'=>['class'=>'form-horizontal'],
        'fieldConfig'=>[
            'template'=>"{label}\n<div class=\"col-lg-12\">
                        {input}</div>\n<div class=\"col-lg-12\">
                        {error}</div>",
            'labelOptions'=>['class'=>'col-lg-12'],
        ],
    ]); ?>
        <?= $form->field($model,'password',['inputOptions'=>[
            'placeholder'=>'Old Password']])->label(false)->passwordInput() ?>
       
        <?= $form->field($model,'newpass',['inputOptions'=>[
            'placeholder'=>'New Password'
        ]])->label(false)->passwordInput() ?>
       
        <?= $form->field($model,'repeatnewpass',['inputOptions'=>[
            'placeholder'=>'Repeat New Password'
        ]])->label(false)->passwordInput() ?>
       
       <div class="submit">
                <?= Html::submitButton(Yii::t('job', 'Change Password'),[
                    'class'=>'btn btn-primary btn-block'
                ]) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div> 