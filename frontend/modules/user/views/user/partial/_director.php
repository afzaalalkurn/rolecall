<?php
use yii\jui\DatePicker;
use kartik\file\FileInput;
use common\widgets\GooglePlacesAutoComplete;
?>

<div class="row">
      <div class="col-sm-6">
      <?= $form->field($modelUserProfile, 'first_name')
    ->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-sm-6">
      <?= $form->field($modelUserProfile, 'last_name')
    ->textInput(['maxlength' => true]) ?>
      </div>
</div>      

<div class="row">
    <div class="col-sm-6">
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($modelUserAddress, 'location')->widget(GooglePlacesAutoComplete::className()); ?>
    </div>
</div> 

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($modelUserProfile, 'dob',[
            'labelOptions' => [ 'label' => 'Birthday' ]
        ])->widget(DatePicker::className(), [   'name' => 'dob',
            'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => '1960:'.date('Y'),
                'changeYear' => true,
                'label' => 'Yesterday',
            ],]);?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($modelUserProfile, 'gender')
            ->radioList(['Male'=>'Male', 'Female'=>'Female']);?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($modelUserProfile, 'about_us',[
            'labelOptions' => [ 'label' => 'Bio' ]
        ])->textarea()?>
    </div>
    <div class="col-sm-6">
<?=$form->field($modelUserProfile,  'avatar',['labelOptions' => [ 'label' => 'Profile Pic' ]])->widget(FileInput::classname(), [
    'options' => [
        'multiple'  => false,
        'accept'    => 'image/*',
        'class'     => 'option-image'
    ],
    'pluginOptions' => [
        'previewFileType'   => 'image',
        'showCaption'       => false,
        'showUpload'        => false,
        'showRemove'        => false,
        'initialPreviewAsData'=>true,
        'browseClass'       => 'btn btn-default btn-sm',
        'browseLabel'       => ' Pick image',
        'browseIcon'        => '<i'.' class="glyphicon glyphicon-picture"></i>',
        'removeClass'       => 'btn btn-danger btn-sm',
        'removeLabel'       => ' Delete',
        'removeIcon'        => '<i'.' class="fa fa-trash"></i>',
        'previewSettings'   => [
            'image' => ['width' => '138px', 'height' => 'auto']
        ],
        'initialPreview' => ['/uploads/'.$modelUserProfile->avatar,],
        'layoutTemplates' => ['footer' => '']
    ],
]); ?>
    </div>
</div>

