<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserFieldValue */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User Field Value',
]) . $model->value_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Field Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->value_id, 'url' => ['view', 'id' => $model->value_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-field-value-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
