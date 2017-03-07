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
            'position.title',
            'plan.name',
            // 'name',
            // 'description:ntext',
            // 'image',
            // 'link',
            [
                'attribute' =>'status',
                'value' => function ($model) { return $model->status == 1 ? 'Enabled' : 'Disabled'; },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url,$model) {
                      
                        return Html::a( '<span class="glyphicon glyphicon-eye-open"></span>',  ['/user/user-ads/view-ajax', 'id'=>$model->ad_id]);
                    },
                    'update' => function ($url,$model) {
                        return Html::a( '<span class="glyphicon glyphicon-pencil"></span>',  ['/user/user-ads/update-ajax', 'id'=>$model->ad_id]);
                    },
                    'delete' => function ($url,$model) {
        return Html::a( '<span class="glyphicon glyphicon-trash"></span>',  ['/user/user-ads/delete-ajax', 'id'=>$model->ad_id]);
    }
                ]
            ],
        ],
    ]); ?> 

</div>
<?php Pjax::end(); ?>