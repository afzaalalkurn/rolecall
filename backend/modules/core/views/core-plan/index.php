<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\core\models\search\CorePlan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Core Plans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="core-plan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Core Plan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'paypal_plan_id',
            'name',
            //'description:ntext',
            'plan_type',
            // 'payment_type',
            // 'frequency',
            // 'frequency_interval',
            // 'cycles',
             'amount',
            // 'jobs',
             'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
