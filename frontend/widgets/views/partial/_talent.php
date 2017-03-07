<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
use himiklab\thumbnail\EasyThumbnailImage;

$userProfile = $model->user->userProfile;
$modelJob = $model->job;
?>

<div class="col-sm-3">
    <div class="jobsbox">
        <div class="jobsimg"><?= Html::a( EasyThumbnailImage::thumbnailImg($userProfile->avatar, 350, 300),['/user/user/view', 'user_id' => $model->user_id]);?></div>
        <div class="textcont">
            <h3>
                <?= Html::a( $userProfile->name,['/user/user/view', 'user_id'=> $model->user_id]) ?>
            </h3>
            <h5>
                Rolecall : <?= Html::a( $modelJob->name,['/job/job-item/view', 'id'=> $modelJob->job_id]) ?>
            </h5>
            <?=StringHelper::truncateWords($modelJob->description,15); ?>
        </div>
    </div>
</div>