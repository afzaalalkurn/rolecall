<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsWidgetMapper */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Widget Mapper',
]) . $model->widget_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Widget Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->widget_id, 'url' => ['view', 'widget_id' => $model->widget_id, 'cms_id' => $model->cms_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-widget-mapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
