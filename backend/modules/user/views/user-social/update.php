<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserSocial */

$this->title = 'Update User Social: ' . ' ' . $model->social_id;
$this->params['breadcrumbs'][] = ['label' => 'User Socials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->social_id, 'url' => ['view', 'id' => $model->social_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-social-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
