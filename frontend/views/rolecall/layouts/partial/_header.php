<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

?>
<header>
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-12 comp-logo pe-animation-maybe" data-animation="fadeInDown">
          <div class="logo"><a href="<?=Yii::$app->homeUrl?>"> <?php echo Html::img('@web/images/logo.jpg');?></a></div>
        </div>
        <div  class="col-md-9 col-sm-8 col-xs-12 header-right pe-animation-maybe" data-animation="fadeInLeft"> 
        <?php  if (Yii::$app->user->isGuest) { ?>
              <div class="hr-top">
                <span><?= Html::a('Login',['/site/login',],[ 'class'=>'hrt-btn'])?>  </span>
                <span><?= Html::a('register', ['/site/signup',],[ 'class'=>'hrt-btn'])?>  </span>
               	<span><?= Html::a('Post a Job', ['/site/become-job-owner'],[ 'class'=>'hr-postjob'])?></span>
              </div>
          <?php } else { 
		        $logout = '<div class="logout">'. Html::beginForm(['/site/logout'], 'post'). Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')',['class' => 'btn btn-link'] ). Html::endForm(). '</div>';
            ?>
            <div class="col-sm-4 log-hr-top"><div class="ds-txt"><?= Html::a('Dashboard', ['/site/dashboard'])?> </div>
            <div class="head-log"><?=  $logout?></div></div>
          <?php } ?>
          
          <div class="topbottomSec">
            <div class="top-menu">
            <?php
    NavBar::begin([
        'brandLabel' => 'Music Teacher',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-inverse',
        ],
    ]);
	/*
	http://job.alkurn.net/job/job-item
	*/
    $menuItems = [
        ['label' => 'Home', 'url' => ['/']],
		['label' => 'About us', 'url' => ['/site/about']],
    	['label' => 'Schools', 'url' => ['/user/user-director/director']],
		['label' => 'all jobs', 'url' => ['/job/job-item']],
		['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    /*if (Yii::$app->user->isGuest) {
        
        $menuItems[] = ['label' => 'Become Job Owner', 'url' => ['/site/become-job-owner']];
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        
        $menuItems[] =  ['label' => 'Dashboard', 'url' => ['/site/dashboard']];        
        $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                    )
                    . Html::endForm()
                    . '</li>';
    }*/
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
            </div>
             
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </div>
  </header>