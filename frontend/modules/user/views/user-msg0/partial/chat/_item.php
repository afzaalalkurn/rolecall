<?php
use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;
use backend\modules\user\models\User;
use common\models\User as CommonUser;
use backend\modules\user\models\UserMsgAttachments;


$sender = User::findOne($model['sender_id']);
$userProfile = $sender->userProfile;
$auth = CommonUser::findOne($sender->id);

$attachments = UserMsgAttachments::findAll(['message_id' => $model['message_id'], 'seq' => $model['seq']]);
?>


<li class="left clearfix <?= ($model['sender_id'] == Yii::$app->user->id) ? "admin_chat" : ""; ?>" data-last_id="<?= $model['message_id'] ?>" data-seq="<?= $model['seq'] ?>">
                     <span class="chat-img1 <?= ($model['sender_id'] == Yii::$app->user->id) ? "pull-left" : "pull-right"; ?>">
                     <?= EasyThumbnailImage::thumbnailImg($userProfile->avatar, 32, 32, EasyThumbnailImage::THUMBNAIL_OUTBOUND, ['class'=>'img-circle']); ?>
                     </span>
    <div class="chat-body1 clearfix">
        <p><?= Html::encode($model['text']) ?>
        <?php
        foreach ($attachments as $attachment){ ?>
            <?= Html::a('<span class="fa fa-download" aria-hidden="true"></span> ', ['/download-attachment', 'attachment_id' => $attachment->attachment_id ]); ?>
        <?php } ?>
        </p>
        <?php if (!empty($model['created_at']) && $model['created_at'] > 0) { ?>
            <div class="chat_time <?= ($model['sender_id'] == Yii::$app->user->id) ?  "pull-right" : "pull-left"; ?>"><?=CommonUser::timeElapsed($model['created_at'], true);?></div>
        <?php } ?>
    </div>
</li>