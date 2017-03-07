<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\job\models\search\JobMsg */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Msgs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-msg-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Job Msg', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'message_id',
            'identifier',
            'job_id',
            'seq',
            'sender_id',
            // 'text:ntext',
            // 'ip',
            // 'category',
            // 'status',
            // 'time:datetime',
            // 'created_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
