<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsLayout */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Layout',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Layouts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->layout_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-layout-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
