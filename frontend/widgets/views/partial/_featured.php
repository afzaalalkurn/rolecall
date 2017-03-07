<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
use himiklab\thumbnail\EasyThumbnailImage;

$location = ($model->user->userSchool) ? $model->user->userSchool->location : '';
$name = ($model->user->userSchool) ? $model->user->userSchool->name : '';
?>

<div class="fejobs">
    <h3><?= Html::a( $model->name,['/job/job-item/view', 'id'=>$model->job_id]) ?></h3>
    <span class="schoolname"><?=$name;?></span>
    <div class="row">
        <div class="col-sm-5">
            <?= Html::a( EasyThumbnailImage::thumbnailImg($model->logo, 200, 200),['/job/job-item/view', 'id'=>$model->job_id]);?>
        </div> 
        <div class="col-sm-7">
            <?php if(!empty($location)){?>
            <div class="date">
                <i class="fa fa-map-marker" aria-hidden="true"></i> <?=$location;?> <br />
            </div>
            <?php } ?>
        </div>
    </div>
</div>