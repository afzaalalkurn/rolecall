<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;
use backend\modules\job\models\JobUserMapper;


$title = Yii::t('app', 'Send Message');

/*
if ((JobUserMapper::findOne(['job_id' => $model->job_id, 'user_id' => Yii::$app->user->id, 'status' => 'Applied'])) === null) {
    $status = 'Applied';
    $title = Yii::t('app', 'Apply & Send Message!');
}*/

Modal::begin([
    'header' => $title,
    'id' => 'model',
    'size' => 'model-lg',
    'toggleButton' => ['label' => $title, 'class' => 'btn btn-success', 'value' => Url::to(['/user/user-msg/create', 'user_id' => $model->user_id, 'job_id' => $job_id]), 'id' => 'SendMessage'],
]);
echo '<div id="modelContent"></div>';
Modal::end();
?>
