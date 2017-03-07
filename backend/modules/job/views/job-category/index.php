<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\job\models\search\JobCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-category-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Job Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'modified_date:date',
            ['class' => 'yii\grid\ActionColumn'],
        ], 
    ]); ?>
</div>
