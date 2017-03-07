<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;
use backend\modules\job\models\JobUserMapper;

$title = Yii::t('app', 'Send Message');
Modal::begin([
    'header' => $title,
    'id' => 'model',
    'size' => 'model-lg',
    'toggleButton' => ['label' => '', 'class' => 'fa fa-envelope-o', 'value' => Url::to(['/user/user-msg/create', 'user_id' => $model->id, 'job_id' => $job_id]), 'id' => 'SendMessage'],
]);
echo '<div id="modelContent"></div>';
Modal::end();

$js = <<<JS

    $('#SendMessage').on('click',function(){
        $('#modelContent').load($(this).attr('value'));
    }); 
    
JS;

$this->registerJs($js);