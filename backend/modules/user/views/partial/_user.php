<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 22/9/16
 * Time: 1:25 PM
 */
?>
<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
<?=$form->field($model,  'status')->radioList(['10' => 'Active', '0' => 'Block']);?>

