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
use backend\modules\job\models\JobFieldValue;
use backend\modules\job\models\JobField;

$this->registerJsFile('@web/js/custom-job.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<?php
$flds = [];
$modelJFValue = new JobFieldValue();
$role = Yii::$app->user->identity->getRoleName();
$jobFieldList = JobField::find()->where(['status' => '1'])->orderBy(['order_by' => SORT_ASC])->all();
$fieldRange = [];
$optionListRange = [];
$modelJFValueRange = [];
$valueI = [];


foreach ($jobFieldList as $i => $modelJF) {

    // necessary for update action.
    if (!$model->isNewRecord) {
        $form->field($modelJFValue, "[{$i}]job_id")->hiddenInput(['value' => $model->job_id])->label(false);
        $modelJFValue = JobFieldValue::findOne(['job_id' => $model->job_id, 'field_id' => $modelJF->field_id]) ?? $modelJFValue;
    }
    echo $form->field($modelJFValue, "[{$i}]field_id")->hiddenInput(['value' => $modelJF->field_id])->label(false);

    $param = [];
    $indxFlds[$modelJF->field_id] = $i;

    if (!is_null($modelJF->depend) && isset($indxFlds[$modelJF->depend])) {
        $idxDepend = $indxFlds[$modelJF->depend];
        $param = ['class' => 'depended-field',
            'depended-field_id' => $idxDepend,
            'depends' => 'jobfieldvalue-' . $idxDepend . '-value'];
    }

    switch ($modelJF->type) {
        case 'Text':
            $flds[$modelJF->section][$modelJF->layout][$modelJF->order_by] =
                $form->field($modelJFValue,
                    "[{$i}]value")->textInput($param)
                    ->label($modelJF->name);
            break;
        case "DatePicker":
            $flds[$modelJF->section][$modelJF->layout][$modelJF->order_by]
                = $form->field($modelJFValue,
                "[{$i}]value")->widget(DatePicker::className(),
                ['name' => "[{$i}]value",
                    'clientOptions' => [
                        'changeMonth' => true,
                        'autoclose' => true,
                        'yearRange' => '1950:' . date('Y'),
                        'changeYear' => true,
                    ],])->label($modelJF->name);
            break;
        case 'TextArea':
            $flds[$modelJF->section][$modelJF->layout][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$i}]value")
                    ->textarea(['rows' => '6', 'columns' => '10'])
                    ->label($modelJF->name);
            break;
        case 'List':
            $optionList = ArrayHelper::map($modelJF->jobFieldOptions, 'value', 'name');
            $flds[$modelJF->section][$modelJF->layout][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$i}]value")->widget(Select2::classname(), [
                    'data' => $optionList,
                    'options' => ['placeholder' => 'Select ...', $param],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label($modelJF->name);
            break;
        case 'MultiList':
            $optionList = ArrayHelper::map($modelJF->jobFieldOptions, 'value', 'name');
            $modelJFValue->value = ($modelJFValue->field && is_null($modelJFValue->field->is_serialize)) ? ArrayHelper::map($modelJF->jobFieldValues, 'value_id', 'value') : @unserialize($modelJFValue->value);
            $flds[$modelJF->section][$modelJF->layout][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$i}]value")->widget(Select2::classname(), [
                    'data' => $optionList,
                    'options' => ['placeholder' => 'Select ...', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label($modelJF->name);

            break;

        case 'Radio':
            $optionList = ArrayHelper::map($modelJF->jobFieldOptions, 'value', 'name');
            $flds[$modelJF->section][$modelJF->layout][$modelJF->order_by] =
                $form->field($modelJFValue, "[{$i}]value")->RadioList($optionList)->label($modelJF->name);
            break;
        case 'DropdownRange':
        case 'TextRange':

            list($name, $sufix) = explode('-', $modelJF->field);
            $fieldRanges[$name][$sufix] = $modelJF;
            $optionListRange[$modelJF->field] = ArrayHelper::map($modelJF->jobFieldOptions, 'value', 'name');
            $modelJFValueRange[$modelJF->field] = $modelJFValue;
            $valueI[$name][$sufix] = "[{$i}]value";
            $value = (is_array($modelJFValue->value)) ? current($modelJFValue->value) : $modelJFValue->value;
            echo $form->field($modelJFValue, "[{$i}]value")->hiddenInput(['value' => $value])->label(false);
            break;
        default:
    }
}

foreach ($fieldRanges as $name => $fieldRange) {

    $range = [];

    foreach ($fieldRange as $sufix => $modelJF) {



        switch ($sufix) {
            case 'from':
                $fromField = $modelJF;
                break;
            case 'to':
                $toField = $modelJF;
                break;
        }

        $modelJFValue = $modelJFValueRange[$modelJF->field];

        switch ($modelJF->field) {
            case "age-from":
            case "age-to":
            $range[$sufix] = $modelJFValue->value . ' yrs';
                break;
            case "height-from":
            case "height-to":
                if ($modelJFValue->value > 0) {
                    $inches = ceil($modelJFValue->value / 2.54);
                    $feet = floor(($inches / 12));
                    $range[$sufix] = $feet . " ft. " . ($inches % 12) . ' in.';
                }
                break;
            case "weight-from":
            case "weight-to":
            $range[$sufix] = $modelJFValue->value . ' lbs.';
                break;
            case 'waist-from':
            case 'waist-to':
            case 'neck-from':
            case 'neck-to':
            case 'shoulders-from':
            case 'shoulders-to':
            case 'sleeve-from':
            case 'sleeve-to':
            case 'inseam-from':
            case 'inseam-to':
            case 'bust-from':
            case 'bust-to':
            case 'hips-from':
            case 'hips-to':
            case 'chest-from':
            case 'chest-to':
                if ($modelJFValue->value > 0) {
                    $range[$sufix] = ceil($modelJFValue->value / 2.54) . " in.";
                }
                break;
            default:
                $range[$sufix] = $modelJFValue->value;
        }

    }

    $modelFromJFValue = $modelJFValueRange[$fromField->field];
    $modelToJFValue = $modelJFValueRange[$toField->field];
    $options = array_keys($optionListRange[$toField->field]);

    $fromId = Html::getInputId($modelFromJFValue, $valueI[$name]['from']);
    $toId = Html::getInputId($modelToJFValue, $valueI[$name]['to']);

    if (isset($modelFromJFValue->value) && empty($modelFromJFValue->value)) {
        $modelFromJFValue->value = current($options);
    }

    if (isset($modelToJFValue->value) && empty($modelToJFValue->value)) {
        $modelToJFValue->value = end($options);
    }

    $slider_range = (is_array($range) && count($range) > 0) ? implode(' - ', $range) : '';

    switch ($modelJF->type) {
        case 'DropdownRange':
        case 'TextRange':
        $content ='<div class="form-group ' . $name . '-' . $sufix . '">';
        $content .= '<label for="label">' . ucwords($name) . ': ';

        $content .= '<span id="range-' . $name . '">' . $slider_range . '</span>';
        $content .= '</label>';
        $content .= '<div class="slider" 
                        data-name ="' . $name . '"
                        data-from ="' . current($options) . '"  
                        data-to ="' . end($options) . '"  
                        data-from-id ="' . $fromId . '" 
                        data-to-id ="' . $toId . '"
                        data-from-value="' . $modelFromJFValue->value . '" 
                        data-to-value="' . $modelToJFValue->value . '"
                        ></div> 
                    </div>';
        $flds[$fromField->section][$fromField->layout][$fromField->order_by] = $content;
            break;
    }
}

reset($flds);
foreach ($flds as $section => $layout_array) {
    reset($layout_array);
    ?>
    <div class="job-field-form">
        <!--<h1 class="secondti">
        <?php if ($role == "User") {
            echo $section;
        } ?>
        </h1>-->
    </div>
    <?php
    foreach ($layout_array as $layout => $fld_array) {
        reset($fld_array);
        ?>
        <h1 class="secondti">
            <?= ($layout != 'Project Overview') ? $layout : null; ?>
        </h1>
        <div class="row">
            <?php foreach ($fld_array as $key => $fld) { ?>
                <div class="col-sm-4 job-field-<?= $key ?>"> <?= $fld; ?></div>
            <?php } ?>
        </div>
    <?php } ?>
<?php } ?>

<?php
$js = <<<JS
 
$( function() {
  
    // setup 
    $( ".slider" ).each(function() {
        
        var slider = $(this);
        var fromRg = parseFloat( slider.attr('data-from') ) ;
        var toRg = parseFloat( slider.attr('data-to') ) ;
        
        var fromVal =  parseFloat( slider.attr('data-from-value') );
        var toVal   =  parseFloat( slider.attr('data-to-value') );
        
        var name = slider.attr('data-name') ;    
        
        if(fromVal == '') fromVal = fromRg; 
        if(toVal == '') toVal = toRg; 
                
        var fromInput = slider.attr('data-from-id'); 
        var toInput = slider.attr('data-to-id'); 
        
        $( slider ).slider({
          range: true,
          min: fromRg,
          max: toRg,
          values: [ fromVal, toVal ],
          slide: function( event, ui ) {
              
            from = ui.values[ 0 ];  
            to = ui.values[ 1 ];
            
            $( "#"+fromInput ).val(  from  );
            $( "#"+toInput ).val( to );
            var range = $('#range-'+name);
            console.log(range);
            
            switch(name){
                case "sleeve":                
                case "waist":                
                case "inseam":                
                case "hips":                
                case "bust":                
                case "neck":                
                case "chest":                
                case "shoulders":  
                    from = Math.ceil( from / 2.54 ) +  " in.";
                    to = Math.ceil( to / 2.54 ) +  " in.";;
                    range.html(from + ' - '+ to) ;    
                    break;
                case "height": 
                    var inches = Math.ceil(from / 2.54);
                    var feet = Math.floor((inches / 12));
                    var from = feet + " ft. " + (inches % 12) + ' in.';
                    
                    var inches = Math.ceil(to / 2.54);
                    var feet = Math.floor((inches / 12));
                    var to = feet + " ft. " + (inches % 12) + ' in.';  
                    range.html(from + ' - '+ to);       
                    
                    break;
                case "weight": 
                    from = from + 'lbl.';
                    to = to+ 'lbl.';
                    range.html( from + ' - '+ to) ;       
                    break;
                case "age":
                    from = from + 'yrs.';
                    to = to+ 'yrs.'; 
                    range.html( from + ' - '+ to) ;       
                    break;
                    
            }  
            
          }
        }); 
        
    });
    
  } );
      
    
JS;

$this->registerJs($js);
