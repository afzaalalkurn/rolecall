<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;

Modal::begin([
    'header' =>  'Request to Renew',
    'id' => 'model',
    'size' => 'model-lg',
    'toggleButton' => ['label' => 'Request to Renew', 'class' => 'btn btn-success', 'value' => Url::to(['/user/user-ads/renew','id' => $id]),'id'=>'RequestToRenew'],
]);
echo '<div id="modelContent"></div>';
Modal::end();
?>
