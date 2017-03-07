<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobUserMapper */

$this->title = $model->job_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job User Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-user-mapper-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'job_id' => $model->job_id, 'user_id' => $model->user_id, 'status' => $model->status], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'job_id' => $model->job_id, 'user_id' => $model->user_id, 'status' => $model->status], [
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
            'job_id',
            'user_id',
            'status',
        ],
    ]) ?>

</div>
