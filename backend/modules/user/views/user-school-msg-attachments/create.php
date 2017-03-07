<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserSchoolMsgAttachments */

$this->title = Yii::t('app', 'Create User School Msg Attachments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User School Msg Attachments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-school-msg-attachments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
