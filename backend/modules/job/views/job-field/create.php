<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobField */

$this->title = Yii::t('app', 'Create Job Field');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-field-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'modelsItem' => $modelsItem,
    ]) ?>

</div>
