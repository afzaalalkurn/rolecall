<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use backend\modules\user\models\UserProfile;
use himiklab\thumbnail\EasyThumbnailImage;
use backend\modules\user\models\UserFieldValue;
use backend\modules\job\models\search\JobItem;
use backend\modules\job\models\search\JobUserMapper;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\User */

$id = Yii::$app->user->id;
$userProfile    = $model->userProfile;
$userAddress    = $model->userAddress;
$this->title 	= $userProfile->getName();
$this->params['breadcrumbs'][] = $this->title;

$additionalImages = $model->userFieldValues;
$sectionOther = ($sections[UserFieldValue::SECTION_OTHER]) ?? null;
$user_id = Yii::$app->request->get('user_id') ? Yii::$app->request->get('user_id') : Yii::$app->user->id;
$job_id = Yii::$app->request->get('id');
$rolecallCount = JobItem::getRolecallPostedCount($user_id);
$talentCount = JobUserMapper::getBookedRolecallCount('Booked',$user_id)
?>
<div class="row">
<div class="col-sm-12">
<div class="user-view userprofile">

<div class="talentprofile">
    <div class="row">
        <div class="col-sm-3">
            <?php if($userProfile->plan_id == 2){?>
                <div class="ribbondiv"></div>
            <?php } ?>
            <div class="repesentational">
                <?=EasyThumbnailImage::thumbnailImg($userProfile->avatar, 600, 600);?>
            </div>
        </div>
        <div class="col-sm-9">
            <?= ( isset( Yii::$app->user->id ) &&  empty($job_id) && ($userProfile->plan_id == 1)) ? $this->render('_upgradebtn', [ 'id' => Yii::$app->user->id,]) : null;?>
            <h1 class="title"><?= Html::encode($userProfile->getName()) ?></h1>
            <div class="row">
                <div class="col-sm-12">
                        <div class="activedate"><span class="sal">Last Active</span> <?php echo Html::encode(Yii::$app->user->identity->lastActiveLogin($user_id));?></div>
                </div>
            </div>
            <div class="discription">
                <?= $userProfile->about_us;?>
            </div>
            <div class="jobsother">
            <div class="row">
                <div class="col-sm-6">
                    <div class="summery">
                        <i class="fa cls-Rolecall" aria-hidden="true"></i>
                        <span class="sal">Rolecall Posted</span>
                        <?=$rolecallCount;?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="summery">
                        <i class="fa cls-Rolecall" aria-hidden="true"></i>
                        <span class="sal">Talent Booked</span>
                        <?=$talentCount;?>
                    </div>
                </div>
			</div>
            <?= ($sectionOther) ? $this->render('_other',
                ['model' => $model,
                    'userProfile'=>$userProfile,
                    'userAddress'=>$userAddress,
                    'sectionOther' => $sectionOther]) : null; ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>