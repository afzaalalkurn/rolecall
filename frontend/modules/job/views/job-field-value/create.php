<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobFieldValue */

$this->title = Yii::t('app', 'Create Job Field Value');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Field Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-field-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
