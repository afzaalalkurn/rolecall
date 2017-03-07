<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\core\models\CoreAdsPosition */

$this->title = 'Create Core Ads Position';
$this->params['breadcrumbs'][] = ['label' => 'Core Ads Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="core-ads-position-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
