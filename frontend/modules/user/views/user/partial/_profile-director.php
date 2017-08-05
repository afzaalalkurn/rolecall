<?php



use yii\helpers\Html;

use yii\widgets\DetailView;

use yii\helpers\Url;

use backend\modules\user\models\UserProfile;

use himiklab\thumbnail\EasyThumbnailImage;

use backend\modules\user\models\UserFieldValue;

use backend\modules\job\models\search\JobItem;

use backend\modules\job\models\search\JobUserMapper;

use yii\web\JqueryAsset;



/* @var $this yii\web\View */

/* @var $model backend\modules\user\models\User */


$this->registerJsFile('@web/ajax/main.js', ['depends' => [JqueryAsset::className()]]);
$id = Yii::$app->user->id;
$userProfile    = $model->userProfile;
$userAddress    = $model->userAddress;
$this->title 	= $userProfile->getName();
$additionalImages = $model->userFieldValues;
$sectionOther = ($sections[UserFieldValue::SECTION_OTHER]) ?? null;
$user_id = Yii::$app->request->get('user_id') ? Yii::$app->request->get('user_id') : Yii::$app->user->id;
$job_id = Yii::$app->request->get('id');
$rolecallCount = JobItem::getRolecallPostedCount($user_id);
$talentCount = JobUserMapper::getBookedRolecallCount('Booked',$user_id);
$rolecallDetails = JobItem::getRolecall($job_id);
if($job_id){
$this->params['breadcrumbs'][] = ['label' => $rolecallDetails[0]['name'], 'url' => ['/job/job-item/view', 'id' => $job_id]];
$this->params['breadcrumbs'][] = $this->title;
}
?>

<div class="col-sm-9 drictorcol">
<div class="user-view userprofile">
<div class="talentprofile">
    <div class="row">
        <div class="col-sm-3">
            <?php if($userProfile->plan_id == 2){?>
                <div class="ribbondiv"></div>
            <?php } ?>
            <div class="repesentational">
                <?php if(isset($userProfile->avatar) && !empty($userProfile->avatar)){ ?>
                <?=EasyThumbnailImage::thumbnailImg($userProfile->avatar, 600, 600);?><?php }else{ ?>
                    <img alt="No Profile Image" src="/images/nopicture.jpg">
                <?php }?>
            </div>
        </div>
        <div class="col-sm-9">
            <?/*= ( isset( Yii::$app->user->id ) &&  empty($job_id) && ($userProfile->plan_id == 1)) ? $this->render('_upgradebtn', [ 'id' => Yii::$app->user->id,]) : null;*/?>
            <h1 class="title"><?= Html::encode($userProfile->getName()) ?></h1>
            <div class="row">
                <div class="col-sm-12">
                        <div class="activedate">
                            <?php
                            $lastLogin = Yii::$app->user->identity->lastActiveLogin($user_id);
                            if($lastLogin == "Online"){
                                echo "<span class='sal'>Online</span>";
                            }else {
                                ?>
                                <span class="sal">Last Active</span>
                                <?php echo Html::encode(Yii::$app->user->identity->lastActiveLogin($user_id));
                            }
                            ?>
                        </div>
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

            <div class="row">
                <div class="col-sm-12 text-center">
                    <?=$this->render('_btn', ['model' => $model,'tpls' => $tpls]);?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>