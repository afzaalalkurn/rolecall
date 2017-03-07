<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\JqueryAsset;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserAds */
 
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/ajax/main.js', ['depends' => [JqueryAsset::className()]]);
?>
<div class="user-ads-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= ( isset(Yii::$app->user->id) && $model->user_id = Yii::$app->user->id) ? $this->render('partial/_requestbtn', [ 'id' => $model->ad_id,]) : null; ?>

        <?= ( isset(Yii::$app->user->id) && $model->user_id = Yii::$app->user->id && $model->status == 'Pending') ? $this->render('partial/_renewbtn', [ 'id' => $model->ad_id,]) : null; ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            [
                'attribute'=>'image',
                'value' => '/uploads/'.$model->image,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],

            'link',
            [
                'attribute' => 'status',
                'value' => ( $model->status ) ? 'Approved' : 'Pending',
            ],
        ],
    ]); ?>

</div>
