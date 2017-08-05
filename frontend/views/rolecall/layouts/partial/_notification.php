<?php

/**

 * Created by PhpStorm.

 * User: ganesh

 * Date: 11/7/16

 * Time: 4:08 PM

 */

use yii\helpers\Html;

use yii\widgets\ListView;

use backend\modules\user\models\search\UserNotification as UserNotificationSearch;

?>

    <div class="tomenuSec notifica">

        <?php



        $searchModel = new UserNotificationSearch();

        //$dataProvider = $searchModel->showAllNotifications(Yii::$app->request->queryParams);

        $dataProvider = $searchModel->searchUnReadNotification(Yii::$app->request->queryParams);

        $count = $dataProvider->query->count();

        $notifyCls = 'unread';

        if($dataProvider->query->count() == 0){

            $dataProvider = $searchModel->showAllNotifications(Yii::$app->request->queryParams);

            $notifyCls = 'read';

        }

        $dataProvider->query->limit = 10;

        ?>



        <ul class="nav navbar-nav navbar-left">

            <li class="dropdown notifications-menu">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <i class="fa fa-bell-o"></i>

                    <?php if($count>0){ ?>

                        <span class="label label-warning">

                        <?=$count;?>

                    </span>

                    <?php } ?>

                </a>



                <ul class="dropdown-menu" id="dropdown-notification">

                    <!--<li class="header">You have <?//=$dataProvider->query->count();?> notifications</li>-->

                    <li>

                        <!-- inner menu: contains the actual data -->

                        <?php $dataProvider->setPagination(false); ?>

                        <ul class="menu <?=$notifyCls?>">

                            <?= ListView::widget([

                                'dataProvider' => $dataProvider,

                                'itemView' => '_item',

                                'itemOptions' => ['class' => 'item', 'tag' => false,],

                                'options' =>['tag' => false,],

                                'summary' => '',

                            ]);?>

                        </ul>

                    </li>

                    <li class="footer"><?= Html::a('See All Notifications', ['/user/user-notification']) ?>

                    </li>

                </ul>

            </li>

        </ul>

    </div>

<?php



$js = <<<JS

    $('.dropdown-toggle').dropdown();



    $(".menu li").click(function(){

        location = '/user/user-notification';

    });

    

    $(".closebtn").click(function(){ 

        var message_id = $(this).attr('message_id');

        var o = $(this); 

        $.post('/user/user-notification-recipients/read', {message_id:message_id},

        function(data){           

            if(data.success = true){ $(o).remove(); } 

        }); 

    });



JS;

$this->registerJs($js);



