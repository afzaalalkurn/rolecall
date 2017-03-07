<?php
use yii\helpers\Html;
$home_URL = Yii::$app->homeUrl;
?>

<div class="row">
    <div class="col-sm-3">
               <h4> <?=Html::encode($model->field->field);?> :  <?= Html::encode($model->value)?></h4>
    </div>
</div>