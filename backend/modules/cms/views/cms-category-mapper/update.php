<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsCategoryMapper */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Category Mapper',
]) . $model->cms_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Category Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cms_id, 'url' => ['view', 'cms_id' => $model->cms_id, 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-category-mapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
