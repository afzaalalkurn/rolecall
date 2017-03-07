<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsWidget */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Widget',
]) . $model->widget_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Widgets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->widget_id, 'url' => ['view', 'id' => $model->widget_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-widget-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
