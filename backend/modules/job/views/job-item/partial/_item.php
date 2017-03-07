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
?>

<?php
        $flds = [];
        foreach($modelJobFields::find()->all() as $i => $modelJobField){
                // necessary for update action.
                $idx = 0;
                if (!$model->isNewRecord) {
                    echo Html::activeHiddenInput($modelJobFieldValues[$i], "[{$i}]job_id");
                    $idx = $i;
                }

            switch($modelJobField->type){
                case 'Text':
                    $flds[$modelJobField->section][$modelJobField->order_by] = $form->field($modelJobFieldValues[$idx], "[{$i}]field_id")->textInput(['maxlength' => true])->label($modelJobField->name);
                    break;
                case 'TextArea':

                    $flds[$modelJobField->section][$modelJobField->order_by] = $form->field($modelJobFieldValues[$idx], "[{$i}]field_id")->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'basic'
                    ]) ->label($modelJobField->name);
                    break;
                case 'List':
                    $optionList = ArrayHelper::map($modelJobField->jobFieldOptions,'option_id','name');
                    $flds[$modelJobField->section][$modelJobField->order_by] = $form->field($modelJobFieldValues[$idx], "[{$i}]field_id")->widget(Select2::classname(), [
                        'data' => $optionList,
                        'options' => ['placeholder' => 'Select ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label($modelJobField->name);
                    break;
                case 'MultiList':
                    $optionList = ArrayHelper::map($modelJobField->jobFieldOptions,'option_id','name');
                    $flds[$modelJobField->section][$modelJobField->order_by] = $form->field($modelJobFieldValues[$idx], "[{$i}]field_id")->widget(Select2::classname(), [
                        'data' => $optionList,
                        'options' => ['placeholder' => 'Select ...', 'multiple' => 'multiple'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label($modelJobField->name);
                    break;
                case 'Radio':
                    $optionList = ArrayHelper::map($modelJobField->jobFieldOptions,'option_id','name');

                    $flds[$modelJobField->section][$modelJobField->order_by] = $form->field($modelJobFieldValues[$idx], "[{$i}]field_id")->RadioList($optionList)->label($modelJobField->name);
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