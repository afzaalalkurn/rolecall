<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsCategoryMapper */

$this->title = Yii::t('app', 'Create Cms Category Mapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Category Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-category-mapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
