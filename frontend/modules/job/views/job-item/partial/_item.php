<?php
use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage; 
use yii\helpers\StringHelper;
?>

<div class="col-sm-3">
<div class="jobsbox">
<div class="jobsimg"><?php echo Html::a(EasyThumbnailImage::thumbnailImg($model->logo, 350, 300), ['view', 'id' => $model->job_id]); ?></div>
<div class="textcont">
<h3><?= Html::a(Html::encode($model->name), ['view', 'id' => $model->job_id]) ?></h3>
 <?=StringHelper::truncateWords($model->description,12); ?>
</div>
<div class="loccaltime">  
<div class="row"> 
	<div class="col-sm-12"></div>
    <div class="col-sm-12">
	    <div class="date">
	    	<i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date("j M Y", strtotime($model->create_dated)); ?>
	    </div>
    </div>
</div>
</div>
<div class="buttondiv"><?= Html::a('View Now', ['view', 'id'=>$model->job_id], ['class' => 'btn btn-primary']) ?></div>
</div>
</div>