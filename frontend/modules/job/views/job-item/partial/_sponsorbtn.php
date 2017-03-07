<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;

Modal::begin([
    'header' =>  'Make a Sponsor',
    'id' => 'model',
    'size' => 'model-lg',
    'toggleButton' => ['label' => 'Mark as Sponsor', 'class' => 'btn btn-success', 'value' => Url::to(['/job/job-item/trascation','job_id' => $job_id]),'id'=>'MarkAsSponsor'],
]);
echo '<div id="modelContent"></div>';
Modal::end();

?>
