<?php

use yii\bootstrap\Nav;

use yii\helpers\Html;

use yii\widgets\DetailView;

use yii\helpers\Url;

use backend\modules\user\models\UserProfile;

use himiklab\thumbnail\EasyThumbnailImage;

use backend\modules\user\models\UserFieldValue;
use backend\modules\job\models\search\JobUserMapper;
use yii\web\JqueryAsset;
use backend\modules\user\models\search\UserMsgRecipientsSearch;


/* @var $this yii\web\View */

/* @var $model backend\modules\user\models\User */

$this->registerJsFile('@web/ajax/main.js', ['depends' => [JqueryAsset::className()]]);

$userProfile = $model->userProfile;
$userAddress = $model->userAddress;
$this->title = $userProfile->getName();
$this->params['breadcrumbs'][] = $this->title;

$additionalImages = $model->userFieldValues;
$sectionPhotos = ($sections[UserFieldValue::SECTION_PHOTOS]) ?? null;
$sectionSummary = ($sections[UserFieldValue::SECTION_TALENT_OVERVIEW]) ?? null;
$sectionOther = ($sections[UserFieldValue::SECTION_OTHER]) ?? null;
$sectionBodyInformation = ($sections[UserFieldValue::SECTION_TALENT_APPEARANCE]) ?? null;
$sectionVehiclePictures = ($sections[UserFieldValue::SECTION_VEHICLE_PICTURES]) ?? null;
$sectionVehicleInformation = ($sections[UserFieldValue::SECTION_VEHICLE_APPEARANCE]) ?? null;

$user_id = Yii::$app->request->get('user_id') ?? Yii::$app->user->id;
$talentCount = JobUserMapper::getBookedTalentCount('Booked', $user_id);
$job_id = Yii::$app->request->get('id');
$status = Yii::$app->request->get('status');
$showMessage = JobUserMapper::showMessage($job_id, $user_id);

$message_id = null;
if (Yii::$app->request->get('user_id')) {

    $userMsgRecipientsSearch = new UserMsgRecipientsSearch();
    $message_id = $userMsgRecipientsSearch->findMessageId($job_id, [Yii::$app->request->get('user_id'), Yii::$app->user->id]);
}
?>


    <div class="col-sm-9 drictorcol">
        <div id="msg"></div>
        <div class="user-view userprofile">
            <div class="talentprofile">
                <div class="row">
                    <div class="col-sm-6">
                        <?php if ($userProfile->plan_id == 2) { ?>
                            <div class="ribbondiv"></div> <?php } ?>
                        <div class="repesentational mainImage">
                            <?php if (isset($sectionPhotos['profile-pic']['value']) && !empty($sectionPhotos['profile-pic']['value'])) { ?>
                                <?= EasyThumbnailImage::thumbnailImg($sectionPhotos['profile-pic']['value'], 600, 600); ?>
                            <?php } else {
                                ?>
                                <img alt="No Profile Image" src="/images/nopicture.jpg">
                                <?php
                            } ?>
                        </div>
                        <div class="additional-images">
                            <?= ($sectionPhotos) ? $this->render('_photos', ['model' => $model, 'sectionPhotos' => $sectionPhotos]) : null; ?>
                        </div>
                    </div>

                    <div class="col-sm-6">

                        <?/*= ( isset( Yii::$app->user->id ) &&  empty($job_id) && ($userProfile->plan_id == 1)) ? $this->render('_upgradebtn', [ 'id' => Yii::$app->user->id,]) : null;*/ ?>

                        <h1 class="title">
                            <?= Html::encode($userProfile->getName()) ?>
                        </h1>

                        <span class="messdiv">

                    <?php if (isset(Yii::$app->user->id) && Yii::$app->user->identity->isDirector()) { ?>

                        <?php if (!empty($job_id)) { ?>
                            <?php
                            /*
                                $user_id = Yii::$app->request->get('user_id');
                                $job_id

                            */
                            $jobStatus = JobUserMapper::userJobStatus(Yii::$app->request->get('user_id'), $job_id);
                            if ($jobStatus && in_array($jobStatus->status, ['Approved', 'Booked', 'Selected'])) {?>
                                <?= (empty($message_id) && $jobStatus) ? $this->render('_mailbtn', ['model' => $model, 'user_id' => Yii::$app->request->get('user_id'), 'item_id' => $job_id]) : Html::a('', ['/user/user-msg', 'message_id' => $message_id], ['class' => 'fa fa-envelope-o',]); ?>

                            <?php } ?>
                        <?php } ?>

                        <?= Html::a('', ['/job/job-item/talent-status', 'status' => 'Passed'],
                            ['class' => 'owner-button btn-talent-passes select-talent',
                                'job_id' => $job_id, 'user_id' => $user_id,
                                'title' => 'Pass',]) ?>
                        <?php if ($status == "Approved") { ?>
                            <?= Html::a('', ['/job/job-item/talent-status', 'status' => 'Booked'],
                                ['class' => 'owner-button btn-talent-booked select-talent',
                                    'job_id' => $job_id, 'user_id' => $user_id,
                                    'title' => 'Book',])
                            ?>
                        <?php } else if ($status != "Booked") { ?>
                            <?= Html::a('', ['/job/job-item/talent-status', 'status' => 'Pending'],
                                ['class' => 'owner-button btn-talent-selects select-talent',
                                    'job_id' => $job_id, 'user_id' => $user_id,
                                    'title' => 'Select',])
                            ?>
                        <?php } ?>
                    <?php } ?>
                </span>

                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="activedate">
                                    <span class='sal'>
                                        <?= Html::encode(Yii::$app->user->identity->lastActiveLogin($user_id)); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="discription">
                            <?php echo $userProfile->about_us; ?>
                        </div>

                        <div class="jobsother">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="summery">
                                        <i class="fa cls-Location" aria-hidden="true"></i>
                                        <span class="sal">Location</span>
                                        <?= $userAddress->location; ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="summery">
                                        <i class="fa cls-Rolecall" aria-hidden="true"></i>
                                        <span class="sal">Rolecall Booked</span>
                                        <?= $talentCount; ?>
                                    </div>
                                </div>
                            </div>
                            <?= ($sectionOther) ? $this->render('_other', ['model' => $model, 'userProfile' => $userProfile, 'sectionOther' => $sectionOther]) : null; ?>
                        </div>

                    </div>

                </div>

                <?= ($sectionSummary) ? $this->render('_summary', ['model' => $model, 'sectionSummary' => $sectionSummary]) : null; ?>

                <?= ($sectionBodyInformation) ? $this->render('_body-information', ['model' => $model, 'sectionBodyInformation' => $sectionBodyInformation, 'userProfile' => $userProfile]) : null; ?>

                <?= ($sectionVehicleInformation) ? $this->render('_vehicle-information', ['model' => $model, 'sectionVehicleInformation' => $sectionVehicleInformation]) : null; ?>

            </div>
            <?php if (isset($sectionVehicleInformation['do-you-own-vehicle']) && $sectionVehicleInformation['do-you-own-vehicle']['value'] == "Yes") { ?>
                <?= ($sectionVehiclePictures) ? $this->render('_vehicle-pictures', ['model' => $model, 'sectionVehiclePictures' => $sectionVehiclePictures]) : null; ?>
            <?php } ?>

        </div>
        <div class="row">

            <div class="col-sm-12 text-center">
                <?= $this->render('_btn', ['model' => $model, 'tpls' => $tpls]); ?>

            </div>

        </div>
    </div>
<?php
$js = <<<JS

    $('.select-talent').on('click',function(e){
        
        e.preventDefault();
        var job_id = $(this).attr('job_id');
        var user_id = $(this).attr('user_id');
        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            dataType:'JSON',
            data:   {
                        job_id: job_id,
                        user_id: user_id                        
                    },
            success: function (json) {             	
                $('#msg').html("<div class='alert alert-success'>"+ json.msg +"</div>").fadeIn('slow');
                $('#msg').delay(4000).fadeOut('slow');               
                (json.success == true) ? $('#'+id).hide() : null ;
                window.location.reload();
            },
            error: function (exception) {
                alert(exception);
            }
        });           
    }); 
    
JS;

$this->registerJs($js);



