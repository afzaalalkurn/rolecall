<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;  
?>  

<!--WhatwedoSec section start here-->
<section class="WhatwedoSec">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="Whatwedobox">
          <h1 class="wow flipInY">What We Do</h1>
          <div class="content wow fadeInLeft">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
              Lorem Ipsum has been the industry's standard dummy text ever since the 
              1500s, when an It was popularised in the. </p>
            <div class="ingdiv"><?php echo Html::img('@web/images/whtwedo.jpg');?></div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="slider-section">
          <ul class="bxslider">
            <li>
              <div class="helpbox">
                <div class="icondiv1"></div>
                <h3>Television</h3>
              </div>
              <div class="helpbox">
                <div class="icondiv2"></div>
                <h3>Short Film</h3>
              </div>
            </li>
            <li>
              <div class="helpbox">
                <div class="icondiv3"></div>
                <h3>Modeling</h3>
              </div>
              <div class="helpbox">
                <div class="icondiv4"><?php echo Html::img('@web/images/home.png');?></div>
                <h3>Theater</h3>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!--WhatwedoSec section end here--> 

<!--HowitworkSec section start here-->
<section class="HowitworkSec">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="wow flipInY">How it work</h1>
        <div class="row">
          <div class="col-sm-3">
            <div class="hiwbox wow fadeInUp">
              <div class="arrow"></div>
              <?php echo Html::img('@web/images/registercasting.png');?>
              <h4>Register Casting Director</h4>
              <p>Lorem Ipsum is simply dummy 
                text of the printing industry.</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="hiwbox wow fadeInDown">
              <div class="arrow"></div>
              <?php echo Html::img('@web/images/postjob.png');?>
              <h4>Post Job</h4>
              <p>Lorem Ipsum is simply dummy 
                text of the printing industry.</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="hiwbox wow fadeInUp">
              <div class="arrow"></div>
              <?php echo Html::img('@web/images/choosetalent.png');?>
              <h4>Choose Talent</h4>
              <p>Lorem Ipsum is simply dummy 
                text of the printing industry.</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="hiwbox wow fadeInDown"> <?php echo Html::img('@web/images/appoint.png');?>
              <h4>Appoint</h4>
              <p>Lorem Ipsum is simply dummy 
                text of the printing industry.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--HowitworkSec section end here--> 

<!--JoinSec section start here-->
<section class="JoinSec">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="JoinSecbox wow fadeInLeft">
          <h2>Join Thousands plus of Talent & Casting Director That Rely on Roll Call</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
            industry's standard dummy text ever since the 1500s, when an It was popularised in the.</p>
            <?php $redirectUrlTalent = Yii::$app->user->isGuest ? 'signup' : 'dashboard';?>
          <a href="<?=$redirectUrlTalent;?>" class="btn btn-primary">Get Started</a> </div>
      </div>
    </div>
  </div>
</section>
<!--JoinSec section end here--> 

<!--RiskSec section start here-->
<section class="RiskSec">
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="RiskSecbox wow fadeInLeft"> <?php echo Html::img('@web/images/riskfree.png');?>
          <h4>Risk Free</h4>
          <p>Lorem Ipsum is simply dummy text 
            of the printing and typesetting industry. 
            Lorem Ipsum has been the</p>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="RiskSecbox two wow fadeInUp"> <?php echo Html::img('@web/images/professinal.png');?>
          <h4>Only Professionals</h4>
          <p>Lorem Ipsum is simply dummy text 
            of the printing and typesetting industry. 
            Lorem Ipsum has been the</p>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="RiskSecbox wow fadeInRight"> <?php echo Html::img('@web/images/payment.png');?>
          <h4>Payment Protection</h4>
          <p>Lorem Ipsum is simply dummy text 
            of the printing and typesetting industry. 
            Lorem Ipsum has been the</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!--RiskSec section end here--> 

<!--BecomeSec section start here-->
<section class="BecomeSec">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="BecomeSecbox wow fadeInRight">
          <h2>Become a Casting Director</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and type setting 
            industry. Lorem Ipsum has been the industry's</p>
          <p>Lorem Ipsum is simply dummy text of the printing and type</p>
            <?php $redirectUrlDirector = Yii::$app->user->isGuest ? 'become-job-owner' : 'dashboard';?>
          <a href="<?=$redirectUrlDirector;?>" class="btn btn-primary">REGISTER NOW</a> </div>
      </div>
    </div>
  </div>
</section>
<!--BecomeSec section end here--> 

<!--RecentmemberskSec section start here-->
<section class="RecentmemberskSec">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="wow flipInY">Recent Members</h1>
        <ul class="nav nav-tabs text-center">
          <li class="active"><a data-toggle="tab" href="#talent">Talent</a></li>
          <li><a data-toggle="tab" href="#castingdirector">Casting Director</a></li>
        </ul>
        <div class="tab-content">
          <div id="talent" class="tab-pane fade in active">
            <div class="slider-section one">
              <ul class="bxslidertalent">
                <li>
                  <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="talentimg"><?php echo Html::img('@web/images/talent-img.jpg');?></div>
                        </div>
                        <div class="col-sm-6">
                          <div class="talentdis">
                            <h3>Emma Roze</h3>
                            <div class="addressdiv">Les vegas</div>
                            <p>Lorem Ipsum is simply dummy text of the 
                              printing and typesetting industry. Lorem 
                              Ipsum has been the Lorem Ipsum is simply 
                              dummy text of the printing and typesetting 
                              industry. Lorem Ipsum has been the</p>
                            <div class="socielmedia"> <a title="" data-placement="bottom" data-toggle="tooltip" class="facebook" href="#" data-original-title="Facebook"><i class="fa fa-facebook"></i> </a> <a title="" data-placement="bottom" data-toggle="tooltip" class="twitter" href="#" data-original-title="Twitter"><i class="fa fa-twitter"></i></a> <a title="" data-placement="bottom" data-toggle="tooltip" class="instagram" href="#" data-original-title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a> <a title="" data-placement="bottom" data-toggle="tooltip" class="youtube" href="#" data-original-title="Youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                              <div class="clearfix"></div>
                            </div>
                            <a href="#" class="btn btn-primary btn-block">Learn More</a> </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-1"></div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="talentimg"><?php echo Html::img('@web/images/talent-img.jpg');?></div>
                        </div>
                        <div class="col-sm-6">
                          <div class="talentdis">
                            <h3>Emma Roze t</h3>
                            <div class="addressdiv">Les vegas</div>
                            <p>Lorem Ipsum is simply dummy text of the 
                              printing and typesetting industry. Lorem 
                              Ipsum has been the Lorem Ipsum is simply 
                              dummy text of the printing and typesetting 
                              industry. Lorem Ipsum has been the</p>
                            <div class="socielmedia"> <a title="" data-placement="bottom" data-toggle="tooltip" class="facebook" href="#" data-original-title="Facebook"><i class="fa fa-facebook"></i> </a> <a title="" data-placement="bottom" data-toggle="tooltip" class="twitter" href="#" data-original-title="Twitter"><i class="fa fa-twitter"></i></a> <a title="" data-placement="bottom" data-toggle="tooltip" class="instagram" href="#" data-original-title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a> <a title="" data-placement="bottom" data-toggle="tooltip" class="youtube" href="#" data-original-title="Youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                              <div class="clearfix"></div>
                            </div>
                            <a href="#" class="btn btn-primary btn-block">Learn More</a> </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-1"></div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div id="castingdirector" class="tab-pane fade">
            <div class="slider-section one">
              <h1>Casting Director</h1>
              <!--<ul class="bxsliderdirector">
                        <li>
                          <div class="row">
      							<div class="col-sm-1"></div>
                                <div class="col-sm-10">
                                    <div class="row">
                                    <div class="col-sm-6"><div class="talentimg"><img src="images/talent-img.jpg" alt="" /></div></div>
                                    <div class="col-sm-6">
                                    <div class="talentdis">
                                    <h3>Emma Roze</h3>
                                    <div class="addressdiv">Les vegas</div>
                                    <p>Lorem Ipsum is simply dummy text of the 
                                    printing and typesetting industry. Lorem 
                                    Ipsum has been the Lorem Ipsum is simply 
                                    dummy text of the printing and typesetting 
                                    industry. Lorem Ipsum has been the</p>
                                    <div class="socielmedia"> <a title="" data-placement="bottom" data-toggle="tooltip" class="facebook" href="#" data-original-title="Facebook"><i class="fa fa-facebook"></i> </a> <a title="" data-placement="bottom" data-toggle="tooltip" class="twitter" href="#" data-original-title="Twitter"><i class="fa fa-twitter"></i></a> <a title="" data-placement="bottom" data-toggle="tooltip" class="instagram" href="#" data-original-title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a> <a title="" data-placement="bottom" data-toggle="tooltip" class="youtube" href="#" data-original-title="Youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a> <div class="clearfix"></div></div>
                                    <a href="#" class="btn btn-primary btn-block">Learn More</a>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                          </div>
                        </li>
                        <li>
                          <div class="row">
      							<div class="col-sm-1"></div>
                                <div class="col-sm-10">
                                    <div class="row">
                                    <div class="col-sm-6"><div class="talentimg"><img src="images/talent-img.jpg" alt="" /></div></div>
                                    <div class="col-sm-6">
                                    <div class="talentdis">
                                    <h3>Emma Roze t</h3>
                                    <div class="addressdiv">Les vegas</div>
                                    <p>Lorem Ipsum is simply dummy text of the 
                                    printing and typesetting industry. Lorem 
                                    Ipsum has been the Lorem Ipsum is simply 
                                    dummy text of the printing and typesetting 
                                    industry. Lorem Ipsum has been the</p>
                                    <div class="socielmedia"> <a title="" data-placement="bottom" data-toggle="tooltip" class="facebook" href="#" data-original-title="Facebook"><i class="fa fa-facebook"></i> </a> <a title="" data-placement="bottom" data-toggle="tooltip" class="twitter" href="#" data-original-title="Twitter"><i class="fa fa-twitter"></i></a> <a title="" data-placement="bottom" data-toggle="tooltip" class="instagram" href="#" data-original-title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a> <a title="" data-placement="bottom" data-toggle="tooltip" class="youtube" href="#" data-original-title="Youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a> <div class="clearfix"></div></div>
                                    <a href="#" class="btn btn-primary btn-block">Learn More</a>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                          </div>
                        </li>
                      </ul>--> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--RecentmemberskSec section end here--> 

<!--SubscribeSec section start here-->
<section class="SubscribeSec">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="subscribebox wow fadeInUp">
                    <h2>Newsletter signup</h2>
                    <div class="textdiv">By subscribing to our mailing list you will always be update with the latest news from us</div>
                    <div class="formdiv">
                        <?//=$this->render('subscribe',['model' => $model,]);?>
                        <?php /*$form = ActiveForm::begin(['id' => 'newsletter-subscribe-form']);?>
                        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder'=>"Enter your Email Address"])->label(false);*/?>
                        <form action="/admin/user/user-subscriber/create">
                            <input type="email" placeholder="Enter your Email Address" name="searchtxt">
                            <button class="search-btn" type="button">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--SubscribeSec section end here-->
