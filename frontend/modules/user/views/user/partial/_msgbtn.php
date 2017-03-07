<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;

Modal::begin([
    'header' =>  'Send Message',
    'id' => 'model',
    'size' => 'model-lg',
    'toggleButton' => ['label' => 'Send Message', 'class' => 'btn btn-success', 'value' => Url::to(['/user/user-msg/create','job_id' => $model->job_id]),'id'=>'SendMessage'],
]);
echo '<div id="modelContent"></div>';
Modal::end();

?>
