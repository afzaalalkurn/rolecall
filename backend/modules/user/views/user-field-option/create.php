<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserFieldOption */

$this->title = Yii::t('app', 'Create User Field Option');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Field Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-field-option-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
