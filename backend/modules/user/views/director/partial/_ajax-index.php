<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\job\models\search\JobItem */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>

<div class="job-item-index">  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?> 
</div> 
<?php Pjax::end(); ?>
