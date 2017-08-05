<?php
use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;

$name = $model->sender->userProfile->name;
$name = ucwords($name);
/*
  switch ($model->sender->getRoleName()) {    case Yii::$app->user->identity::ROLE_DIRECTOR :
        //$image = $model->sender->userSchool->logo;
        break;
    case Yii::$app->user->identity::ROLE_USER :
        $name = $model->sender->userProfile->name;
        //$image = $model->sender->userProfile->avatar;
        break;
}
*/
?>
<div class="jobitembox msg-<?=$model->status;?>" message_id="<?=$model->message_id;?>" seq="<?=$model->seq;?>">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <h3><i class="fa fa-user" aria-hidden="true"></i> <?= Html::encode($name); ?></h3>
                    <span class="schoolname"><strong>Rolecall :</strong> <?= Html::encode($model->message->job->name); ?></span>
                    
                    <div class="loccaltime">
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Subject :</strong> 
                        <?= $model->subject; ?>
                    </div>
                    <div class="col-sm-6">
                    <div class="date">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                        <?php echo date("j M Y", strtotime($model->created_on)); ?>
                        </div>
                    </div>
                </div>
            </div>
                    <p><?= Yii::$app->formatter->asHtml($model->text);?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php if($model->attachment){ ?>
                    <?= Html::a('Download File',[
                            'download',
                            //'identifier' => $model->identifier,
                            'seq' => $model->seq,
                            'sender_id' => $model->sender_id],
                            ['class' => 'download']
                        ); ?>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>