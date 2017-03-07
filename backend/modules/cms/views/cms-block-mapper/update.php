<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsBlockMapper */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Block Mapper',
]) . $model->block_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Block Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->block_id, 'url' => ['view', 'block_id' => $model->block_id, 'cms_id' => $model->cms_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-block-mapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
