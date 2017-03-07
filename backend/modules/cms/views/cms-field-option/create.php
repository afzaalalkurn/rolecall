<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsFieldOption */

$this->title = Yii::t('app', 'Create Cms Field Option');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Field Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-field-option-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
