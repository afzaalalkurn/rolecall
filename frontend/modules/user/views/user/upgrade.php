<?php
use alkurn\stripe\StripeCheckoutCustom;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\core\models\CorePlan;

$model = Yii::$app->user->identity->user->userProfile;
$price = ($model->plan) ? $model->plan->amount : 0;
$plan = CorePlan::findOne(['id' => '2']);
$cost = $plan->amount * 100;
$costRound = floor($cost);
?>
<div class="item-view paymenttxt">
<header class="entry-header">

    <h2 class="entry-title"><?= Html::encode('Please wait while payment transaction is in proccess ....') ?></h2>

</header>

<h3><?= Html::encode($this->title) ?></h3>
    <a href="<?php echo Yii::$app->user->returnUrl; ?>">Back</a>

<?= StripeCheckoutCustom::widget([
    'action' => 'execute-payment?id='.$model->user_id,
    'id' => 'payment',
    'name' =>  $model->name,
    'description' => 'Upgrade to Plus',
    'amount' => $costRound ,
    'image' => '/uploads/128x128.png',
    'buttonOptions' => ['class' => 'btn btn-lg btn-success',],
    'tokenFunction' => new JsExpression('function(token){
                $.ajax({
                            url: "execute-payment?id='.$model->user_id.'",
                            type: "post",
                            data:token,
                            dataType: "json",
                            success: function(data) {  
                                 if(data.success == true){
                                    window.location = "/job/job-user-mapper/index";
                                 }
                            }
                      });               

    }'),

    'openedFunction' => new JsExpression('function() { $("#payment").hide(); }'),

    //'closedFunction' => new JsExpression('function() { self.location = "/request?id='.$model->id.'"; }'),

]);

?>

</div>

<?php

$js = <<<JS

    $("#payment").hide();

    $('#payment').trigger('click'); 

JS;

$this->registerJs($js);

?>
