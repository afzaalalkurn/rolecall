<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm; 
use yii\captcha\Captcha;
use backend\modules\core\models\CorePlan;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use himiklab\recaptcha\ReCaptcha;

$this->title = 'ReGister as Casting Director';
$this->params['breadcrumbs'][] = $this->title;


$plans = [];

foreach(CorePlan::find()->where(['status'=>1])->all() as $data){
    $plans[$data['id']]  = sprintf("%s - $%.2f",$data['name'],$data['price']);
}

?>
<div class="site-signup">
<div class="loginregistration">
<div class="formicon"></div>
<h1><?= Html::encode($this->title) ?></h1>
	<?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['site/auth'],
        'popupMode' => false,
    ]) ?>
    
    <h4 class="ortxt"><span>OR</span></h4>
    
    <?php $form = ActiveForm::begin(['id' => 'form-signup',
        'options' => ['enctype' => 'multipart/form-data']]);
    ?>
  			
    <?php /*$form->field($model, 'plan_id')->dropDownList($plans,
 ['prompt' => 'Select Membership Plan']); */
    ?>
    <?php /* $form->field($model, 'school_name')->textInput(['autofocus' => true]) */ ?>

    <?= $form->field($model, 'first_name')->textInput(['autofocus' => true, 'placeholder'=>"First Name"])->label(false);?>
    
    <?= $form->field($model, 'last_name')->textInput(['autofocus' => true, 'placeholder'=>"Last Name"])->label(false);?>
    
    <?/*= $form->field($model, 'username')->textInput()*/?>
   
    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder'=>"Email Address"])->label(false);?>
    
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder'=>"Password"])->label(false);?>
    <?php /* $form->field($model, "avatar")->widget(FileInput::classname(), [
        'options' => [
            'multiple'  => false,
            'accept'    => 'image/*',
            'class'     => 'option-image'
        ],
        'pluginOptions' => [
            'previewFileType'   => 'image',
            'showCaption'       => false,
            'showUpload'        => false,
            'showRemove'        => false,
            'browseClass'       => 'btn btn-default btn-sm',
            'browseLabel'       => ' Pick image',
            'browseIcon'        => '<i class="glyphicon glyphicon-picture"></i>',
            'removeClass'       => 'btn btn-danger btn-sm',
            'removeLabel'       => ' Delete',
            'removeIcon'        => '<i class="fa fa-trash"></i>',
            'previewSettings'   => [
                'image' => ['width' => '138px', 'height' => 'auto']
            ],
            'initialPreview' => '',
            'layoutTemplates' => ['footer' => '']
        ]
    ])->label('Logo') */ ?>
    <?php /* $form->field($model, "cover_photo")->widget(FileInput::classname(), [
        'options' => [
            'multiple'  => false,
            'accept'    => 'image/*',
            'class'     => 'option-image'
        ],
        'pluginOptions' => [
            'previewFileType'   => 'image',
            'showCaption'       => false,
            'showUpload'        => false,
            'showRemove'        => false,
            'browseClass'       => 'btn btn-default btn-sm',
            'browseLabel'       => ' Pick image',
            'browseIcon'        => '<i class="glyphicon glyphicon-picture"></i>',
            'removeClass'       => 'btn btn-danger btn-sm',
            'removeLabel'       => ' Delete',
            'removeIcon'        => '<i class="fa fa-trash"></i>',
            'previewSettings'   => [
                'image' => ['width' => '138px', 'height' => 'auto']
            ],
            'initialPreview' => '',
            'layoutTemplates' => ['footer' => '']
        ]
    ]) */ ?>

    <?= $form->field($model, 'is_subscriber')->radioList(['1'=>'Yes', '0'=>'No']); ?>
    <?= $form->field($model, 'verify_code')
        ->widget(ReCaptcha::className()) ?>
    <?= $form->field($model,'agree')->checkbox(); ?>
    <div class="submit">
        <?= Html::submitButton('REGISTER',
            ['class' => 'btn btn-primary btn-block', 'name' => 'signup-button'])
        ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
	</div>
