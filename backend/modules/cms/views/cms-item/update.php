<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsItem */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Item',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-item-update">

    <?= $this->render('_form', [
        'model' => $model,
  
    ]) ?>

</div>
