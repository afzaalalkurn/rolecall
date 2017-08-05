<?php

use himiklab\thumbnail\EasyThumbnailImage;
use backend\modules\user\models\User;
use backend\modules\user\models\UserMsg;
use backend\modules\user\models\search\UserMsgSearch;
use backend\modules\user\models\UserMsgAttachments;
use yii\helpers\Html;

$message = UserMsg::findOne($model['message_id']);
$sender = User::findOne($model['recipient_id']);
$userProfile = $sender->userProfile;
if(Yii::$app->request->get('message_id')){
    $message_id = Yii::$app->request->get('message_id');
}
$lastMessage = (new UserMsgSearch())->findLastMessage($model['message_id']);
$attachments = UserMsgAttachments::findAll(['message_id' => $model['message_id'], 'seq' => $lastMessage->seq]);

?>
<li class="left clearfix receipent <?=( $model['message_id'] == $message_id) ? "selected":"" ?>" message_id="<?= $model['message_id'];?>">
<span class="chat-img pull-left">
    <?= EasyThumbnailImage::thumbnailImg($userProfile->avatar, 32, 32, EasyThumbnailImage::THUMBNAIL_OUTBOUND, ['class'=>'img-circle']); ?>
</span>
    <div class="chat-body clearfix">
        <div class="header_sec">
            <span class="primary-font"><?= $userProfile->getName() ?></span> <br/>
            <small><?=$message->item->name;?></small>
            <small><?=($lastMessage->sender_id == Yii::$app->user->id) ? 'You' : $lastMessage->sender->userProfile->getName();?></small>
            <small><?=$lastMessage->text;?>
            <div id="attachments">
                <?php if ($attachments && count($attachments) > 0) { ?>

                    <?php
                    foreach ($attachments as $attachment) {
                        echo EasyThumbnailImage::thumbnailImg($attachment->attachment, 16, 16);
                    } ?>

                <?php } ?>
            </div>
            </small>
        </div>
    </div>
</li>