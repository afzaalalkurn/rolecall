<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<!--footer section start here-->
<section class="footer">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="aboutrollcall wow fadeInUp"> <?php echo Html::img('@web/images/fot-logo.png');?>
          <h3>Welcome to RoleCall</h3>
          <div class="content">Lorem Ipsum is simply dummy text of the printing and types etting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
            when an Lorem Ipsum is simply dummy text of the printing and types etting industry. Lorem Ipsum has been the industry's standard dummy text ever since 
            the 1500s, Lorem Ipsum is simply dummy text of.</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <div class="fotmenu wow fadeInDown">
          <h3>MENU</h3>
          <ul>
            <li><?= Html::a('Home', ['/'])?></li>
            <li><?= Html::a('Rolecall', ['/rolecalls'])?></li> 
            <li><?= Html::a('help', ['/'])?></li>
          </ul>
        </div>
      </div>
      <div class="col-sm-3 wow fadeInUp">
        <div class="fotlegal">
          <h3>Legal</h3>
          <ul>
            <li><?= Html::a('About us', ['/about-us'])?></li>
            <li><?= Html::a('Contact', ['/contact'])?></li>
            <li><?= Html::a('Privacy Policy', ['/policy'])?></li>
            <li><?= Html::a('Terms of Use', ['/terms'])?></li>
          </ul>
        </div>
      </div>
      <div class="col-sm-3 wow fadeInDown">
        <div class="followus">
          <h3>follow us</h3>
          <ul>
            <li><a title="" data-placement="right" data-toggle="tooltip" class="facebook" href="#" data-original-title="Facebook"><i class="fa fa-facebook"></i> Facebook</a></li>
            <li><a title="" data-placement="right" data-toggle="tooltip" class="twitter" href="#" data-original-title="Twitter"><i class="fa fa-twitter"></i> Twitter</a></li>
            <li><a title="" data-placement="right" data-toggle="tooltip" class="instagram" href="#" data-original-title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></li>
            <li><a title="" data-placement="right" data-toggle="tooltip" class="youtube" href="#" data-original-title="Youtube"><i class="fa fa-youtube" aria-hidden="true"></i> Youtube</a></li>
          </ul>
        </div>
      </div>
      <div class="col-sm-3 wow fadeInUp">
        <div class="download">
          <h3>Download</h3>
          <div class="textdiv">Install our official mobile app and stay in touch with us.</div>
          <a href="#"><?php echo Html::img('@web/images/apple.png');?></a> <a href="#"><?php echo Html::img('@web/images/android.png');?></a> </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 wow fadeInUp">
        <div class="copyright">&copy; 2016, RoleCall All rights reserved. Designed by <a href="http://www.alkurn.com/" target="_blank">Alkurn Technologies</a></div>
      </div>
    </div>
  </div>
</section>
<section class="disclamer">
  <div class="container">
    <div class="row">
      <div class="col-sm-12"> <strong>Disclaimer:</strong> Lorem Ipsum is simply dummy text of the printing and types etting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an  etting industry. Lorem Ipsum has been 
        the industry's standard dummy text ever since the 1500s, when an the industry's standard dummy text ever since the 1500s, when an... </div>
    </div>
  </div>
</section>
<!--footer section end here--> 

<script>$(function () {$('[data-toggle="tooltip"]').tooltip()})</script>
<script>new WOW().init();</script>

<script type="text/javascript">
/*jQuery('#model').modal({"show":false});*/
$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        always_show_close: true
                    });
                });

</script>

