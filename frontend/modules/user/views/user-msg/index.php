<?php
use backend\modules\user\models\UserMsg;
use backend\modules\user\models\search\UserMsgRecipientsSearch;
use himiklab\thumbnail\EasyThumbnailImage;
use backend\modules\user\models\User;


$this->registerCssFile('@web/css/chat.css');

$host = Yii::$app->WebSocket->host;
$port = Yii::$app->WebSocket->port;

$model = new UserMsg();
/*
    $message_id = Yii::$app->request->get('message_id');
    $item_id = Yii::$app->request->get('id');
*/

/*
$user_id = Yii::$app->request->get('user_id');
if (empty($message_id)) {
    $message_id = $message['message_id'] ?? 0;
}
*/

$this->registerCssFile('https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700');

$searchModel = new UserMsgRecipientsSearch();
$searchModel->message_id = $message_id ?? 0;
$searchModel->recipient_id = Yii::$app->user->id;
$dataProvider = $searchModel->viewMsg(Yii::$app->request->queryParams);
$dataProvider->pagination = false;

$currentUser = Yii::$app->user->identity->user;
$currentRecipient = null;
if (!empty($message_id)) {
    $searchModelRecipient = new UserMsgRecipientsSearch();
    $searchModelRecipient->message_id = $message_id ?? 0;
    $recipientProvider = $searchModelRecipient->searchMessageReceipents()->all();

    foreach ($recipientProvider as $itemRecipient) {
        if ($itemRecipient['recipient_id'] != Yii::$app->user->id) {
            $currentRecipient = User::findOne($itemRecipient['recipient_id']);
        }
    }
}

if ($dataProvider->count > 0) {?>

    <!--<h1>Messages</h1>-->
    <!--<h3 id="chat-error"></h3>-->
    <div class="main_section" id="msg-section">
        <div class="">
            <div class="chat_container">
                <div class="col-sm-3 chat_sidebar">
                    <div class="row">
                        <div class="dropdown all_conversation">
                            <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                   <span class="chat-img pull-left">
    <?= EasyThumbnailImage::thumbnailImg($currentUser->userProfile->avatar, 32, 32, EasyThumbnailImage::THUMBNAIL_OUTBOUND, ['class' => 'img-circle']); ?>
</span>
                                <div class="chat-body clearfix">
                                    <div class="header_sec">
                                        <span class="primary-font"><?= $currentUser->userProfile->getName() ?></span> <br/>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="member_list" id="item-recipient">
                            <ul class="list-unstyled chat-receipents" id="chat-receipents">
                                <?php echo $this->render('partial/_recipients',['message_id' => $message_id, 'item_id' => $item_id]); ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--chat_sidebar-->
                <div class="col-sm-9 message_section">
                    <div class="row">
                        <div class="new_message_head">
                            <div class="pull-left">
                                <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php if ($currentRecipient){ ?>
                                        <span class="chat-img pull-left">
    <?= EasyThumbnailImage::thumbnailImg($currentRecipient->userProfile->avatar, 32, 32, EasyThumbnailImage::THUMBNAIL_OUTBOUND, ['class' => 'img-circle']); ?>
</span>
                                        <div class="chat-body clearfix">
                                            <div class="header_sec">
                                                <span class="primary-font"><?= $currentRecipient->userProfile->getName();?></span> <br/>
                                                <small><?php //echo $message->item->title; ?></small>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <i class="fa fa-chat-o" aria-hidden="true"></i> Messages<?php } ?>
                                </button>


                            </div>
                        </div><!--new_message_head-->

                        <div class="chat_area">
                            <ul class="list-unstyled chat-listview" id="chat-listview">
                                <?php echo $this->render('partial/_chat', ['dataProvider' => $dataProvider]); ?>
                            </ul>
                        </div><!--chat_area-->
                        <?php echo $this->render('partial/_frm-message', ['model' => $model, 'message_id' => $message_id, 'item_id' => $item_id,]); ?>
                    </div>
                </div> <!--message_section-->
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

<?php } else { ?>
    <h1 class="notfound"><strong>Oops,</strong> you do not have any active messages at the moment.</h1>
    <div class="clearfix"></div>
<?php } ?>


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