<?php  
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\JqueryAsset; 
use backend\modules\user\models\UserSubscriber;

$modelSubscriber  = new UserSubscriber();
?>

<div class="newsletter pe-animation-maybe" data-animation="fadeInLeft">
    <h3>Newsletter</h3>
    Sign up to receive Latest Jobs UPDATES 
       <?php
            $form = ActiveForm::begin([
                'enableAjaxValidation'      => true,
                'enableClientValidation'    => true,
                'validationUrl'             =>  '/user/user-subscriber/validation',
                'action'                    =>  '/user/user-subscriber/create',
                'id'                        =>  'user-subscriber-form']); ?>
            <?= $form->field($modelSubscriber, 'email')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('job', 'Send'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
    </div>  
<?php

$js = <<<JS
    
    $('form#user-subscriber-form').on('beforeSubmit', function(e) {
        e.preventDefault();
        var form = $(this);
        console.log($(form));
              
        if($(form).find('.has-error').length) { return false; }
        
        $.ajax({
            url: $(form).attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function(data) {
                console.log(data);
                $('.help-block').html(data.msg);
            }
        });        
        return false;               
    }).on('submit', function(e){
        e.preventDefault();
    });

JS;

$this->registerJs($js);