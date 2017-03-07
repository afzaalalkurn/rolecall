<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\cms\models\CmsLayout;
use backend\modules\cms\models\CmsCategory;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsItem */
/* @var $form yii\widgets\ActiveForm */

$layout_list = ArrayHelper::map(CmsLayout::find()->all(), 'layout_id', 'name');
$category_list = ArrayHelper::map(CmsCategory::find()->all(), 'category_id', 'name');
?>

<div class="cms-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <div id="content">  
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'content')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],'preset' => 'basic'
        ])?>
        <?= $form->field($model, 'meta_title')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'meta_keywords')->textarea(['rows' => 6]) ?> 
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
