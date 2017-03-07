<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\widgets\RightTopWidget;
use yii\helpers\Url;
?>

<!--header section start here-->
<section class="header">
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="logo wow bounceInLeft">
            <?php
            if(Yii::$app->user->isGuest)
            {
                $homeUrl = Yii::$app->homeUrl;
            }
            else
            {
                if(Yii::$app->user->identity->isDirector())
                {
                    $homeUrl = Url::to(['/site/dashboard']);
                }
                else if(Yii::$app->user->identity->isUser())
                {
                    $homeUrl = Url::to(['/job/job-user-mapper/index',
                        'user_id'=>Yii::$app->user->id,
                        'status' => 'Pending']);
                }
            }
            ?>
            <a href="<?=$homeUrl;?>">
                <?php echo Html::img('@web/images/logo.png');?>
            </a>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="headerbottom wow bounceInRight">
          <?php  if (Yii::$app->user->isGuest) { ?>
          <div class="userlink">
          	<!--<a href="mailto:info@rolecall.com" class="login-link">Contact</a> -->
            <?= Html::a('Login/Sign Up',['/login',],[ 'class'=>'btn-tasker']);?> 
            <?= Html::a('Become a Talent', ['/talent',],[ 'class'=>'btn-tasker']);?>
            <? //= Html::a('Become a Director', ['/become-job-owner',],[ 'class'=>'btn-tasker'])?>
          </div>
          <?php } else {
			  $logout = '<div class="logout">'. Html::beginForm(['/logout'], 'post'). Html::submitButton('Logout',['class' => 'btn btn-link'] ). Html::endForm(). '</div>';
            ?>
            
            <div class="dropdown profilesetting">
            <span class="welcome">
                <?php
                if(Yii::$app->user->identity->userProfile->avatar) {
                  echo Html::img('@web/uploads/' . Yii::$app->user->identity->userProfile->avatar);
                }else
                {
                  echo Html::img('@web/images/profile-img.jpg');
                }?>
            </span>
                <a href="#" class="dropdown-link" data-toggle="dropdown">
                    <?=Yii::$app->user->identity->username?>
                    <i class="fa fa-angle-down"></i>
                </a>
            <ul class="dropdown-menu">
               <li><?php if(Yii::$app->user->identity->isDirector()){?>
                 <?= Html::a('Dashboard', ['/site/dashboard']);}
                 else if(Yii::$app->user->identity->isUser()){?>
                   <?= Html::a('Dashboard',
                         ['/job/job-user-mapper/index',
                             'user_id'=>Yii::$app->user->id,
                             'status' => 'Pending']);
                 }?>
               </li>
               <?= RightTopWidget::widget();?>
               <li><?=$logout?></li>
            </ul>
            </div>
            	<!--<div class="log-hr-top"><div class="ds-txt"><i class="fa fa-tachometer" aria-hidden="true"></i> <? //= Html::a('Dashboard', ['/site/dashboard'])?> </div>
            </div>-->
                <!-- notifications -->
                <?php echo $this->render('partial/_notification'); ?>
                <!-- notifications -->
          <?php } ?>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--header section end here--> 

<!--banner section start here-->
<section class="banner">
  <div class="container">
    <div class="row">
      <div class="col-sm-12"> 
        <!--<div class="row">
          <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <div class="top-menu wow fadeInRight">
              <div class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                  <a class="navbar-brand" href="#"></a> </div>
                <div class="collapse navbar-collapse">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Post a job</a></li>
                    <li><a href="#">Find a Job</a></li>
                    <li><a href="#">How it works</a></li>
                    <li><a href="#">Need a quote</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">INSURANCE COVER</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>-->
        <div class="bannertext wow fadeInUp">
        <div class="headdiv">RoleCall</div>
		<span>A Casting Management System</span><br />
		Discover . Connect . Manage
          <!--<div class="wow bounceInUp"><a class="btn btn-primary">Learn More</a></div>-->
        </div>
      </div>
    </div>
  </div>
</section>
<!--banner section end here-->