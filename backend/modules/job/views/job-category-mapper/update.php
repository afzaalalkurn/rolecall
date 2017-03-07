<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobCategoryMapper */

$this->title = 'Update Job Category Mapper: ' . $model->job_id;
$this->params['breadcrumbs'][] = ['label' => 'Job Category Mappers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->job_id, 'url' => ['view', 'job_id' => $model->job_id, 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="job-category-mapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
