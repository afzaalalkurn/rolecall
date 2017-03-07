<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use himiklab\recaptcha\ReCaptcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact pe-animation-maybe" data-animation="fadeInLeft">
    <header class="entry-header">
    <h1 class="entry-title"><?= Html::encode($this->title) ?></h1>
    </header>

    <p>
        <strong><?= Yii::t('job', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.');?></strong>
        <br /><br />
    </p>

    <div class="row">
        <div class="col-sm-6">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

                <?= $form->field($model, 'verifyCode')->widget(ReCaptcha::className()) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('job', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-sm-6">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5259.2067614808475!2d9.16422!3d48.77037!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4799db4455092d1b%3A0x962565e643690bee!2sSenefelderstra%C3%9Fe+7%2C+70178+Stuttgart%2C+Germany!5e0!3m2!1sen!2sde!4v1463723230010" width="100%" height="450" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>

</div>
