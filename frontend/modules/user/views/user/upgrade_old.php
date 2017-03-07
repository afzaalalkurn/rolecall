<?php
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 12/7/16
 * Time: 5:18 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\core\models\CorePlan;

$typeList = [
    'visa' => 'Visa',
    'mastercard' => 'Mastercard',
    'discover' => 'Discover',
    'amex' => 'American Express',
];
$r = range(01, 12);
$monthList = array_combine($r, $r);

$r = range(date('Y'), date('Y') + 21);
$yearList = array_combine($r, $r);

$methodList = [1 => 'Paypal', 2 => 'Credit Card'];

$plans = [];

$model = Yii::$app->user->identity->user->userProfile;

$price = ($model->plan) ? $model->plan->amount : 0;

foreach(CorePlan::find()->all() as $data){
    if( $data->amount > $price){
        $plans[$data->id]  = sprintf("%s - $%.2f",$data->name,$data->amount);
    }
}

$model->plan_id = Yii::$app->user->identity->user->userProfile->plan_id;

?>
<style>
    .field-upgradeplanform-creditcard_expirationdate .input-group{width: 100%}
    .field-upgradeplanform-creditcard_cvv .input-group{width: 100%}
    #card{display: none;}
</style>

<!--- Credit Card Details Starts -->

<h2><?= Html::encode('Payment Details') ?></h2>
<?php $form = ActiveForm::begin(['id' => 'upgrade-membership-form', 'options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true]]); ?>
<?=$form->field($modelTransaction, 'plan_id')->dropDownList($plans, ['prompt' => 'Select Membership Plan']);?>

<?= $form->field($modelTransaction, 'first_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($modelTransaction, 'last_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($modelTransaction, 'email')->textInput(['maxlength' => true]) ?> 
<?= $form->field($modelTransaction, 'method')->dropDownList([1 => 'Paypal', 2 => 'Credit Card'], ['prompt' => 'Select Payment Method'])->label('Payment Method'); ?>

    <div id="card">
        <?= $form->field($modelTransaction, 'number')->textInput(['maxlength' => true]); ?>
        <?= $form->field($modelTransaction, 'type')->dropDownList($typeList, ['prompt' => 'Select Type']); ?>
        <?= $form->field($modelTransaction, 'expire_month')->dropDownList($monthList, ['prompt' => 'Select Month']); ?>
        <?= $form->field($modelTransaction, 'expire_year')->dropDownList($yearList, ['prompt' => 'Select Year']); ?>
        <?= $form->field($modelTransaction, 'cvv2')->textInput(['maxlength' => true]); ?>
    </div>
    <div class="submit">
        <?= Html::submitButton('Pay Now', ['class' => $modelTransaction->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']); ?>
    </div>
<?php ActiveForm::end(); ?>
    <!--- Credit Card Details Ends -->

<?php

$js = <<<JS

$('#usertransaction-method').on('change', function() {
    if($(this).val() == 2) {
        $('#card').show();
    } else {
        $('#card').hide();
    }
});

$('#usertransaction-method').trigger('change');
$('#upgrade-membership-form').on('beforeSubmit', function() {
    if($('#usertransaction-method').val() == 2) {
        var cardType = $.payment.cardType($('#usertransaction-number').val());
        $('#usertransaction-type').val(cardType);
    } 
});


JS;
$this->registerJs($js);

