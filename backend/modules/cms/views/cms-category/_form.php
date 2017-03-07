<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\cms\models\search\CmsCategoryPath as CmsCategoryPath;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsCategory */
/* @var $form yii\widgets\ActiveForm */

$searchModel = new CmsCategoryPath();

$sourceCategories = ArrayHelper::map($searchModel->getCategories()->createCommand()->queryAll(), 'id', 'text');
?>

<div class="cms-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_id')->widget( Select2::classname(), [
        'data' => $sourceCategories,
        'options' => ['placeholder' => 'Select a parent ...'],
        'pluginOptions' =>  [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
