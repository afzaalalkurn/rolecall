<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
 
?>
<!--footer section start here-->
<footer>
  <div class="container">
    <div class="row">
      <div class="foot-top">      
          <div class="col-md-5 col-sm-5 col-xs-12">
              <?= $this->renderAjax('partial/_subscription' );?>
          </div>
            <div class="col-md-3 col-sm-2 col-xs-12 foot-menu pe-animation-maybe" data-animation="fadeInDown">
                <h3>Menu</h3>
                    <ul>
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->getRoleName() == 'School') {?>
                          <li><?= Html::a('Post a Job', ['/job/job-item/create'])?></li>
                        <?php } ?>
                        <li><?= Html::a('Membership plan', ['/plans'])?></li>
                        <!--li><?= Html::a('Help', ['/help'])?></li -->
                        <!--li><?= Html::a('Term of Use', ['/terms'])?></li-->
                        <li><?= Html::a('More as required', ['/privacy-policy'])?></li>
                        <li><?= Html::a('Contact', ['/contact'])?></li>
                    </ul>

            </div>
            <div class="col-md-4 col-sm-5 col-xs-12 foot-about pe-animation-maybe" data-animation="fadeInRight">
                <h3>About</h3>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard. dummy text ever since the 1500s, when an unknown printer took a galley of type and scram-bled it to make a type specimen book. It has                 </div>
             <div class="clear"></div>
       </div>
    </div>
    
    <!--copyright section start here-->
    <div class="foot-bottom">
               		<div class="col-md-7 col-sm-5 col-xs-12 copyright pe-animation-maybe" data-animation="fadeInLeft">
                    	© 2016, <a href="#">Music Teachers Needed</a>. All rights reserved. Design by <a href="http://www.alkurn.com/">Alkurn Technologies</a>.
                    </div>
                    <div class="col-md-5 col-sm-4 col-xs-12 foot-social pe-animation-maybe" data-animation="fadeInRight">
                    	<ul class="social">
                        	<li><a href="#" class="fb"><span>Facebook</span></a></li>
                            <li><a href="#" class="twitter"><span>twitter</span></a></li>
                            <li><a href="#" class="instagram"><span>instagram</span></a></li>
                            <li><a href="#" class="youtube"><span>youtube</span></a></li>
                            <li><a href="#" class="linkedin"><span>linkedin</span></a></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
               </div>
    <!--copyright section end here--> 
  </div>
</footer>
<script>
$(document).ready(function(){
  $('.bxslider').bxSlider({
  minSlides: 4,
  maxSlides: 100,
  slideWidth: 1000,
  slideMargin: 50,
  moveSlides: 1,
  pager: false,
  autoHover: true,
  auto: false
});
});	
</script>
<script>
$(document).ready(function(){
  $('.bxslidertwo').bxSlider({
  minSlides:1,
  maxSlides: 100,
  slideWidth: 1000,
  slideMargin: 20,
  moveSlides: 1,
  pager: false,
  autoHover: true,
  auto: false
});
});	
</script>
<!--footer section end here--> 
</section>
