<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsItem */

$this->title = Yii::t('app', 'Create Cms Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-item-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
       
    ]) ?>

</div>
