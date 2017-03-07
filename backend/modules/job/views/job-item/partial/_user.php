<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\job\models\search\JobUserMapper */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job User Mappers';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="job-user-mapper-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' =>'User',
                'value' => function ($model) {
                    return $model->user->userProfile->getName();
                },
            ], 
        ],
    ]); ?>


</div>
