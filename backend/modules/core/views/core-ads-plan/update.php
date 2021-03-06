<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\core\models\CoreAdsPlan */

$this->title = 'Update Core Ads Plan: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Core Ads Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="core-ads-plan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
