<?php
use yii\bootstrap\Nav;
use backend\modules\auth\components\MenuHelper;
use backend\widgets\Menu;
use himiklab\thumbnail\EasyThumbnailImage;
?>
<?php if (!Yii::$app->user->isGuest) { ?>
    <aside class="main-sidebar">

        <section class="sidebar">

            <!-- Sidebar user panel -->
            <?php
            $user_id = Yii::$app->user->getId();
            $avatar = 'img/avatar5.png';
            $name = Yii::$app->user->identity->username;
            $date = Yii::$app->formatter->asDatetime(Yii::$app->user->identity->created_at, "php:d M Y");
            if (isset(Yii::$app->user->identity->userProfile)) {
                $avatar = EasyThumbnailImage::thumbnailImg(Yii::$app->user->identity->userProfile->avatar, 50, 50);
                $name = Yii::$app->user->identity->userProfile->getName();
            }
            ?>
            <div class="user-panel">
                <div class="pull-left image">
                   <?=$avatar;?>
                </div>
                <div class="pull-left info">
                    <p><?= Yii::$app->user->identity->username ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <?php
            $objRole = current(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
            if (isset($objRole)) {
                $objMenu = MenuHelper::getMenuIdByName($objRole->name);
                if (is_object($objMenu)) {


                    $items = array_merge([['label' => 'Admin Menu', 'options' => ['class' => 'header']]], MenuHelper::getAssignedMenu(Yii::$app->user->id, $objMenu->id));
            ?>
            <?= Menu::widget(['options' => ['class' => 'sidebar-menu'],'items' => $items,]); ?>
    <?php

                }
            } ?>
        </section>

    </aside>

<?php } ?>