<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('job', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">


  <div class="login-form text-xs-center">
    <div class="row">
      <div class="col-xs-12 text-xs-center">
        <div class="logo"><a href="<?=Yii::$app->homeUrl?>"><?php echo Html::img('@web/images/logo.png');?></a></div>
       </div> 
    </div>
    <div class="row">
      <div class="col-md-6">
        <h1>Create a New Account</h1>
        <div class="row">
          <div class="col-xs-12 col-md-6"><a href="<?=Yii::$app->homeUrl?>talent">
            <div class="login-cta"><i class="fa fa-user hidden-sm-down" aria-hidden="true"></i>
              <h4>I'm a Talent</h4>
              <p><!-- react-text: 29 -->I'm looking for Director <!-- /react-text --><br>
                <!-- react-text: 31 --> who are ready to hire!<!-- /react-text --></p>
            </div>
            </a></div>
          <div class="col-xs-12 col-md-6"><a href="<?=Yii::$app->homeUrl?>director">
            <div class="login-cta"><i class="fa fa-user-secret hidden-sm-down" aria-hidden="true"></i>
              <h4>I'm a Casting Director</h4>
              <p><!-- react-text: 39 -->I'm looking to hire <!-- /react-text --><br>
                <!-- react-text: 41 -->  qualified Talent!<!-- /react-text --></p>
            </div>
            </a></div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="or">OR</div>
      </div>
      <div class="col-md-4">
        <h1>Already have an account?</h1>
        <!-- react-text: 47 -->Sign into your existing account below<!-- /react-text -->
        <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['site/auth','type' => 'User'],
        'popupMode' => false,
    ]) ?>
    <h4 class="ortxt"><span>OR</span></h4>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <?/*= $form->field($model, 'username')->textInput(['autofocus' => true]) */?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder'=>"Email Address"])->label('Email Address *');?>
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder'=>"Password"])->label('Password *');?>
    <? //= $form->field($model, 'rememberMe')->checkbox() ?>
    <div class="submit">
      <?= Html::submitButton(Yii::t('job', 'Log In'),
        ['class' => 'btn btn-primary btn-block',
            'name' => 'login-button'])
    ?>
      
    </div>
    <?php ActiveForm::end(); ?>
        <?= Html::a(Yii::t('job', 'Forgot Password?'),
            ['site/request-password-reset'])
        ?>
    </div>
  </div>
  </div>
  
  
  <!--<div class="loginregistration">
    <div class="formicon"></div>
    <h1>
      <?= Html::encode($this->title) ?>
    </h1>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['site/auth'],
        'popupMode' => false,
    ]) ?>
    <h4 class="ortxt"><span>OR</span></h4>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <?/*= $form->field($model, 'username')->textInput(['autofocus' => true]) */?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder'=>"Email Address"])->label(false);?>
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder'=>"Password"])->label(false);?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>
    <div class="submit">
      <?= Html::submitButton(Yii::t('job', 'Login'),
        ['class' => 'btn btn-primary btn-block',
            'name' => 'login-button'])
    ?>
      <p>If you forgot your password you can
        <?= Html::a(Yii::t('job', 'reset it'),
            ['site/request-password-reset'])
        ?>
        .</p>
    </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>-->
