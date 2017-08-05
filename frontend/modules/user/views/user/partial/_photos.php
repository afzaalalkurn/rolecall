<?php

use yii\helpers\Html;

use himiklab\thumbnail\EasyThumbnailImage;



?>

    <div class="userphoto">

        <div class="">

            <ul class="bxslidertwo">
                <li class="userimage">
                    <?php if(isset($sectionPhotos['profile-pic']['value']) && !empty($sectionPhotos['profile-pic']['value'])){ ?>
                        <div class="repesentational">
                            <?=EasyThumbnailImage::thumbnailImg($sectionPhotos['profile-pic']['value'], 600, 600);?>
                        </div>
                    <?php } ?>
                </li>

                <?php foreach ($model->userFieldValues as $i => $userFieldValue){ ?>

                    <?php if($userFieldValue->field->layout == $userFieldValue::SECTION_PHOTOS){

                        if($userFieldValue->field->field != "profile-pic" && !empty($userFieldValue->value)){?>

                            <li class="userimage">

                                <!--<a href="<?= ('/uploads/' . $userFieldValue->value); ?>" data-toggle="lightbox"

                       data-gallery="multiimages" data-title="">-->

                        <?= EasyThumbnailImage::thumbnailImg($userFieldValue->value, 600, 600); ?>
                                <!--</a>-->

                            </li>

                        <?php }

                    }?>

                <?php } ?>
            </ul>

        </div>

    </div>
<?php
$js = <<<JS
        $('.userimage').on('click',function(e){
        e.preventDefault();
        var imgSrc = $(this).find('img').attr('src');
        $('.mainImage').find('img').attr('src',imgSrc);
        });
JS;

$this->registerJs($js);