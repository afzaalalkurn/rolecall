<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use backend\modules\job\models\JobItem;
?>
<div class="container">
    <div class="banner-text pe-animation-maybe" data-animation="fadeInDown">
        <h1>Find Job</h1>
        <h3>We have <span><?= JobItem::find()->count()?></span> Job offers for you!</h3>
        <?php $form = ActiveForm::begin(
            ['action' => ['/job/job-item/index'],
                'options' => ['class' => 'find-job',],
                'method' => 'get']); ?>
            <?= Html::input('text', '_name', Yii::$app->request->get('_name'), ['class' => 'text-field', 'placeholder' =>'Search by director name...']) ?>
            <?= Html::input('text', '_zip', Yii::$app->request->get('_zip'), ['class' => ' text-field', 'placeholder' => 'Search by Zipcode...']) ?>
            <?= Html::submitButton('SEARCH', ['class' => "btn btn-primary find-btn"]); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>