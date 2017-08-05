<?php
use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;
?>

<div class="attachment">
    <?=Html::a(EasyThumbnailImage::thumbnailImg($model->attachment, 50,50), ['/download-attachment', 'attachment_id' => $model->attachment_id]);?>
</div>