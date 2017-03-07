<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Job Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php Pjax::begin() ?>
<div class="job-item-view">
    <p>
        <?= Html::a('Update', ['update-ajax', 'id' => $model->job_id], ['class' => 'btn btn-primary']) ?>
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
            [
                'attribute'=>'logo',
                'value'=>'/uploads/' . ($model->logo ?? 'dummy-img.jpg'),
                'format' => ['image',['width'=>'230','height'=>'200']],
            ],           
            'description:ntext',
            'requirement',
            'ref_url:url',
            'status',
            'expire_date',
            'create_dated',
            'modified_dated',
        ],
    ]);?>
    
    <?=$misc;?>
</div>
<?php Pjax::end(); ?>
