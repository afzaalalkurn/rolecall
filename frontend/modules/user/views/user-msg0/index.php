<?php

use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use backend\modules\user\models\UserMsg;
use backend\modules\user\models\search\UserMsgRecipientsSearch;


$this->registerCssFile('@web/css/chat.css');

$model = new UserMsg();
$message_id = Yii::$app->request->get('message_id');
$item_id = Yii::$app->request->get('id');
$user_id = Yii::$app->request->get('user_id');

$searchModel0 = new UserMsgRecipientsSearch();
$searchModel0->item_id = $item_id;
$searchModel0->recipient_id = Yii::$app->user->id;
$dataProvider0 = $searchModel0->searchReceipents(Yii::$app->request->queryParams);


if (empty($message_id)) {
    $message_id = $message['message_id'] ?? 0;
}

$searchModel = new UserMsgRecipientsSearch();
$searchModel->message_id = $message_id ?? 0;
$searchModel->recipient_id = Yii::$app->user->id;
$dataProvider = $searchModel->viewMsg(Yii::$app->request->queryParams);
$dataProvider->pagination = false;

?>

    <div class="main_section">
        <div class="container">
            <div class="chat_container">

                    <div class="col-sm-3 chat_sidebar">
                        <div class="row">
                            <div class="dropdown all_conversation">
                                <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="fa fa-weixin" aria-hidden="true"></i>
                                    All Conversations
                                    <span class="caret pull-right"></span>
                                </button>
                            </div>
                            <div class="member_list">
                                <ul class="list-unstyled chat-receipents" id="chat-receipents">
                                    <?php echo $this->render('partial/_recipients', ['dataProvider' => $dataProvider0]); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--chat_sidebar-->

                <div class="col-sm-9 message_section">
                    <div class="row">
                        <div class="new_message_head">
                            <div class="pull-left">
                                <button><i class="fa fa-plus-square-o" aria-hidden="true"></i> Messages</button>
                            </div>
                        </div><!--new_message_head-->

                        <div class="chat_area">
                            <ul class="list-unstyled chat-listview" id="chat-listview">
                                <?php echo $this->render('partial/_chat', ['dataProvider' => $dataProvider]); ?>
                            </ul>
                        </div><!--chat_area-->
                        <?php if ($dataProvider->count) { ?>
                                <?php echo $this->render('partial/_frm-message', ['model' => $model, 'message_id' => $message_id, 'item_id' => $item_id]); ?>
                        <?php } ?>
                    </div>
                </div> <!--message_section-->
            </div>
        </div>
    </div>
<?php
$js = <<<JS

    $('#chat-receipents').delegate('.receipent','click', function(e){
       var message_id = $(this).attr('message_id');
       if(message_id == '' || message_id == undefined) return false;
       window.location = '/messages?message_id='+message_id;
    });   

    $("#chat-listview").slimScroll({start: 'bottom'});
     
JS;

$this->registerJs($js);