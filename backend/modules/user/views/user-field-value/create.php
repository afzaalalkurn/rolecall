<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserFieldValue */

$this->title = Yii::t('app', 'Create User Field Value');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Field Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-field-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
