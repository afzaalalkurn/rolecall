<?php
use yii\helpers\Html;
$home_URL = Yii::$app->homeUrl;

?>

<?=Html::a(Html::encode($model->network), [$model->link])?>
