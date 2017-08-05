<?php

use yii\helpers\Html;

use yii\helpers\StringHelper;

use himiklab\thumbnail\EasyThumbnailImage;

use backend\modules\job\models\JobItem;

use backend\modules\user\models\search\UserMsgSearch;

use backend\modules\user\models\search\UserMsgRecipientsSearch;

use yii\helpers\Url;



$msgModel = new UserMsgSearch();

$userId = Yii::$app->user->id;

$allUnreadMessage = UserMsgRecipientsSearch::showAllUnreadMsg($model->job_id);

?>



<div class="col-sm-4">

    <div class="jobsbox">

        <?php if($allUnreadMessage>0) { ?>

        <div class="counter">

            <a href="<?=Url::to('/user/user-notification');?>">

                <?=$allUnreadMessage;?>

            </a>

        </div>

        <?php } ?>

        <div class="jobsimg">

            <?=EasyThumbnailImage::thumbnailImg($model->logo, 360, 360);?>

        </div>

        <h3><?= $model->name;?></h3>

        <div class="textcont">

            <?php

            /*$create_dated = Yii::$app->formatter

                ->asDatetime($model->create_dated, "php:d M Y");

            */

            $create_dated = date("M j, Y", strtotime($model->create_dated));

            ?>

            <span>Project Type :</span> <?= $model->getJobFieldValue('project-type');?>

            <br/><span>Role Name :</span> <?= $model->getJobFieldValue('role-name');?>

            <br/><span>Role Type :</span> <?= $model->getJobFieldValue('role-type');?>

            <br/><span>Project Start Date :</span> <?= $create_dated;?>

            <br><span>Location  :</span> <?= $model->location;?>

            <br/><span>Date Posted :</span>

            <?php echo date("M d, Y", strtotime($model->modified_dated)); ?>

        </div>

        <?= Html::a( 'View Rolecall',['/job/job-item/talents', 'id'=>$model->job_id],['class' => 'btn btn-primary']) ?>

    </div>

</div>

