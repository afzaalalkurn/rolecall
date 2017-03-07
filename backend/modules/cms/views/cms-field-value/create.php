<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsFieldValue */

$this->title = Yii::t('app', 'Create Cms Field Value');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Field Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-field-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
