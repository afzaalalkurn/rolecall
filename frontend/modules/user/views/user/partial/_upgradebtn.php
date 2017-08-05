<?php use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;
Modal::begin([
    'header' =>  'Upgrade to Plus',
    'id' => 'model',
    'size' => 'model-lg',
    'toggleButton' => ['label' => 'Upgrade to Plus',
        'class' => 'btn btn-success',
        'value' => Url::to(['/user/user/upgrade',
            'id' => $id]),
        'id'=>'RequestToUpgrade'],]);
echo '<div id="modelContent"></div>';
Modal::end();
$this->registerJs(
    "$('#RequestToUpgrade').on('click',function(){
            $('#modelContent').load($(this).attr('value'));
                });"
);