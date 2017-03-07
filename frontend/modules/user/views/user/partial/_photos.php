<?php
use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;

?>
<div class="userphoto">
    <div class="">
        <ul class="bxslidertwo">
        <?php foreach ($model->userFieldValues as $i => $userFieldValue){ ?>
            <?php if($userFieldValue->field->layout == $userFieldValue::SECTION_PHOTOS){
                if($userFieldValue->field->field != "profile-pic" && !empty($userFieldValue->value)){?>
                <li>
                    <a href="<?= ('/uploads/' . $userFieldValue->value); ?>" data-toggle="lightbox"
                       data-gallery="multiimages" data-title="">
                        <?= EasyThumbnailImage::thumbnailImg($userFieldValue->value, 132, 113); ?></a>
                </li>
            <?php }
            }?>
        <?php } ?>
        </ul>
    </div>
</div>