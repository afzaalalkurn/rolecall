<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\search\UserNotification */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Notifications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-notification-index">

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'message_id',
            // 'identifier',
            'job.name',
            //'seq',
            'sender.userProfile.name',
            'text:ntext',
            // 'ip',
            // 'category',
            'status',
            // 'time:datetime',
            // 'created_on',
            [ 'class' => 'yii\grid\ActionColumn', 'template'=>'{delete}', ],
        ],
    ]); ?>

</div>
