<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\job\models\JobCategory;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\search\JobItem */
/* @var $form yii\widgets\ActiveForm */


?>
    <?php
    $form = ActiveForm::begin([
        'action' => ['/job/job-item/index'],
        'method' => 'get'
    ]);
    ?>
      <div class="input-group">
       <?= $form->field($model, 'name')->textInput(array('placeholder' => 'Serach By Teacher Name','class' => 'form-control searchmeg'))->label(false) ?>
        <span class="input-group-btn" style="width:0px;"></span>
          
      </div>
      <?= Html::submitButton('Search  <i class="fa fa-search" aria-hidden="true"></i>', ['class' => 'btn btn-primary'])?>

    <?php ActiveForm::end(); ?>