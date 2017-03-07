<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserSocial */

$this->title = 'Create User Social';
$this->params['breadcrumbs'][] = ['label' => 'User Socials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-social-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
