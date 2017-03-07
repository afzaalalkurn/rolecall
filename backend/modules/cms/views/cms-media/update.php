<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsMedia */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Media',
]) . $model->media_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->media_id, 'url' => ['view', 'id' => $model->media_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-media-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
