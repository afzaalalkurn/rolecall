<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset Password ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">

<div class="loginregistration">
<div class="formicon"></div>
<h1><?= Html::encode($this->title) ?></h1>

    <p style="margin: 20px 0 25px"><strong>Please fill out your email. A link to reset password will be sent there.</strong></p>


            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder'=>"Email Address"])->label(false);?>

                <div class="submit">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary btn-block']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            
        </div>
</div>

