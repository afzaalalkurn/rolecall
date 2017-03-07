<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <div id="content">
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
            <li class="active"><a href="#tab-user" data-toggle="tab">General</a></li>
            <li><a href="#tab-profile" data-toggle="tab">Profile</a></li>
            <li><a href="#tab-address" data-toggle="tab">Address</a></li>
            <li><a href="#tab-option" data-toggle="tab">Additional Details</a></li>
        </ul>
        <div id="tab-content" class="tab-content">
            <div class="tab-pane active" id="tab-user">
                <?= $this->render('../partial/_user', ['model' => $model, 'form' => $form]) ?>
            </div>
            <div class="tab-pane" id="tab-profile">
                <?= $this->render('../partial/_user-profile', ['model' => $modelUserProfile, 'form' => $form]) ?>
            </div>
            <div class="tab-pane" id="tab-address">
                <?= $this->render('../partial/_user-address', ['model' => $modelUserAddress, 'form' => $form]) ?>
            </div>
            <div class="tab-pane" id="tab-option">
                <!-- Other Fields -->
                <?= $this->render('../partial/_frm_field', [
                    'form' => $form,
                    'model' => $model,
                    'modelUserFields'        => $modelUserFields,
                    'modelUserFieldValues'   => $modelUserFieldValues,
                    'role' => 'Director'
                ]);?>
                <!-- Other Fields -->
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
