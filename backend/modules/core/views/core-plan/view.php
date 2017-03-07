<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\core\models\CorePlan */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Core Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="core-plan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'paypal_plan_id',
            'name',
            'description:ntext',
            'plan_type',
            'payment_type',
            'frequency',
            'frequency_interval',
            'cycles',
            'amount',
            'jobs',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
