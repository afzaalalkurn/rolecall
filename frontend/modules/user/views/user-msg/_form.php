<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JqueryAsset;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\file\FileInput;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserMsg */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/ajax/main.js', ['depends' => [JqueryAsset::className()]]);

$user = Yii::$app->user->identity->userProfile;


?>

<?php Pjax::begin([
    'id' => 'user-msg-form',
    'timeout' => 2000,
    'enablePushState' => false
]); ?>
<div class="user-msg-form">
        <?php
        $form = ActiveForm::begin([
            'options' => ['enctype'     => 'multipart/form-data', 'data-pjax' => true],
            'enableClientValidation'    =>  true,
            'action'                    =>  ['/user/user-msg/create', 'user_id' => $user_id, 'job_id' => $job_id, 'message_id' => $message_id],
            'id'                        =>  'user-msg-form']);
        ?>
        <?= $form->field($model, 'subject')->textInput(['maxlength' => true]);?>

        <?php if($user->plan && $user->plan->id > 1 ){?>
            <?= $form->field($model, 'attachment[]')->widget(FileInput::classname(), [
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'previewFileType' => 'any',
                    'showPreview' => true,
                    'showCaption' => false,
                    'showRemove' => true,
                    'browseLabel' => 'Add Attachment',
                    'showUpload' => false
                ]
            ]);?>
        <?php } ?>

        <?= $form->field($model, 'text')->
        textarea(['rows' => '10','columns' => '5']);?>

        <div class="form-group">
            <?=Html::submitButton(Yii::t('app', 'Send Message'), ['class' => 'btn btn-success','id'=>'sendMsgBtn']);?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
<?php Pjax::end(); ?>

<?php

$this->registerJs(
    '$("document").ready(function(){
        /*$("#sendMsgBtn").click(function (){
            $.ajax({
            success: function () {
                $("#user-msg-form").html("Sending Message...");
            },
            });
        });*/
        $("#user-msg-form").on("pjax:end", function() {
             setTimeout(function() {$("#model").modal("hide");}, 6000); 
        });
    });'
);
?>
