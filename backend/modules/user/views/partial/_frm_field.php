<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\jui\DatePicker;
use dosamigos\ckeditor\CKEditor;
use backend\modules\user\models\UserFieldValue;
use backend\modules\user\models\UserField;
use kartik\file\FileInput;


$flds = [];

$modelUFValue = new UserFieldValue();

$userFieldList = UserField::find()
    ->where(['status' => '1', 'section' => $role])
    ->orderBy(['layout' => SORT_ASC, 'order_by' => SORT_ASC])
    ->all();

foreach($userFieldList as $i => $modelUF)
{

    // necessary for update action.
    if(!$model->isNewRecord){
        $form->field($modelUFValue, "[{$i}]user_id")->hiddenInput(['value' => $model->id])->label(false);
        $modelUFValue = UserFieldValue::findOne([ 'user_id' => $model->id, 'field_id' => $modelUF->field_id]) ?? $modelUFValue;
    }

    echo $form->field($modelUFValue, "[{$i}]field_id")
        ->hiddenInput(['value' => $modelUF->field_id])
        ->label(false);

    switch($modelUF->type){
        case 'Text':
            $flds[$modelUF->section][$modelUF->layout][$modelUF->order_by]
                = $form->field($modelUFValue,
                "[{$i}]value")->textInput()
                ->label($modelUF->name);
            break;
        case "DatePicker":
            $flds[$modelUF->section][$modelUF->layout][$modelUF->order_by]
                = $form->field($modelUFValue, "[{$i}]value")->widget(DatePicker::className(), [   'name' => "[{$i}]value",
                'clientOptions' => [
                    'changeMonth' => true,
                    'yearRange' => '1960:'.date('Y'),
                    'changeYear' => true,
                ],])->label($modelUF->name);
            break;
        case 'TextArea':
            $flds[$modelUF->section][$modelUF->layout][$modelUF->order_by] =
                $form->field($modelUFValue,
                    "[{$i}]value")->widget(CKEditor::className(),
                    ['options' => ['rows' => 6],
                        'preset' => 'basic'])
                    ->label($modelUF->name);
            break;
        case 'List':
            $optionList = ArrayHelper::map($modelUF->userFieldOptions,'name','name');
            $flds[$modelUF->section][$modelUF->layout][$modelUF->order_by] =
                $form->field($modelUFValue,
                    "[{$i}]value")->widget(Select2::classname(),
                    ['data' => $optionList,
                        'options' => ['placeholder' => 'Select ...'],
                        'pluginOptions' => ['allowClear' => true],])
                    ->label($modelUF->name);
            break;
        case 'MultiList':
            $optionList = ArrayHelper::map($modelUF->userFieldOptions,'name','name');
            //$modelUFValue->value = unserialize($modelUFValue->value);
            $modelUFValue->value = ($modelUFValue->value);
            $flds[$modelUF->section][$modelUF->layout][$modelUF->order_by] =
                $form->field($modelUFValue,
                    "[{$i}]value")->widget(Select2::classname(),
                    ['data'  => $optionList,
                        'options' =>
                            ['placeholder' => 'Select ...', 'multiple' => true],
                        'pluginOptions' => ['allowClear' => true],])
                    ->label($modelUF->name);
            break;
        case 'Radio':
            $optionList = ArrayHelper::map($modelUF->userFieldOptions,'name','name');
            $flds[$modelUF->section][$modelUF->layout][$modelUF->order_by] =
                $form->field($modelUFValue,
                    "[{$i}]value")->RadioList($optionList)->label($modelUF->name) ;
            break;

        case 'File':
            $flds[$modelUF->section][$modelUF->layout][$modelUF->order_by] =
                $form->field($modelUFValue,  "[{$i}]value")->widget(FileInput::classname(), [
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
                        'previewSettings'   => [ 'image' => ['width' => '138px', 'height' => 'auto'] ],
                        /*'initialPreview' => ['/uploads/'.$model->logo,]*/
                        'layoutTemplates' => ['footer' => '']
                    ]
                ])->label($modelUF->name) ;
            break;

        case 'Files':
            $flds[$modelUF->section][$modelUF->layout][$modelUF->order_by] =
                $form->field($modelUFValue,  "[{$i}]value[]")->widget(FileInput::classname(), [
                    'options' => [
                        'multiple'  => true,
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
                        /*'initialPreview' => '/uploads/'.$model->logo,*/
                        'layoutTemplates' => ['footer' => '']
                    ]
                ])->label($modelUF->name) ;
            break;

        default:
    }
}
reset($flds);
foreach($flds as $section => $layout_array ){ reset($layout_array); ?>
    <div class="job-field-form">
        <h2><?= $section;?></h2>
    </div>
    <?php foreach($layout_array  as $layout => $fld_array){  reset($fld_array);?>
        <h2><?= $layout;?></h2>
        <?php foreach($fld_array  as $key => $fld){?>
            <?=$fld;?>
        <?php } ?>
    <?php } ?>
<?php }?>

