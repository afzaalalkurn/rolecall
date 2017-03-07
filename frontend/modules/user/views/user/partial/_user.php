<?php
use yii\jui\DatePicker;
use kartik\file\FileInput;
use common\widgets\GooglePlacesAutoComplete;
?>
<h1 class="secondti">Talent Overview</h1>
<div class="row">
      <div class="col-sm-6">
      <?= $form->field($modelUserProfile, 'first_name')
    ->textInput(['maxlength' => true]) ?>
      </div>
    <div class="col-sm-6">
        <?= $form->field($modelUserProfile, 'gender')->dropDownList(
            ['Male' => 'Male', 'Female' => 'Female'],
            ['prompt'=>'Select Gender']); ?>
    </div>
      <div class="col-sm-6">
      <?= $form->field($modelUserProfile, 'last_name')
    ->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-sm-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-sm-6">
      <?= $form->field($modelUserAddress, 'location')->widget(GooglePlacesAutoComplete::className()); ?>
      </div>
      <div class="col-sm-6">
      <?= $form->field($modelUserProfile, 'about_us',[
          'labelOptions' => [ 'label' => 'Bio' ]
      ])->textarea()?>
      </div>
</div>


