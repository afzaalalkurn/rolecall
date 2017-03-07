<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserSchoolImages */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User School Images',
]) . $model->image_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User School Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->image_id, 'url' => ['view', 'id' => $model->image_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-school-images-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
