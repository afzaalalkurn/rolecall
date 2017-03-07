<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsCategory */

$this->title = Yii::t('app', 'Create Cms Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-category-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>
