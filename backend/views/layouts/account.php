<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;
?>
<?php if (!Yii::$app->user->isGuest) { ?>
<?php
    $user_id = Yii::$app->user->getId();
    $avatar = 'img/avatar6.png';
    $name = Yii::$app->user->identity->username;
    $date = Yii::$app->formatter->asDatetime(Yii::$app->user->identity->created_at, "php:d M Y");
    $role = Yii::$app->user->identity->getRoleName();

    if (isset(Yii::$app->user->identity->userProfile)) {
        $avatar = EasyThumbnailImage::thumbnailImg(Yii::$app->user->identity->userProfile->avatar, 50, 50);
        $name   = Yii::$app->user->identity->userProfile->getName();
    }

?>

    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?= $avatar; ?> <span class="hidden-xs"><?php echo $name; ?></span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
                <?php echo $avatar; ?>
                <p>
                    <?= Yii::$app->user->identity->username ?> - <?= $role; ?>
                    <small>Member since <?= $date; ?></small>
                </p>
            </li>
            <li class="user-footer">
                <div class="pull-left">
                    <?= Html::a('Profile', ['site/change-password'], ['class' => 'btn btn-default btn-flat']) ?>
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