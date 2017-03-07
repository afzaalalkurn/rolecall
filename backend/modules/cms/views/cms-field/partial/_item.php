<?php
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 11/7/16
 * Time: 11:07 AM
 */
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<div class="panel panel-default" id="filter-option">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Filters</h4></div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsItem[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'name',
                            'value', 
                        ],
                    ]); ?>

<div class="container-items"><!-- widgetContainer -->
    <?php foreach ($modelsItem as $i => $modelItem){ ?>
        <div class="item panel panel-default"><!-- widgetBody -->
            <div class="panel-heading">
                <h3 class="panel-title pull-left">Filter</h3>
                <div class="pull-right">
                    <!--button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button -->
                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <?php
                // necessary for update action.
                if (! $modelItem->isNewRecord) {
                    echo Html::activeHiddenInput($modelItem, "[{$i}]option_id");
                }
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($modelItem, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($modelItem, "[{$i}]value")->textInput(['maxlength' => true]) ?>
                    </div>
                </div><!-- .row -->

            </div>
        </div>
    <?php } ?>
</div>
<div><button type="button" class="add-item btn btn-success btn-sm"><span class="fa fa-plus"></span> New</button></div>
<?php DynamicFormWidget::end(); ?>
</div>
</div>