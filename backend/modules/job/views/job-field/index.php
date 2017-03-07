<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\job\models\search\JobField */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rolecall Fields');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-field-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Rolecall Field'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'field_id',
            //'category_id',
            //'section',
            'field',
            'name',
            'type',
            [
                'attribute' =>'is_searchable',
                'value' => function ($model) { return $model->is_searchable == 1 ? 'Yes' : 'No'; },
            ],

            'order_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
