<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;
?>
<?php if (!Yii::$app->user->isGuest) { ?>
<?php
    $user_id = Yii::$app->user->getId();

    $avatar = '128x128.png';
    $name = Yii::$app->user->identity->username;
    $date = Yii::$app->formatter->asDatetime(Yii::$app->user->identity->created_at, "php:d M Y");
    $role = Yii::$app->user->identity->getRoleName();

    if (isset(Yii::$app->user->identity->userProfile)) {

        $avatar = !empty(Yii::$app->user->identity->userProfile->avatar) ? Yii::$app->user->identity->userProfile->avatar : $avatar;

        $avatarThumb = EasyThumbnailImage::thumbnailImg($avatar, 25, 25, EasyThumbnailImage::THUMBNAIL_OUTBOUND, ['class'=>'img-circle', 'alt'=>'User Image']);
        $avatarFull = EasyThumbnailImage::thumbnailImg($avatar, 90, 90, EasyThumbnailImage::THUMBNAIL_OUTBOUND, ['class'=>'img-circle', 'alt'=>'User Image']);
        $name   = Yii::$app->user->identity->userProfile->getName();
    }

?>

    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php echo $avatarThumb; ?> <span class="hidden-xs"><?php echo $name; ?></span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
                <?php echo $avatarFull; ?>
                <p>
                    <?= Yii::$app->user->identity->username ?> - <?= $role; ?>
                    <small>Member since <?= $date; ?></small>
                </p>
            </li>
            <li class="user-footer">
                <div class="pull-left">
                    <?= Html::a('Profile', ['/site/change-password'], ['class' => 'btn btn-default btn-flat']) ?>
                </div>
                <div class="pull-right">
                    <?= Html::a(
                        'Sign out',
                        ['/site/logout'],
                        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                    ) ?>
                </div>
            </li>
        </ul>
    </li>
<?php } ?>