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

<li class="left clearfix <?= ($model['sender_id'] == Yii::$app->user->id) ? "admin_chat" : ""; ?>" data-last_id="<?= $model['message_id'] ?>"
    data-seq="<?= $model['seq'] ?>">
<span class="chat-img1 <?= ($model['sender_id'] == Yii::$app->user->id) ? "pull-left" : "pull-right"; ?>">
                     <?= EasyThumbnailImage::thumbnailImg($userProfile->avatar, 32, 32, EasyThumbnailImage::THUMBNAIL_OUTBOUND, ['class' => 'img-circle']); ?>
                     </span>
    <div class="chat-body1 clearfix">
        <!--<span class="primary-font"><?= $userProfile->getName() ?></span> <br/>-->
        <?php if (!empty($model['text'])) { ?>
            <p><?= Html::encode($model['text']) ?> <br/></p>
            <div id="attachments-<?= $model['message_id'] ?>-<?= $model['seq'] ?>">
                <?php if ($attachments && count($attachments) > 0) { ?>

                    <?php
                    foreach ($attachments as $attachment) {
                        echo '<div class="attachment">' . Html::a(EasyThumbnailImage::thumbnailImg($attachment->attachment, 50, 50), ['/download-attachment', 'attachment_id' => $attachment->attachment_id]) . '</div>';
                    } ?>

                <?php } ?>
            </div>
        <?php } ?>
        <?php if (!empty($model['created_at']) && $model['created_at'] > 0) { ?>
            <div class="chat_time <?= ($model['sender_id'] == Yii::$app->user->id) ? "pull-right" : "pull-left"; ?>"><?= CommonUser::timeElapsed($model['created_at'], true); ?></div>
        <?php } ?>
    </div>
</li>