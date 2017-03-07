<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobCategoryTemplate */

$this->title = Yii::t('app', 'Create Job Category Template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Category Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-category-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
