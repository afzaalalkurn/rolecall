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
                        if (Yii::$app->user->isGuest) {
                            $homeUrl = Yii::$app->homeUrl;
                        } else {
                            $homeUrl = (Yii::$app->user->identity->isDirector())  ? Url::to(['/site/dashboard']):Url::to(['/job/job-user-mapper/index','status' => 'Pending']);
                        }
                    ?>
                    <a href="<?= $homeUrl; ?>">
                        <?php echo Html::img('@web/images/logo.png'); ?>
                    </a>

                </div>

            </div>

            <div class="col-sm-8">

                <div class="headerbottom wow bounceInRight">

                    <?php if (Yii::$app->user->isGuest) { ?>
                        <div class="userlink">
                            <?= Html::a('Login/Sign Up', ['/login',], ['class' => 'btn-tasker']); ?>
                            <?= Html::a('Become a Talent', ['/talent',], ['class' => 'btn-tasker']); ?>
                        </div>
                    <?php } else {

                        $logout = '<div class="logout">' . Html::beginForm(['/logout'], 'post') . Html::submitButton('Logout', ['class' => 'btn btn-link']) . Html::endForm() . '</div>';

                        $first_name = Yii::$app->user->identity->userProfile->first_name;
                        $avatar = Yii::$app->user->identity->userProfile->avatar;
                        $avatar = !empty($avatar) ? '@web/uploads/' . $avatar : '@web/images/profile-img.jpg';                        ?>
                        <div class="dropdown profilesetting">
                            <span class="welcome"> <?= Html::img($avatar); ?> </span>
                            <a href="#" class="dropdown-link" data-toggle="dropdown">
                                <?= $first_name ?>
                                <i class="fa fa-angle-down"></i>
                            </a>

                            <ul class="dropdown-menu">
                                <li><?= Html::a('Dashboard', $homeUrl);?></li>
                                <!-- //general -->
                                <?= RightTopWidget::widget([]); ?>
                                <!-- //general -->

                                <!-- //setting -->
                                <li role="separator" class="divider"></li>
                                <?= RightTopWidget::widget(['type' => 'setting']); ?>
                                <!-- //setting -->

                                <li role="separator" class="divider"></li>
                                <li><?= $logout ?></li>
                            </ul>
                        </div>

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
                    <span>A Casting Management System</span><br/>
                    Discover . Connect . Manage
                </div>

            </div>

        </div>

    </div>

</section>

<!--banner section end here-->