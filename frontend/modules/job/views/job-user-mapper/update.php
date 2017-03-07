<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobUserMapper */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Job User Mapper',
]) . $model->job_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job User Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->job_id, 'url' => ['view', 'job_id' => $model->job_id, 'user_id' => $model->user_id, 'status' => $model->status]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="job-user-mapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
