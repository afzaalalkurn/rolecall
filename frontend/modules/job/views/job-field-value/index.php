<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\job\models\search\JobFieldValue */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Job Field Values');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="job-field-value-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
           /* ['class' => 'yii\grid\SerialColumn'], */
            [
               'label' => 'Title',
               'attribute' => 'field.name',
             ],
            [                      // the owner name of the model
                'label' => 'Information',
                'value' => function($model){
                    return ( $model->field->type == 'MultiList' ) ?
                        implode(', ', unserialize( $model->value ) ) : trim( $model->value ) ;
                },
            ],
            /*'value' ,*/
           /* ['class' => 'yii\grid\ActionColumn'],*/
        ],
    ]); ?>

  
</div>
