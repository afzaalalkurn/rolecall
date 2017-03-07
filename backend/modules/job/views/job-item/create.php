<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobItem */

$this->title = 'Create Rolecall';
$this->params['breadcrumbs'][] = ['label' => 'Rolecall', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-item-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model'                 => $model, 
        'modelJobFields'        => $modelJobFields,
        'modelJobFieldValues'   => $modelJobFieldValues,
    ]) ?>

</div>
