<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\User */

$role = Yii::$app->user->identity->getRoleName();
if($role == "User")
{
    $this->title = 'Talent Profile';
}else {
    $this->title = $role . ' Profile';
}
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update updateform">
<header class="entry-header">
<h1 class="dashtitle"><?= Html::encode($this->title) ?></h1>
</header>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUserFields'        => $modelUserFields,
        'modelUserFieldValues'   => $modelUserFieldValues,
        'modelUserProfile'       => $modelUserProfile,
        'modelUserAddress'       => $modelUserAddress,
    ]) ?>

</div>
