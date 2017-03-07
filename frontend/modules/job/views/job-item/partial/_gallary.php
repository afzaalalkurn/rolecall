<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;
use himiklab\thumbnail\EasyThumbnailImage;
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 13/7/16
 * Time: 3:38 PM
 */

if($model->user->getUserSchoolImages()->count() > 0){


?>
<div class="workenvironment">
    <h3>Work Environment</h3>
    <div class="slider-section">
            <ul class="bxslidertwo"><?php
                foreach($model->user->userSchoolImages as $modelImage){?>
                    <li>
                        <a href="<?='/uploads/'.$modelImage->image;?>" data-toggle="lightbox" data-gallery="multiimages" data-title=""><?= EasyThumbnailImage::thumbnailImg($modelImage->image, 130, 113); ?></a>
                    </li>
                <?php } ?>
            </ul>

    </div>
</div>
<?php

$this->registerCssFile('@web/js/dark.css');
$this->registerCssFile('@web/js/lightbox.css');
$this->registerJsFile('@web/js/lightbox.min.js', ['depends' => [JqueryAsset::className()]]);

$js = <<<JS

$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        always_show_close: true
                    });
                });
                
JS;

$this->registerJs($js);
?>
<?php } ?>

