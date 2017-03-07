<?php
use yii\helpers\Html;
use backend\modules\job\models\JobItem;
use yii\web\JqueryAsset;
use himiklab\thumbnail\EasyThumbnailImage;
?>
<div class="vpicture">
    <div class="row">
            <?php foreach ($sectionVehiclePictures as $i => $userFieldValue){ ?>

            <div class="col-sm-3">
            <div class="vimage">
            <span class="sal"><?=$userFieldValue->field->name;?></span>
            <a href="<?= ('/uploads/' . $userFieldValue->value); ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="">
                <?= EasyThumbnailImage::thumbnailImg($userFieldValue->value, 300, 300); ?>
            </a>
            </div>
            </div>

            <?php } ?>
    </div>
</div>
<?php



