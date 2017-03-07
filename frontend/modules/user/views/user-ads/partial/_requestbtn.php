<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;

Modal::begin([
    'header' =>  'Request to Remove',
    'id' => 'model',
    'size' => 'model-lg',
    'toggleButton' => ['label' => 'Request to Remove', 'class' => 'btn btn-success', 'value' => Url::to(['/user/user-ads/remove','id' => $id]),'id'=>'RequestToRemove'],
]);
echo '<div id="modelContent"></div>';
Modal::end();

?>
