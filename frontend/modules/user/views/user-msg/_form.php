<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JqueryAsset;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\file\FileInput;
use yii\widgets\Pjax;
use backend\modules\user\models\UserMsgAttachments;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserMsg */
/* @var $form yii\widgets\ActiveForm */
//$this->registerJsFile('@web/ajax/main.js', ['depends' => [JqueryAsset::className()]]);

$user = Yii::$app->user->identity->userProfile;

$modelAttachments = new UserMsgAttachments();
?>

<?php Pjax::begin([
    'id' => 'user-msg-form-custom',
    'timeout' => 2000,
    'enablePushState' => false
]);?>
<div class="user-msg-form">
        <?php
        $form = ActiveForm::begin([
            'options' => ['enctype'     => 'multipart/form-data', 'data-pjax' => true],
            'enableClientValidation'    =>  true,
            'action'                    =>  ['/message-send', 'user_id' => $user_id, 'item_id' => $item_id, 'message_id' => $message_id],
            'id'                        =>  'user-msg-form']);
        ?>
        <?= $form->field($model, 'subject')->textInput(['maxlength' => true]);?>

        <?php if($user->plan && $user->plan->id > 1 ){?>

            <?php
            echo $form->field($modelAttachments, 'attachment[]')->widget(FileInput::classname(), [
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'showPreview' => true,
                    'showRemove' => false,
                    'showUpload' => false,
                    'showCaption' => false,
                    'browseLabel' => ' Attachment',
                    'previewFileType' => 'any',
                    'overwriteInitial' => false,
                    'maxFileSize'=>2800
                ],
            ])->label(false);
            ?>

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

$js = <<<JS
    $("document").ready(function(){
        $("#user-msg-form-custom").on("pjax:end", function() {
            setTimeout(function() {
            $("#model").modal("hide");
            }, 6000); 
            window.location.reload();
        });
    });
JS;

$this->registerJs($js);



