<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm; 
use yii\captcha\Captcha;
use backend\modules\job\models\JobCategory;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use alkurn\recaptcha\ReCaptcha;


$this->title = 'ReGister as Talent';
$this->params['breadcrumbs'][] = $this->title;
$categories = ArrayHelper::map(JobCategory::find()->all(), 'category_id', 'name');
?>

<div class="site-signup">
   
<div class="loginregistration">
<div class="formicon"></div>
<h1><?= Html::encode($this->title) ?></h1>
	 
	 <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['site/auth','type' => 'User'],
        'popupMode' => false,
    ]) ?>
    
    <h4 class="ortxt"><span>OR</span></h4>

    <?php $form = ActiveForm::begin(['id' => 'form-signup',
        'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>

    <?= $form->field($model, 'first_name')->textInput(['autofocus' => true, 'placeholder'=>"First Name *"])->label(false);?>
    
    <?= $form->field($model, 'last_name')->textInput(['autofocus' => true, 'placeholder'=>"Last Name *"])->label(false);?>

    <?/*= $form->field($model, 'username')->textInput(['autofocus' => true])*/?>
    
    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder'=>"Email Address *"])->label(false);?>
    
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder'=>"Password *"])->label(false);?>

     
				 				
    <?= $form->field($model, 'is_subscriber')->radioList(['1'=>'Yes', '0'=>'No']);?>
    <div class="clearfix"></div>
    <?/*php echo $form->field($model, 'verify_code')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-9">{input}</div></div>',
    ]) */?>
    <?= $form->field($model, 'verify_code')->widget(ReCaptcha::className())->label("Captcha *"); ?>
    <?= $form->field($model,'agree')->checkbox(); ?>
    <div class="submit">
        <?= Html::submitButton('REGISTER',
            ['class' => 'btn btn-primary btn-block',
            'name' => 'signup-button'
            ]);
        ?>
        <p>Already have an account? <?= Html::a('Login',['/site/login',],[ 'class'=>'login-link'])?></p>
    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>
