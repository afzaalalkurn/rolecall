<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\user\models\User;
use backend\modules\user\models\UserCompany;

use yii\imagine;
use yii\imagine\Image\Box;
use yii\imagine\Image\Color;
use yii\imagine\Image\ImageInterface;
use yii\imagine\Image\ImagineInterface;
/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//pr($model);
?>
<div class="user-view">
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
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'status',
            'created_at',
            //'updated_at',
        ],
    ]) ?>
  </div>
