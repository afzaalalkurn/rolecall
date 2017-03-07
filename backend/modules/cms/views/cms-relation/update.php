<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsRelation */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Relation',
]) . $model->cms_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Relations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cms_id, 'url' => ['view', 'cms_id' => $model->cms_id, 'keyword_id' => $model->keyword_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-relation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
