<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobUserMapper */

$this->title = Yii::t('app', 'Create Job User Mapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job User Mappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-user-mapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
