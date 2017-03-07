<?php
use yii\helpers\Html;
use yii\helpers\Url;
use himiklab\thumbnail\EasyThumbnailImage;
use backend\modules\user\models\search\UserMsgRecipients;

$job        = $model->job;
$user       = $model->user;
$profile    = $user->userProfile;

$unreadMsgCount = UserMsgRecipients::showAllUnreadMsg($model->job_id);

?>
<div id="msg"></div>
<div class="col-sm-4">
<div class="jobsbox">
    <?php if($unreadMsgCount > 0 ){?>
<div class="counter">
<a href="<?=Url::to('/user/user-notification')?>">
    <?=$unreadMsgCount;?>
</a>
</div>
    <?php } ?>
<div class="jobsimg"><?php echo Html::a(EasyThumbnailImage::thumbnailImg($job->logo, 350, 300) ,['job-item/view','id' => $model->job_id]);?></div>
<h3>
<?php if(Yii::$app->user->identity->isDirector()){?>
<?=Html::a(Html::encode($profile->name),  ['/user/user/view', 'job_id' => $model->job_id,'user_id'=> $model->user_id])?>
<?php }else{ ?>
<?=Html::a(Html::encode($job->name),  ['/job/job-item/view','id' => $model->job_id])?>
</h3>
	<div class="textcont">
		<?php
        $create_dated = date("M d, Y", strtotime($job->create_dated));
        $expire_date = date("M d, Y", strtotime($job->expire_date));
		$datetime1 = new DateTime($create_dated);
		$datetime2 = new DateTime($expire_date);
		$diff = $datetime1->diff($datetime2);
		?>
		<span>Project Type :</span> <?= $job->getJobFieldValue('project-type');?>
		<br/><span>Role Type :</span> <?= $job->getJobFieldValue('role-type');?>
		<br/><span>Location :</span> <?= $job->location;?>
		<br/><span>Project Time :</span>
		<?php if($diff->y > 0){
			echo $diff->y . ' yr(s) ';}
		echo $diff->m . ' month(s)';
		?>
		<br/><span>Compensation Type :</span> <?= $job->getJobFieldValue('compensation-type');?>
	</div>
<?php } ?>
<div class="buttondiv">
<?= Html::a('Pass', ['/job/job-item/talent-status','status' => 'Declined'],
	['class' => 'btn btn-primary respond-rolecall',
		'job_id'=>$model->job_id,
		'user_id'=>$model->user_id]) ?>
<?php if($model->status != "Booked"){?>
	<?= Html::a('Select', ['/job/job-item/talent-status','status' => 'Approved'],
		['class' => 'btn btn-primary respond-rolecall',
			'job_id'=>$model->job_id,
			'user_id'=>$model->user_id])
	?>
<?php }
?>
</div>
</div>
</div>

<?php
$js = <<<JS

    $('.respond-rolecall').on('click',function(e){
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