<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\job\models\search\JobItem */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'joblist']) ?>
<div class="job-item-index" >
    <?= GridView::widget([
        'dataProvider' => $dataProvider, 
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' =>'User',
                'value' => function ($model) { return $model->user->userProfile->getName(); },
            ],
            [
                'attribute' =>'status',
                'value' => function ($model) { return $model->status == 1 ? 'Yes' : 'No'; },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url,$model) {
                        return Html::a( '<span class="glyphicon glyphicon-eye-open"></span>',  ['/job/job-item/view-ajax', 'id'=>$model->job_id]);
                    },
                    'update' => function ($url,$model) {
                        return Html::a( '<span class="glyphicon glyphicon-pencil"></span>',  ['/job/job-item/update-ajax', 'id'=>$model->job_id]);
                    },
                    'delete' => function ($url,$model) {
        return Html::a( '<span class="glyphicon glyphicon-trash"></span>',  ['/job/job-item/delete-ajax', 'id'=>$model->job_id]);
    }
                ]


            ],
        ],
    ]); ?>
</div>
<?php Pjax::end(); ?>