<?php
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 11/7/16
 * Time: 11:07 AM
 */
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

$jobFieldList = JobField::find()
    ->where(['status' => '1'])
    ->orderBy(['order_by' => SORT_ASC])
    ->all();

foreach($jobFieldList as $i => $modelJF){

    // necessary for update action.
    if(!$model->isNewRecord){
        $form->field($modelJFValue, "[{$i}]job_id")->hiddenInput(['value' => $model->job_id])->label(false);
        $modelJFValue = JobFieldValue::findOne([ 'job_id' => $model->job_id, 'field_id' => $modelJF->field_id]) ?? $modelJFValue;
    }
    echo $form->field($modelJFValue, "[{$i}]field_id")->hiddenInput(['value' => $modelJF->field_id])->label(false);

    switch($modelJF->type){
        case 'Text':
            $flds[$modelJF->section][$modelJF->order_by]    =
                $form->field($modelJFValue, "[{$i}]value")->textInput(['maxlength' => true])->label($modelJF->name);
            break;
        case "DatePicker":
            $flds[$modelJF->section][$modelJF->order_by]
                = $form->field($modelJFValue, "[{$i}]value")->widget(DatePicker::className(), [   'name' => "[{$i}]value",
                'clientOptions' => [
                    'changeMonth' => true,
                    'yearRange' => '1960:'.date('Y'),
                    'changeYear' => true,
                ],])->label($modelJF->name);
            break;
        case 'TextArea':
            $flds[$modelJF->section][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$i}]value")->widget(CKEditor::className(), [
                'options' => ['rows' => 6],
                'preset' => 'basic'
            ]) ->label($modelJF->name);
            break;
        case 'List':
            $optionList = ArrayHelper::map($modelJF->jobFieldOptions,'name','name');
            $flds[$modelJF->section][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$i}]value")->widget(Select2::classname(), [
                'data' => $optionList,
                'options' => ['placeholder' => 'Select ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label($modelJF->name);
            break;
        case 'MultiList':
            $optionList = ArrayHelper::map($modelJF->jobFieldOptions,'name','name');
            $modelJFValue->value = unserialize($modelJFValue->value);
            $flds[$modelJF->section][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$i}]value")->widget(Select2::classname(), [
                'data'  => $optionList,
                'options' => ['placeholder' => 'Select ...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label($modelJF->name); 
            break;
        case 'Radio':
            $optionList = ArrayHelper::map($modelJF->jobFieldOptions,'name','name');
            $flds[$modelJF->section][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$i}]value")->RadioList($optionList)->label($modelJF->name) ;
            break;
        default: 
    }
}

reset($flds);
foreach($flds as $section => $fld_array ){?>
    <div class="job-field-form"><h2><?=$section ;?></h2></div>
    <?php foreach($fld_array as $fld){ ?>
        <?=$fld;?>
    <?php } ?>
<?php } ?>