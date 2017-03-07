<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\core\models\CorePlan */

$this->title = 'Create Core Plan';
$this->params['breadcrumbs'][] = ['label' => 'Core Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="core-plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
