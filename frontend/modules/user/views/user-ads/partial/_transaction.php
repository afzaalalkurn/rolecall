<?php
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 12/7/16
 * Time: 5:18 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$typeList = [
    'Visa' => 'Visa',
    'Mastercard' => 'Mastercard',
    'Discover' => 'Discover',
    'American Express' => 'American Express',
];
$r = range(01, 12);
$monthList = array_combine($r, $r);

$r = range(date('Y'), date('Y') + 21);
$yearList = array_combine($r, $r);
?>


<!--- Credit Card Details Starts -->


<?= $form->field($modelUserTransaction, 'first_name')->textInput(['maxlength' => true]); ?>

<?= $form->field($modelUserTransaction, 'last_name')->textInput(['maxlength' => true]); ?>

<?= $form->field($modelUserTransaction, 'number')->textInput(['maxlength' => true]); ?>

<?= $form->field($modelUserTransaction, 'type')->dropDownList($typeList, ['prompt' => 'Select Type']); ?>

<?= $form->field($modelUserTransaction, 'expire_month')->dropDownList($monthList, ['prompt' => 'Select Month']); ?>

<?= $form->field($modelUserTransaction, 'expire_year')->dropDownList($yearList, ['prompt' => 'Select Year']); ?>

<?= $form->field($modelUserTransaction, 'cvv2')->textInput(['maxlength' => true]); ?>

<!--- Credit Card Details Ends -->


