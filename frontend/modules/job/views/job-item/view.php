<?php

use yii\helpers\Html;

use yii\widgets\DetailView;

use yii\helpers\Url;

use yii\bootstrap\Modal;

use yii\web\JqueryAsset;

use himiklab\thumbnail\EasyThumbnailImage;

use frontend\widgets\JobWidget;

use frontend\widgets\NewsWidget;

use backend\modules\job\models\JobFieldValue;
use backend\modules\job\models\JobUserMapper;



/* @var $this yii\web\View */

/* @var $model backend\modules\job\models\JobItem */



$this->registerJsFile('@web/ajax/main.js', ['depends' => [JqueryAsset::className()]]);



$jobsBreadcumb = ['label' => 'Rolecall','url' => [ '/jobs']];



if( isset(Yii::$app->user->id) && Yii::$app->user->identity->isDirectorUserId($model->user_id)) {
    //$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/dashboard']];
    $jobsBreadcumb = ['label' => 'Rolecall', 'url' => ['/my-jobs']];
}



$this->title = $model->name;

//$this->params['breadcrumbs'][] = $jobsBreadcumb;

$this->params['breadcrumbs'][] = $this->title;



$sectionSummary = ($sections[JobFieldValue::SECTION_PROJECT_OVERVIEW]) ?? null;

$sectionBodyInfo = ($sections[JobFieldValue::SECTION_TALENT_APPEARANCE]) ?? null;

$sectionRoleInfo = ($sections[JobFieldValue::SECTION_ROLE_OVERVIEW]) ?? null;

$sectionVehicleInfo = ($sections[JobFieldValue::SECTION_VEHICLE_APPEARANCE]) ?? null;

if(isset(Yii::$app->user->id) && Yii::$app->user->identity->isUser()) {
    $user_id = Yii::$app->user->id;
    $mapper = JobUserMapper::findOne([
        'job_id' => $model->job_id,
        'user_id' => $user_id]);
}


?>

<div class="col-sm-9">

<div id="msg"></div>

<div class="jobindividual">

        <div class="row">

            <div class="col-sm-3">

            <div class="repesentational">
                <?php if(isset($model->logo) && (!empty($model->logo))){?>
                <?=EasyThumbnailImage::thumbnailImg($model->logo, 225, 225);?>
    <?php } else{
                    ?>
                    <img alt="No Photo" src="/images/nopicture.jpg">
                    <?php
                } ?>

            </div>

            </div>

            <div class="col-sm-9">
                <h1 class="title"> <?=$model->name?></h1>
                

                    <div class="address two">

                    <i class="fa fa-user" aria-hidden="true"></i> Posted By :

                    <a href="<?= Url::to(['/user/user/view', 'user_id' => $model->user_id, 'id' =>$model->job_id]);?>">

                    <?= $model->user->userProfile->getName();?></a>

                    <i class="fa fa-calendar" aria-hidden="true"></i>

                        Post Date : <?php echo date("M d, Y", strtotime($model->modified_dated)); ?>
                    <div class="passselbtn">
                    <?php
                if(isset($mapper)){
                if($mapper->status == "Approved" || $mapper->status == "Booked"){ ?>
                    <?= Html::a('', ['/job/job-item/talent-status','status' => 'Declined'],['class' => 'btn-talent-passes respond-rolecall',		'job_id'=>$mapper->job_id,'user_id'=>$mapper->user_id,'title' => 'Pass'])?>
                <?php }
                else if($mapper->status == "Declined") { ?>
                    <?= Html::a('', ['/job/job-item/talent-status','status' => 'Approved'],['class' => 'btn-talent-selects respond-rolecall',			'job_id'=>$mapper->job_id,'user_id'=>$mapper->user_id,'title' => 'Select'])?>
                <?php }
                else if($mapper->status == "Pending"){?>
                    <?= Html::a('', ['/job/job-item/talent-status','status' => 'Declined'],['class' => 'btn-talent-passes respond-rolecall',		'job_id'=>$mapper->job_id,'user_id'=>$mapper->user_id,'title' => 'Pass'])?>
                    <?= Html::a('', ['/job/job-item/talent-status','status' => 'Approved'],['class' => 'btn-talent-selects respond-rolecall',			'job_id'=>$mapper->job_id,'user_id'=>$mapper->user_id,'title' => 'Select'])?>
                <?php } }?>
                     </div>
                    </div>



            <div class="row">

            		<div class="col-sm-4">

                    <h3 class="distitle">Description:</h3>

                    </div>

                    <div class="col-sm-4">



                    </div>

                    <div class="col-sm-4">



                    </div>

                </div>

                <div class="discription">

                     <?php if(!empty($model->description)){?>

                        <?php echo substr($model->description,0,670); ?>

            <?php } ?>

                </div>

            </div>

        </div>

    <div class="usersummary bodyinformation">

        <h3>Project Overview</h3>

        <div class="row">

    <div class="col-sm-6">

        <div class="summery">

            <i class="fa cls-Rolecall" aria-hidden="true"></i>

            <span class="sal">Start Date :</span>

            <?php if(isset($model->create_dated)){echo date("M d, Y", strtotime($model->create_dated));}?>

        </div>

    </div>

    <div class="col-sm-6">

        <div class="summery">

            <i class="fa cls-Rolecall" aria-hidden="true"></i>

            <span class="sal">End Date :</span>

            <?php if(isset($model->expire_date)){echo date("M d, Y", strtotime($model->expire_date));}?>

        </div>

    </div>

    <div class="col-sm-6">

        <div class="summery">

            <i class="fa cls-Rolecall" aria-hidden="true"></i>

            <span class="sal">Location :</span>

            <?=$model->location?>

        </div>

    </div>

        <?= ($sectionSummary) ? $this->render('partial/_summary',

            ['model' => $model, 'sectionSummary' => $sectionSummary,

            ]) : null;

        ?>

        </div>

    </div>

        <?= ($sectionRoleInfo) ? $this->render('partial/_role-information',

            ['model' => $model,'sectionRoleInfo' => $sectionRoleInfo,

            ]) : null;

        ?>

        <?= ($sectionBodyInfo) ? $this->render('partial/_requirements',

            ['model' => $model,

                'sectionBodyInfo' => $sectionBodyInfo,

                'gender' => $gender,

            ]) : null;

        ?>

        <?= ($sectionVehicleInfo) ? $this->render('partial/_vehicle-information',

            ['model' => $model,'sectionVehicleInfo' => $sectionVehicleInfo,

            ]) : null;

        ?>



     <div class="row">

    <div class="col-sm-12 text-center">
    <?=$this->render('partial/_btn', ['model' => $model,'tpls' => $tpls]);?>

    </div>

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



