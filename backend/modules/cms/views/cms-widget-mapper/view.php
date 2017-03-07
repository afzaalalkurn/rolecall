<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsWidgetMapper */

$this->title = $model->widget_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Widget Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-widget-mapper-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'widget_id' => $model->widget_id, 'cms_id' => $model->cms_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'widget_id' => $model->widget_id, 'cms_id' => $model->cms_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'widget_id',
            'cms_id',
            'order_by',
        ],
    ]) ?>

</div>
