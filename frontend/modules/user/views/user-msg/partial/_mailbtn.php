<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;
use backend\modules\job\models\JobUserMapper;

$title = Yii::t('app', 'Reply');
Modal::begin([
    'header' => $title,
    'id' => 'model',
    'size' => 'model-lg',
    'toggleButton' => [ 'label' => $title,
                        'class' => 'btn btn-success',
                        'value' => Url::to(['/user/user-msg/create',
                        'identifier' => $identifier,
                        'message_id' => $message_id]), 'id' => 'SendMessage'],
]);
echo '<div id="modelContent"></div>';
Modal::end();
?>
