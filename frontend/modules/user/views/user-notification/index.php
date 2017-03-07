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
<header class="entry-header">
   <h1 class="dashtitle"><?= Html::encode($this->title) ?></h1>
</header>

<div class="table-responsive mailbox-messages">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           // 'message_id',
           // 'identifier',
            //'job.name',
            //'seq',
            //'sender.userProfile.name',
            [
                'label' => 'Rolecall',
                'attribute' => 'job.name',
            ],
            [
               'label' => 'Message',
               'attribute' => 'text',
            ],
            //'text:ntext',
            // 'ip',
            // 'category',
            //'status',
            // 'time:datetime',
            // 'created_on',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',


            ],
        ],
    ]); ?>
</div>
</div>
