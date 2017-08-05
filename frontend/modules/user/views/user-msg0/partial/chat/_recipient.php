<?php

use himiklab\thumbnail\EasyThumbnailImage;
use backend\modules\user\models\User;
use backend\modules\user\models\UserMsg;

$message = UserMsg::findOne($model['message_id']);
$sender = User::findOne($model['recipient_id']);
$userProfile = $sender->userProfile;
$message_id = Yii::$app->request->get('message_id');

//$model['message_id']



?>
<li class="left clearfix receipent <?=($model['message_id'] == $message_id) ? "selected":"" ?>" message_id="<?= $model['message_id'] ?>">
<span class="chat-img pull-left">
    <?= EasyThumbnailImage::thumbnailImg($userProfile->avatar, 32, 32, EasyThumbnailImage::THUMBNAIL_OUTBOUND, ['class'=>'img-circle']); ?>
</span>
    <div class="chat-body clearfix">
        <div class="header_sec">
            <strong class="primary-font"><?= $userProfile->getName() ?></strong> <br/>
            <small><?=$message->item->name;?></small>
        </div>
    </div>
</li>