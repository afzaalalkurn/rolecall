<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsMenuPath */

$this->title = Yii::t('app', 'Create Cms Menu Path');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Menu Paths'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-menu-path-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
