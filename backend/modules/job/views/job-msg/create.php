<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobMsg */

$this->title = 'Create Job Msg';
$this->params['breadcrumbs'][] = ['label' => 'Job Msgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-msg-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
