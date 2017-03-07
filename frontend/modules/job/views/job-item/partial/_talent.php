<?php
use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;

use backend\modules\user\models\UserAddress;
use backend\modules\user\models\UserProfile;
use backend\modules\job\models\search\JobUserMapper;
use backend\modules\user\models\search\UserMsgRecipients;
use backend\modules\user\models\UserField;
use backend\modules\user\models\UserFieldValue;
use yii\helpers\Url;

$userProfile = $model->userProfile;
$userAddress = $model->userAddress;
$userFieldValues = $model->userFieldValues;

$fields = [];
$role = strtolower(Yii::$app->user->identity->getRoleName());
foreach ($userFieldValues as $i => $userFieldValue) {
    if (!empty($userFieldValue->value)) {
        if ($role == "user") {
            if (!in_array($userFieldValue->field->field, ['role-type'])) {
                $fields[$userFieldValue->field->layout][$userFieldValue->field->field] = $userFieldValue;
            }
        } else {
            $fields[$userFieldValue->field->layout][$userFieldValue->field->field] = $userFieldValue;
        }
    }
}

$sectionPhotos = ($fields[UserFieldValue::SECTION_PHOTOS]) ?? null;
$joiningDate = isset($userProfile) ? Yii::$app->formatter->asDatetime($userProfile->joining_date, "php:d M Y") : '';
$job_id = Yii::$app->request->get('id');

$JobUserMapper = new JobUserMapper();
$rolecall = $JobUserMapper->getRolecallCount('Booked', $model->id);
$rolecallBooked = ($rolecall > 0) ? $rolecall : '';
$unreadMsgCount = UserMsgRecipients::showUnreadMsg($job_id, $model->id);

?>
    <div id="msg"></div>
    <div class="col-sm-4">
        <div class="jobsbox">
            <?php if ($unreadMsgCount > 0) { ?>
                <div class="counter"><a href="<?= Url::to('/user/user-notification'); ?>"><?= $unreadMsgCount; ?></a>
                </div>
            <?php } ?>
            <div class="jobsimg">
                <?php if (!empty($sectionPhotos['profile-pic']['value'])) {
                    ?>
                    <?= Html::a(EasyThumbnailImage::thumbnailImg($sectionPhotos['profile-pic']['value'], 350, 300),
                        ['/user/user/view',
                            'user_id' => $model->id,
                            'id' => $job_id]);
                    ?>
                <?php } else { ?>
                    <?php echo Html::img('@web/images/dummy-img.jpg', ['width' => '350', 'height' => '300']); ?>
                <?php } ?>
            </div>
            <h3><?= Html::a($userProfile->getName(), ['/user/user/view', 'user_id' => $model->id, 'id' => $job_id], ['target' => '_blank']) ?></h3>
            <div class="textcont">
                <span>Location :</span> <?= $userAddress->location; ?><br/>
                <?php echo "<span>Last Active :</span> " . Html::encode(Yii::$app->user->identity->lastActiveLogin($model->id, true)); ?>
                <br/>
                <?php echo "<span>Rolecalls Booked :</span> " . $rolecall; ?>
            </div>

            <div class="buttondiv">
                <?= Html::a('Pass', ['talent-status', 'status' => 'Passed'],
                    ['class' => 'btn btn-primary select-talent',
                        'job_id' => $job_id, 'user_id' => $model->id])
                ?>
                <?= Html::a('Select', ['talent-status', 'status' => 'Pending'],
                    ['class' => 'btn btn-primary select-talent',
                        'job_id' => $job_id, 'user_id' => $model->id])
                ?>
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
            },
            error: function (exception) {
                alert(exception);
            }
        });           
    }); 
    
JS;

$this->registerJs($js);