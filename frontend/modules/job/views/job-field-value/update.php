<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobFieldValue */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Job Field Value',
]) . $model->job_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Field Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->job_id, 'url' => ['view', 'job_id' => $model->job_id, 'field_id' => $model->field_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="job-field-value-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
