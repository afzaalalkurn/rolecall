<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsWidgetMapper */

$this->title = Yii::t('app', 'Create Cms Widget Mapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Widget Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-widget-mapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
