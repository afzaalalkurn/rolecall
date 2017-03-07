<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;

Modal::begin([
    'header' =>  'Request to Upgrade',
    'id' => 'model',
    'size' => 'model-lg',
    'toggleButton' => ['label' => 'Request to Upgrade',
        'class' => 'btn btn-success',
        'value' => Url::to(['/user/user/upgrade','id' => $id]),
        'id'=>'RequestToUpgrade'],
]);
echo '<div id="modelContent"></div>';
Modal::end();

$js = <<<JS
    $('#RequestToUpgrade').on('click',function(){
        $('#modelContent').load($(this).attr('value'));
    });

JS;

$this->registerJs($js);