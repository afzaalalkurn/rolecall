<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserField */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User Field',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->field_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-field-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsItem' => $modelsItem,
    ]) ?>

</div>
