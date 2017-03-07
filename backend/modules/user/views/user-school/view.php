<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserSchool */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$logo = empty($model->logo) ? 'dummy-img.jpg' : trim($model->logo);
$cover_photo = empty($model->cover_photo) ? 'dummy-img.jpg' : trim($model->cover_photo);
?>
<div class="user-school-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->user_id], [
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
            'user_id',
            'name',
            [
            'attribute'=>'logo',
            'value'=>'/uploads/'.$logo,
            'format' => ['image',['width'=>'230','height'=>'200']],
            ],
            [
            'attribute'=>'Cover Photo',
            'value'=>'/uploads/'.$cover_photo,
            'format' => ['image',['width'=>'230','height'=>'200']],
            ],
            'description:ntext',
            'location',
        ],
    ]) ?>

</div>
