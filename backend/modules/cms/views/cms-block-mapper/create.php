<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsBlockMapper */

$this->title = Yii::t('app', 'Create Cms Block Mapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Block Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-block-mapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
