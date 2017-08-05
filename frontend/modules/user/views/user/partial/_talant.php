<?php
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use backend\modules\job\models\JobItem;
use backend\modules\user\models\User;
use backend\modules\user\models\UserProfile;
use backend\modules\user\models\UserFieldValue;
use himiklab\thumbnail\EasyThumbnailImage;
use backend\modules\job\models\search\JobUserMapper;
use backend\modules\user\models\search\UserMsgRecipientsSearch as UserMsgRecipients;
use yii\helpers\Url;

$userProfile = $model->user->userProfile;
$userAddress = $model->user->userAddress;
$userFieldValues = $model->user->userFieldValue;

$fields = [];
$role = strtolower(Yii::$app->user->identity->getRoleName());
foreach ($userFieldValues as $i => $userFieldValue){
    if(!empty($userFieldValue->value)){
        if($role == "user")
        {
            if(!in_array($userFieldValue->field->field, ['role-type'])){
                $fields[$userFieldValue->field->layout][$userFieldValue->field->field] = $userFieldValue;
            }
        }
        else{
            $fields[$userFieldValue->field->layout][$userFieldValue->field->field] = $userFieldValue;
        }
    }
}

$sectionPhotos = ($fields[UserFieldValue::SECTION_PHOTOS]) ?? null;

$modelJob = $model->job;
$rolecallDate = isset($modelJob) ? Yii::$app->formatter->asDatetime($modelJob->create_dated, "php:d M Y") : '';
$job_id = Yii::$app->request->get('id');

$JobUserMapper = new JobUserMapper();
$rolecall = $JobUserMapper->getRolecallCount('Booked',$model->user->id);
$rolecallBooked = ($rolecall >0) ?  $rolecall : '';
$unreadMsgCount = UserMsgRecipients::showUnreadMsg($job_id,$model->user->id);

?>
<div id="msg"></div>
<div class="col-sm-4">
<div class="jobsbox">
    <?php if($unreadMsgCount > 0){?>
<div class="counter">
<a href="<?=Url::to('/user/user-msg');?>">
    <?=$unreadMsgCount?></a>
</div>
    <?php } ?>
<div class="jobsimg">
    <?php echo Html::a(EasyThumbnailImage::thumbnailImg($sectionPhotos['profile-pic']['value'], 350, 300),
        ['/user/user/view',
            'user_id' => $userProfile->user_id,
            'id' => $modelJob->job_id,
            'status' => $model->status]);
    ?></div>
<h3>
    <?=Html::a($userProfile->getName(),
        ['/user/user/view','user_id'=>$userProfile->user_id,'id' => $modelJob->job_id,'status' => $model->status],
        ['target' =>'_blank'])
    ?>
</h3>
<div class="textcont">
        <span>Location :</span> <?= $userAddress->location; ?><br />
        <?php
            echo "<span>Last Active : " . Html::encode(Yii::$app->user->identity->lastActiveLogin($userProfile->user_id, true))."</span><br />";

        ?>
        <?php echo "<span>Rolecalls Booked :</span> " . $rolecall;?>
</div>
    <div class="buttondiv">

        <?= Html::a('Pass', ['/job/job-item/talent-status' , 'status' => 'Passed'],
            ['class' => 'btn btn-primary select-talent',
                'job_id'=>$job_id, 'user_id'=>$model->user->id])
        ?>
        <?php if($model->status == "Approved"){?>
        <?= Html::a('Book', ['/job/job-item/talent-status' , 'status'=>'Booked'],
            ['class' => 'btn btn-primary select-talent',
                'job_id'=>$job_id, 'user_id'=>$model->user->id])
        ?>
        <?php }else if($model->status != "Booked"){?>
            <?= Html::a('Select', ['/job/job-item/talent-status' , 'status'=>'Pending'],
                ['class' => 'btn btn-primary select-talent',
                    'job_id'=>$job_id, 'user_id'=>$model->user->id])
            ?>
        <?php } ?>
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
                location.reload();
                (json.success == true) ? $('#'+id).hide() : null ;
            },
            error: function (exception) {
                alert(exception);
            }
        });           
    }); 
    
JS;

$this->registerJs($js);