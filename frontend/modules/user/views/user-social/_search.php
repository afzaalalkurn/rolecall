<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\search\UserSocial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-social-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'social_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'network') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'access_key') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
