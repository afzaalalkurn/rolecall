<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cms\models\search\CmsItem */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cms Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Cms Item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_id',
            'layout_id',
            'slug',
            'external_url:url',
            // 'title',
            // 'content:ntext',
            // 'restricted',
            // 'status',
            // 'meta_title:ntext',
            // 'meta_description:ntext',
            // 'meta_keywords:ntext',
            // 'create_date',
            // 'modified_date',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '/'.$model->slug, ['title' => Yii::t('yii', 'View'),]);
                    }
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
