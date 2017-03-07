<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobFieldValue */

$this->title = $model->job_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Field Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-field-value-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'job_id' => $model->job_id, 'field_id' => $model->field_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'job_id' => $model->job_id, 'field_id' => $model->field_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            [
               'label' => 'Field',
                'attribute' => 'field.field',
             ],
            'value',
        ],
    ]) ?>

</div>