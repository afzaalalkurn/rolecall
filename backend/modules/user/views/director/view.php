<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ListView;
use himiklab\thumbnail\EasyThumbnailImage;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>


        <?php
            Modal::begin([
                'header' => 'Browse Jobs',
                'id' => 'model-jobs',
                'size' => 'model-lg',
                'toggleButton' => [ 'label' =>  'Browse Rolecall',
                    'class' =>  'btn btn-success',
                    'value' =>  Url::to(['/job/job-item/index-ajax','user_id'=>$model->id]),
                    'id'    =>  'BrowseJobs'],
            ]);
            echo '<div id="modelContentJobs"></div>';
            Modal::end();
        ?>

        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
            /* 'id', */
            [
                'label' => 'Name',
                'attribute' =>'userProfile.name',
            ],
            'email:email',
            [
                'attribute' => 'status',
                'value' => $model->status == 10 ? 'Active' : 'Blocked',
            ],
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?> 
</div>
<?php
$js = <<<JS

    $('#BrowseJobs').on('click',function(){
        $('#modelContentJobs').load($(this).attr('value'));
    });
    
    $('#BrowseAds').on('click',function(){
        $('#modelContentAds').load($(this).attr('value'));
    });

JS;

$this->registerJs($js);

?>
