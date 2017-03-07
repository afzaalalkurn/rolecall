<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserSchoolImages */

$this->title = Yii::t('app', 'Create User School Images');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User School Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-school-images-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
