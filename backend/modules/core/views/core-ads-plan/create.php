<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\core\models\CoreAdsPlan */

$this->title = 'Create Core Ads Plan';
$this->params['breadcrumbs'][] = ['label' => 'Core Ads Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="core-ads-plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
