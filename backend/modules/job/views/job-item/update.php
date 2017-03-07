<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobItem */

$this->title = 'Update Rolecall: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rolecall', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->job_id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="job-item-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=$this->render('_form', [
        'model'                     => $model,
        'modelJobFields'            => $modelJobFields,
        'modelJobFieldValues'       => $modelJobFieldValues,
    ])?>

</div>

