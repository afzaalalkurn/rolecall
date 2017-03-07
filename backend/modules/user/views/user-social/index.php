<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\search\UserSocial */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Socials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-social-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Social', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'social_id',
            'user_id',
            'network',
            'access_key',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
