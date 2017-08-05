<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;

use backend\modules\auth\components\MenuHelper;

use backend\widgets\Menu;

use himiklab\thumbnail\EasyThumbnailImage;

use frontend\widgets\UserSettingsWidget;



?>



<div class="row hiderow">

    <div class="col-sm-3">

        <aside class="main-sidebar">

            <section class="sidebar">

                <!-- Sidebar user panel -->

                <?= UserSettingsWidget::widget();?>
                <?php
                $logout = '<div class="logout">'. Html::beginForm(['/logout'], 'post'). Html::submitButton('Logout',['class' => 'btn btn-link'] ). Html::endForm(). '</div>';
                ?>
                <li><?=$logout?></li>
                <!-- Sidebar user panel -->

            </section>

        </aside>

    </div>



