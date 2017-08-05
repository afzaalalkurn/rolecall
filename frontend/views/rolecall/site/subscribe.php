<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => 'newsletter-subscribe-form','action' => 'site/subscribe']);?>
<?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder'=>"Enter your Email Address"])->label(false);?>

<div class="form-group submitbtn">
    <?= Html::submitButton(Yii::t('job', 'Subscribe'), ['class' => 'search-btn', 'name' => 'subscribe-btn']) ?>
</div>

<?php ActiveForm::end(); ?>

