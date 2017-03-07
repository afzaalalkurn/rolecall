<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobItem */


$this->params['breadcrumbs'][] = ['label' => 'Dashboard',
    'url' => ['/dashboard']];

$this->title = 'Update Rolecall: ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Rolecall',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => ['view','id' => $model->job_id]
];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-sm-9">
<div class="job-item-update">
<div class="loginregistration">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="productbgcolor">
    <?=$this->render('_form', [
        'model'            => $model,
        'modelJobFields'   => $modelJobFields,
        'modelJobFieldValues' => $modelJobFieldValues,
    ])
    ?>
    </div>
</div>    
</div>
</div>