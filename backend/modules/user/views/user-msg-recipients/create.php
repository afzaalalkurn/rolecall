<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserMsgRecipients */

$this->title = Yii::t('app', 'Create User Msg Recipients');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Msg Recipients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-msg-recipients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
