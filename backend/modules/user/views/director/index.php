<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\search\JobOwner */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Director');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            /*[
                'label' => 'Name',
                'attribute' =>'userProfile.name',
            ],
            [
                'label' => 'School',
                'attribute' =>'userSchool.name',
            ],*/
             'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == 10 ? 'Active' : 'Blocked';
                },
            ],
            'created_at:date',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
