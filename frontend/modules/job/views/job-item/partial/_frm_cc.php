<?php
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 12/7/16
 * Time: 5:18 PM
 */
use yii\helpers\Html;
$typeList = [
    'Visa' => 'Visa',
    'Mastercard' => 'Mastercard',
    'Discover' => 'Discover',
    'American Express' => 'American Express',
];

$monthList = [
    '01' => '01',
    '02' => '02',
    '03' => '03',
    '04' => '04',
    '05' => '05',
    '06' => '06',
    '07' => '07',
    '08' => '08',
    '09' => '09',
    '10' => '10',
    '11' => '11',
    '12' => '12',
];

$r = range(date('Y'), date('Y')+21);
$yearList = array_combine($r, $r);
?>
<h2><?= Html::encode ('Payment Details')?></h2>

<!--- Credit Card Details Starts -->
<?= $form->field($modelJobTransaction, 'first_name')->textInput(['maxlength' => true]); ?>

<?= $form->field($modelJobTransaction, 'last_name')->textInput(['maxlength' => true]); ?>

<?= $form->field($modelJobTransaction, 'number')->textInput(['maxlength' => true]); ?>

<?= $form->field($modelJobTransaction, 'type')->dropDownList($typeList, ['prompt' => 'Select Type']);?>

<?= $form->field($modelJobTransaction, 'expire_month')->dropDownList($monthList, ['prompt' => 'Select Month']);?>

<?= $form->field($modelJobTransaction, 'expire_year')->dropDownList($yearList, ['prompt' => 'Select Year']);?>

<?= $form->field($modelJobTransaction, 'cvv2')->textInput(['maxlength' => true]); ?>

<!--- Credit Card Details Ends -->