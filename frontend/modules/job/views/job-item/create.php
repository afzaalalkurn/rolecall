<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\JobItem */

$this->params['breadcrumbs'][] = ['label' => 'Dashboard','url' => ['/dashboard']];
$this->title = 'Create Rolecall';
$this->params['breadcrumbs'][] = [ 'label' => 'Rolecall','url' => ['index'] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-item-create">
<div class="loginregistration">
<h1><?= Html::encode($this->title) ?></h1>

<div class="productbgcolor">
    <?=$this->render('_form', [
        'model'                 => $model,
        'modelJobFields'        => $modelJobFields,
        'modelJobFieldValues'   => $modelJobFieldValues,
    ])?>
</div>
</div>
</div>