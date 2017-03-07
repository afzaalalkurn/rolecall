<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsItem */

$this->title = $model->title; 
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-item-view">

    <header class="entry-header">
<h1 class="entry-title"><?= Html::encode($model->title) ?></h1>
</header>

   <?=$model->content;?> 

</div>
