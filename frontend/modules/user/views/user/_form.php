<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use common\widgets\GooglePlacesAutoComplete;
/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */

$role = strtolower(Yii::$app->user->identity->getRoleName());

?>
<div class="user-form">
    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data']]
    ); ?>
    <div class="row">
        <?= $this->render('partial/_frm_'.$role, [
                'form' => $form,
                'model' => $model,
                'role' => $role,
                'modelUserFields'        => $modelUserFields,
                'modelUserFieldValues'   => $modelUserFieldValues,
                'modelUserProfile'       => $modelUserProfile,
                'modelUserAddress'       => $modelUserAddress,
            ]); ?>
    </div>
    <div class="submit">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
