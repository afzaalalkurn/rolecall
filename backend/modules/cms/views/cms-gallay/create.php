<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\CmsGallay */

$this->title = Yii::t('app', 'Create Cms Gallay');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Gallays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-gallay-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
