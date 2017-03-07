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
            <div class="hr-top">
        <?php  if (Yii::$app->user->isGuest) { ?>

                <span><?= Html::a('Login',['/login',],[ 'class'=>'hrt-btn'])?>  </span>
                <span><?= Html::a('Teachers Register Here', ['/signup',],[ 'class'=>'hrt-btn'])?>  </span>
                <span><?= Html::a('Schools Register Here', ['/become-job-owner',],[ 'class'=>'hrt-btn'])?>  </span>
                <span><?= Html::a('Advertise With Us', ['/ads',],[ 'class'=>'hrt-btn'])?>  </span>

          <?php } else {
            /*
             * (' . Yii::$app->user->identity->username . ')
             * */
		        $logout =  Html::beginForm(['/logout'], 'post'). Html::submitButton('Logout',['class' => 'btn btn-link'] ). Html::endForm();
            ?>
                <span><?= Html::a('Dashboard', ['/dashboard'])?> </span>
                <span><?=  $logout?></span>
                <!-- notifications -->
                <span><?php echo $this->render('partial/_notification'); ?></span>
                <!-- notifications -->
          <?php } ?>
            </div>
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
	  
                $menuItems = [
                    ['label' => 'Home', 'url' => ['/']],
                    ['label' => 'About us', 'url' => ['/about-us']],
                    ['label' => 'Schools', 'url' => ['/schools']],
                    ['label' => 'all jobs', 'url' => ['/jobs']],
                    ['label' => 'Contact', 'url' => ['/contact']],
                ];

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