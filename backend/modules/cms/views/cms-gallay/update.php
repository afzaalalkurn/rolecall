<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsGallay */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Gallay',
]) . $model->image_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Gallays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->image_id, 'url' => ['view', 'id' => $model->image_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-gallay-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
