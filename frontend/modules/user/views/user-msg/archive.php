<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\modules\user\models\search\UserMsgRecipients as UserMsgRecipientsSearch;
use common\models\User as CommonUser;
use yii\helpers\BaseStringHelper;

$icounter = UserMsgRecipientsSearch::countUnReadMsg()->count();

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\search\UserMsg */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Message');
$this->params['breadcrumbs'][] = $this->title;
//$this->registerCssFile('/css/AdminLTE.min.css');


?>
<div class="user-school-msg-index">
    <header class="entry-header">
        <h1 class="dashtitle"><?= Html::encode($this->title) ?></h1>
        <a class="btn btn-primary" href="<?= Url::to("../user-msg")?>">See Messages</a>
    </header>

    <div class="table-responsive mailbox-messages">
        <h2>Archive</h2>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => Yii::t('app','Rolecall'),
                    'attribute' => 'message.job.name',
                ],
                'subject',
                [
                    'label' => Yii::t('app', 'From'),
                    'attribute' => 'sender.userProfile.name',
                    'value' => function($model){
                        return ($model->sender->getRoleName() == CommonUser::ROLE_DIRECTOR) ?  $model->sender->userProfile->name : $model->sender->userProfile->name;
                    }
                ],
                [
                    'label' => Yii::t('app','To'),
                    'attribute' => 'message.job.user.userProfile.name',
                ],
                [
                    'label' => Yii::t('app','Message'),
                    'format' => 'html',
                    'attribute' => 'message.text',
                    'value' => function($model) {
                        return BaseStringHelper::truncateWords($model->message->text ,10,null,false);
                    }
                ],
                [
                    'label' => Yii::t('app','Date'),
                    'attribute' => 'created_on',
                    'format' => ['date', 'php:m/d/Y']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    /*'buttons' => [
                        'archive' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['archive', 'message_id'=>$model->message_id, 'seq' => $model->seq]);
                        },
                    ]*/
                ],
            ],
        ]); ?>
        <!-- /.table -->
    </div>

</div>