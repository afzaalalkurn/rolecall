<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;

Modal::begin([
    'header' => Yii::t('app','Send messages to <lable id="user-name">{name}</lable>',['name' => $model->userProfile->getName()]) ,
    'id' => 'modelSendMessage',
    'size' => 'model-lg',
    'toggleButton' => [
        'label' => '',
        'class' => 'fa fa-envelope-o',
        'value' => Url::to(['/messenger', 'item_id' => $item_id, 'user_id' => $user_id]),
        'id'=>'SendMessage'],
]);
echo '<div id="modelContent"><div class="loader"><img src="/uploads/ajax-loader.gif"></div></div>';
Modal::end();
?>