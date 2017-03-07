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
        <?= Html::a('Update', ['update-ajax', 'id' => $model->ad_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ad_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back', ['index-ajax'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ad_id',
            'name',
            'position.title',
            'plan.name',
            'description:ntext',
            'link',
            [
                'attribute'=>'image',
                'value'=>'/upload/'.$model->image,
                'format' => ['image',['width'=>'230','height'=>'200']],
            ],

            [
                'attribute' => 'status',
                'value' => $model->status == 1 ? 'Live' : 'Blocked',
            ],
            [
                'attribute' => 'request_remove',
                'value' => $model->request_remove == 0 ? 'Live' : 'Remove',
            ],

        ],
    ]) ?>

</div>
<?php Pjax::end(); ?>
