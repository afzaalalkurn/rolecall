<?php
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 12/7/16
 * Time: 5:18 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

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
<?php Pjax::begin(); ?>

<!--- Credit Card Details Starts -->
<h2><?= Html::encode('Request to Remove Ads') ?></h2>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true]]); ?>

<?= $form->field($model, 'description')->textInput(['maxlength' => true]); ?>

<div class="submit">
    <?= Html::submitButton('Send', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']); ?>
</div>
<?php ActiveForm::end(); ?>
<!--- Credit Card Details Ends -->

<?php Pjax::end(); ?>
