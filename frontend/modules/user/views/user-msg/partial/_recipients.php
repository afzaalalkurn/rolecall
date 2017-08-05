<?php
use yii\widgets\ListView;
use backend\modules\user\models\search\UserMsgRecipientsSearch;

$searchModel = new UserMsgRecipientsSearch();
$searchModel->recipient_id = Yii::$app->user->id;
$recipients = $searchModel->searchReceipents();

?>
<?php foreach ($recipients as $model){ ?>
    <?php echo $this->render('chat/_recipient', ['model' => $model, 'message_id' => $message_id]); ?>
<?php } ?>