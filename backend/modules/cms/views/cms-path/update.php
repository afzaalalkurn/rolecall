<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsPath */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Path',
]) . $model->cms_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Paths'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cms_id, 'url' => ['view', 'cms_id' => $model->cms_id, 'path_id' => $model->path_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-path-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
