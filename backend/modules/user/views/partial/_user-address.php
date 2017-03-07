<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\GooglePlacesAutoComplete;
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 22/9/16
 * Time: 1:25 PM
 */
?>

<?= $form->field($model, 'location')->widget(GooglePlacesAutoComplete::className()); ?>
<?/*= $form->field($model, 'address_line_1')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'address_line_2')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'address_line_3')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'is_primary')->radioList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) */?>

