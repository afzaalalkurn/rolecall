<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */


?>
Hello <?= $model->username ?>,

<?= Yii::t('job', sprintf('You have been successfully registered on %s.',Yii::$app->name));?>