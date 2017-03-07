<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rolecall', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$logo = empty($model->logo) ? 'dummy-img.jpg' : trim($model->logo);
?>

<div class="job-item-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->job_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->job_id], [
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
            'job_id',
            'user_id',
            'name',
            /*[
            'attribute'=>'logo',
            'value'=>'/uploads/'.$logo,
            'format' => ['image',['width'=>'230','height'=>'200']],
            ], */
            'description:ntext',
            //'status',
            'create_dated',
            'modified_dated',
        ],
    ]) ?>

    <?=$misc;?>
    <?=$user;?>

</div>
