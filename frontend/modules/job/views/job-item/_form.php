<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use backend\modules\job\models\JobItem;
use common\widgets\GooglePlacesAutoComplete;
use kartik\file\FileInput;
/*use kartik\form\ActiveForm;*/
/*use kartik\slider\Slider;*/

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobItem */
/* @var $form yii\widgets\ActiveForm */

$initialImagePreview  = [];
if( $model->logo ){
    $initialImagePreview[] = Html::img('/uploads/'.$model->logo, ['class' => 'file-preview-image']);
}

?>
<div class="job-item-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div id="content">
        <h1 class="overview">Project Overview</h1>
        <div id="my-tab-content" class="tab-content">
            <div class="tab-pane active" id="tab-en">
            
            <div class="row">
               <div class="col-sm-6">
                 <?= $form->field($model, 'name',[
                'labelOptions' => [ 'label' => 'Project Name' ]
            ])->textInput(['maxlength' => true]) ?>
               </div>
                <div class="col-sm-6">
                    <?=
                    $form->field($model,  'logo')->widget(FileInput::classname(), [
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
                            'initialPreview' => (!empty($model->logo) ? '/uploads/'.$model->logo : null),
                            'layoutTemplates' => ['footer' => '']
                        ],
                    ]);
                    ?>
                </div>
            </div>
            
            <div class="row">
               <div class="col-sm-6">
                 <?= $form->field($model, 'create_dated',[
                'labelOptions' => [ 'label' => 'Start Date' ]
            ])->widget(DatePicker::className(), [   'name' => 'create_dated',
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                    'yearRange' => date('Y').':2050',
                    'minDate' => 'today',
                ],]);
            ?>
               </div>
               <div class="col-sm-6">
                 <?= $form->field($model, 'expire_date',[
                'labelOptions' => [ 'label' => 'End Date' ]
            ])->widget(DatePicker::className(), [   'name' => 'expire_date',
                'clientOptions' => [
                    'changeMonth' => true,
                    'autoclose' => true,
                    'yearRange' => date('Y').':2050',
                    'changeYear' => true,
                    'minDate' => 'today',
                ],
            ]);
            ?>
               </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'location')
                        ->widget(GooglePlacesAutoComplete::className()); ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    /*echo $form->field($model, 'radius')->widget(Slider::classname(), [
                        'pluginOptions'=>[
                            'min'=>1,
                            'max'=>100,
                            'step'=>1
                        ]
                    ]);*/
                    ?>
                    <?= $form->field($model, 'radius',[
                        'labelOptions' => [ 'label' => 'Within Miles' ]
                    ])->textInput(['maxlength' => true]);?>
                </div>
            </div>

            
             <div class="row">
               <div class="col-sm-6">
                 <?= $form->field($model, 'description',[
                     'labelOptions' => [ 'label' => 'Project Details' ]
                 ])->textarea(['rows' => '10','columns' => '5'])
                 ?>
               </div>

            </div>

            <?= $this->render('partial/_frm_field', [
                'form' => $form,
                'model' => $model,
                'modelJobFields'        => $modelJobFields,
                'modelJobFieldValues'   => $modelJobFieldValues,
            ]);?>
            </div>
        </div>
    </div>
    <div class="submit">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary'])?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<JS

    $('#jobitem-create_dated').on('change', function (){ 
    var startDate = new Date($(this).val());
    startDate.setDate(startDate.getDate() + 1);
    $("#jobitem-expire_date").datepicker("option", "minDate", startDate);
    });
    
    $('#jobitem-expire_date').on('change', function (){ 
    var endDate = new Date($(this).val());
    endDate.setDate(endDate.getDate() - 1);
    $("#jobitem-create_dated").datepicker("option", "maxDate", endDate);
    });
JS;

$this->registerJs($js);