<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobField */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Job Field',
]) . $model->field_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->field_id, 'url' => ['view', 'id' => $model->field_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="job-field-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
