<?php
use ruskid\stripe\StripeForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\core\models\CorePlan;

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
    </style>

    <!--- Credit Card Details Starts -->

    <h2><?= Html::encode('Payment Details') ?></h2>
<?php
$form = StripeForm::begin([
    'id' => 'upgrade-membership-form',
    'tokenInputName' => 'stripeToken',
    'errorContainerId' => 'payment-errors',
    'brandContainerId' => 'cc-brand',
    'errorClass' => 'has-error',
    'applyJqueryPaymentFormat' => true,
    'applyJqueryPaymentValidation' => true,
    'options' => ['autocomplete' => 'on']
]);
?>
<?=$form->field($modelTransaction, 'plan_id')->dropDownList($plans, ['prompt' => 'Select Membership Plan']);?>
<?= $form->field($modelTransaction, 'first_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($modelTransaction, 'last_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($modelTransaction, 'email')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
    <label for="number" class="control-label">Card number</label>
    <span id="cc-brand"></span>
    <?= $form->numberInput() ?>
</div>

<div class="form-group">
    <label for="cvc" class="control-label">CVC</label>
    <?= $form->cvcInput() ?>
</div>

<div class="form-group">
    <label for="exp-month" class="control-label">Month</label>
    <?= $form->monthInput() ?>
</div>

<div class="form-group">
    <label for="exp-year" class="control-label">Year</label>
    <?= $form->yearInput() ?>
</div>

<div id="payment-errors"></div>

    <div class="submit">
        <?= Html::submitButton('Pay Now', ['class' => $modelTransaction->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']); ?>
    </div>

<?php StripeForm::end(); ?>