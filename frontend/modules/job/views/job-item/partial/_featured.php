<?php
use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;


$school_name = (isset($model->user->userSchool) && $userSchool = $model->user->userSchool) ? $userSchool->name : null;
$compnay_location = (isset($model->user->userSchool) && $userSchool = $model->user->userSchool) ? $userSchool->location : null;
?>

<div class="jobitembox">
    <div class="row">
        <div class="col-sm-3">
            <div
                class="item-image"><?php echo Html::a(EasyThumbnailImage::thumbnailImg($model->logo, 200, 200), ['view', 'id' => $model->job_id]); ?></div>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-12">
                    <h3><?= Html::a(Html::encode($model->name), ['view', 'id' => $model->job_id]) ?></h3>
                    <span class="schoolname"><?php echo $school_name ?? 'Not Given'; ?></span></div>
            </div>
            <div class="loccaltime">
                <div class="row">
                    <div class="col-sm-4"><i class="fa fa-map-marker"
                                             aria-hidden="true"></i> <?php echo $compnay_location  ?? 'Not Given'; ?>
                    </div>
                    <div class="col-sm-6"><i class="fa fa-calendar"
                                             aria-hidden="true"></i> <?php echo date("j M Y", strtotime($model->create_dated)); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div
                        class="buttondiv"><?= Html::a('View Now', ['view', 'id'=>$model->job_id], ['class' => 'btn btn-primary']) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>