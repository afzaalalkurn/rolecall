<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\jui\DatePicker;
use dosamigos\ckeditor\CKEditor;
use backend\modules\job\models\JobFieldValue;
use backend\modules\job\models\JobField;
?>

<?php
$flds = [];

$modelJFValue = new JobFieldValue();
$jobFields = JobField::findAll(['is_searchable'=> 1, 'section' => 'User']);

foreach($jobFields as $i => $modelJF){
    
    $modelJFValue->field_id = $modelJF->field_id;
    if(isset(Yii::$app->request->queryParams['JobFieldValue'][$modelJF->field_id]['value'])){
        $modelJFValue->value = Yii::$app->request->queryParams['JobFieldValue'][$modelJF->field_id]['value'];
    }
    
 
    switch($modelJF->type){
        case 'Text':
        case 'TextArea':
            $flds[$modelJF->section][$modelJF->order_by]    =
                $form->field($modelJFValue, "[{$modelJF->field_id}]value")->textInput(['maxlength' => true])->label($modelJF->name);
            break;
    
        case 'List':
            $optionList = ArrayHelper::map($modelJF->jobFieldOptions,'name','name');
            $flds[$modelJF->section][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$modelJF->field_id}]value")->widget(Select2::classname(), [
                    'data' => $optionList,
                    'options' => ['placeholder' => 'Select ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label($modelJF->name);
            break;
        case 'MultiList':
            $optionList = ArrayHelper::map($modelJF->jobFieldOptions,'name','name');
            $flds[$modelJF->section][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$modelJF->field_id}]value")->widget(Select2::classname(), [
                    'data'  => $optionList,
                    'options' => ['placeholder' => Yii::t('job', 'Select ...'), 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label($modelJF->name);
            break;
        case 'Radio':
            $optionList = ArrayHelper::map($modelJF->jobFieldOptions,'name','name');
            $flds[$modelJF->section][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$modelJF->field_id}]value")->RadioList($optionList)->label($modelJF->name) ;
            break;
        default:
    }
}

reset($flds);
foreach($flds as $section => $fld_array ){?>
    <?php foreach($fld_array as $fld){ ?>
        <?=$fld;?>
    <?php } ?>
<?php } ?>