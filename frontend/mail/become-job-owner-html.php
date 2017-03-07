<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
<div class="password-reset">
    <p>Hello <?= Html::encode($model->username) ?>,</p>

    <p><?= Yii::t('job', sprintf('<b>Hello %s</b><br/><br/>Welcome to %s , You have been successfully registered on %s. Thank you for connecting with us.<br/><br/><b>Regards,</b><br/><b>%s Team</b>', $model->username, Yii::$app->name, Yii::$app->name,Yii::$app->name));?></p>

</div>
