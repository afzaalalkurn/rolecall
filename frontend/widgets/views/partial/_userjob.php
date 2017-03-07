<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;

?>

<div class="col-sm-3">
	<div class="jobsbox">
		<div class="jobsimg"><?php echo Html::img('@web/images/dummy-img.jpg');?></div>
		<div class="textcont">
			<h3><?= Html::a( $model->job->name,['/job/job-item/view', 'id'=>$model->job_id]) ?></h3>
			<?=StringHelper::truncateWords($model->job->description,15); ?>
		</div>
	</div>
</div>	
