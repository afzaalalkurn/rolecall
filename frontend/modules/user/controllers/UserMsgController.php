<?php

namespace frontend\modules\user\controllers;


use backend\modules\user\models\search\UserMsgAttachmentsSearch;
use backend\modules\user\models\UserMsgAttachments;
use frontend\event\AutoEvent;
use Yii;
use backend\modules\user\models\UserMsg;
use backend\modules\user\models\search\UserMsgSearch;
use yii\web\Controller;

use yii\web\NotFoundHttpException;
use common\models\User as CommonUser;
use backend\modules\user\models\User;
use backend\modules\user\models\search\UserSearch;

use backend\modules\user\models\UserMsgRecipients as UserMsgRecipients;
use backend\modules\user\models\search\UserMsgRecipientsSearch;

use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * UserMsgController implements the CRUD actions for UserMsg model.
 */
class UserMsgController extends Controller
{

    public function actionIndex()
    {
        $message_id = Yii::$app->request->get('message_id');
        $item_id = Yii::$app->request->get('id');
        $user_id = Yii::$app->request->get('user_id');

        if (empty($message_id) && empty($item_id)) {
            $searchModel = new UserMsgRecipientsSearch();
            $searchModel->recipient_id = Yii::$app->user->id;
            $current = current($searchModel->searchReceipents(Yii::$app->request->queryParams));
            $message_id = $current['message_id'];
        }

        if (!empty($message_id)) {
            $this->_readMsg($message_id);
        }

        return $this->render('index', ['message_id' => $message_id, 'item_id' => $item_id, 'user_id' => $user_id]);
    }

    public function _readMsg($message_id)
    {
        $msgs = UserMsgRecipients::findAll(['message_id' => $message_id, 'recipient_id' => Yii::$app->user->id]);

        foreach ($msgs as $msg) {
            if ($msg) {
                $msg->status = UserMsg::STATUS_READ;
                $msg->save(false);
            }
        }

        return ['code' => 'failed', 'msg' => "Failed to mark the status as (Read)."];
    }

    public function actionDownloadAttachment($attachment_id)
    {
        $download = UserMsgAttachments::findOne($attachment_id);
        $file = Yii::getAlias("@uploads/$download->attachment");

        if (file_exists($file)) {
            return Yii::$app->response->sendFile($file);
        }
    }

    public function actionDownloadAttachments($message_id, $seq)
    {
        //$download = UserMsgAttachments::findOne($attachment_id);
        $downloads = UserMsgAttachments::findAll(['message_id'=>$message_id, 'seq'=>$seq]);

        $zip = new \ZipArchive();
        if (!$downloads && count($downloads) == 0) {  return $this->redirect(['/dashboard']); }


        $files = [];
        foreach($downloads as $download){
            $files[] = Yii::getAlias("@uploads/$download->attachment");
        }

        $path = $this->_createZip($files);

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        }
    }

    private function _createZip($files)
    {
        $currentTime = time().'.zip';

        $zipFile = Yii::getAlias("@uploads/zip/$currentTime");

        $zip = new \ZipArchive();
        if ($zip->open($zipFile, \ZipArchive::CREATE) !== TRUE) {
            throw new \Exception('Cannot create a zip file');
        }

        foreach($files as $file){
            $zip->addFile($file, basename($file));
        }

        $zip->close();
        return $zipFile;
    }

    /**
     * Displays a single UserMsg model.
     * @param string $id
     * @return mixed
     */

    public function actionView($message_id, $seq = null)
    {
        $searchModel = new UserMsgRecipientsSearch();
        $searchModel->recipient_id = Yii::$app->user->id;
        $searchModel->message_id = $message_id;
        $searchModel->seq = is_null($seq) ? 0 : $seq;

        $dataProvider = $searchModel->viewMsg(Yii::$app->request->queryParams);

        $receipents = $searchModel->searchMessageReceipents();
        if (Yii::$app->request->get('page') == 'off') {
            $dataProvider->setPagination(false);
        }

        $seq = $this->_currentSeq($dataProvider->getModels());
        $result = ['code' => 'success', 'message_id' => $message_id, 'seq' => $seq, 'result' => $dataProvider->getModels(), 'receipents' => $receipents->all(),];
        return array_merge($result, $this->_pagination($dataProvider));
    }


    /*
    * --- Message ---
    * /v1/user-msg/view?message_id=<message_id>&seq=<seq>
    */

    protected function _currentSeq($result)
    {
        $seq = [];
        foreach ($result as $row) {
            $seq[$row['seq']] = $row['seq'];
        }
        return count($seq) > 0 ? max($seq) : 0;
    }

    private function _pagination($dataProvider)
    {

        if ($dataProvider->pagination == false) return [];
        return [
            'pagination' => [
                'pageCount' => $dataProvider->getPagination()->getPageCount(),
                'page' => $dataProvider->getPagination()->getPage(),
                'totalCount' => $dataProvider->totalCount,
                'pageSize' => $dataProvider->getPagination()->getPageSize(),
                'links' => $dataProvider->getPagination()->getLinks(),
            ]
        ];
    }

    /*
    * --- Message ---
    * /v1/user-msg/read-message?message_id=<message_id>&seq=<seq>
    *
    **/

    public function actionReadMessage($message_id, $seq)
    {
        $cnd = sprintf('message_id=%d and recipient_id=%d and seq=%d', $message_id, Yii::$app->user->id, $seq);
        UserMsgRecipients::updateAll(['status' => UserMsgRecipients::STATUS_READ], $cnd);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['code' => 'success', 'msg' => 'Message successfully readed.'];
    }

    /*
    * --- Message ---
    * /v1/user-msg/create
    **/

    /**
     * Creates a new UserMsg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new UserMsg();

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {

            $identifier = Yii::$app->request->get('identifier');
            $message_id = Yii::$app->request->get('message_id');

            $item_id = Yii::$app->request->get('item_id');
            $user_id = Yii::$app->request->get('user_id');

            $seq = Yii::$app->request->get('seq') ?? 1;

            $sender_id = Yii::$app->user->id;
            $users = [];

            $userMsgRecipientsSearch = new UserMsgRecipientsSearch();
            if (empty($message_id)) {
                $message_id = $userMsgRecipientsSearch->findMessageId($item_id, [$user_id, $sender_id]);
            }

            /*
                if (!empty($item_id) && empty($message_id)) {
                    $modelUserMsg = UserMsg::findOne(['item_id' => $item_id, 'sender_id' => $sender_id, 'seq' => $seq,]);
                    if (!is_null($modelUserMsg)) {
                        $message_id = $modelUserMsg->message_id;
                    }
                }
            */

            $model->sender_id = $sender_id;

            if (!empty($message_id) || !empty($identifier)) {

                $modelIdentifier = empty($identifier) ?
                    $this->findModel($message_id, $seq) :
                    $this->findModelByIdentifier($identifier, $seq);
                if ($modelIdentifier) {
                    $identifier = $modelIdentifier->identifier;
                }
                if (empty($item_id)) {
                    $item_id = $modelIdentifier->item_id;
                }

            }

            if (!empty($identifier)) {

                /** get the recips first **/
                $modelMessage = UserMsg::findOne(['message_id' => $message_id, 'seq' => 1]);
                foreach ($modelMessage->userMsgRecipients as $user) {
                    $users[$user->recipient_id] = $user->recipient_id;
                }

            } else {

                $users[$sender_id] = $sender_id;
                if (is_array($user_id)) {
                    foreach ($user_id as $user) {
                        $users[$user] = $user;
                    }
                } elseif (!empty($user_id)) {
                    $users[$user_id] = $user_id;
                }
            }

            /** get message_id # **/
            if (!empty($message_id)) {
                $model->message_id = $message_id;
            }

            $model->identifier = $identifier ?? Yii::$app->getSecurity()->generateRandomString(8);

            /** get seq # **/
            $model->seq = UserMsgSearch::searchMaxSeqId($message_id);

            $model->item_id = $item_id;
            $model->sender_id = $sender_id;
            $model->subject = '';
            $model->status = UserMsg::STATUS_READ;
            $model->created_at = time();

            if ($users && $model->save(false)) {

                $modelAttachments = new UserMsgAttachments();
                $images = Yii::$app->upload->uploadMultiple($modelAttachments, 'attachment');

                if (isset($images) && count($images) > 0) {
                    foreach ($images as $image) {
                        $modelAttachment = clone $modelAttachments;
                        $modelAttachment->message_id = $model->message_id;
                        $modelAttachment->seq = $model->seq;
                        $modelAttachment->sender_id = $model->sender_id;
                        $modelAttachment->attachment = $image;
                        $modelAttachment->save(false);
                    }
                }

                foreach ($users as $user) {

                    $modelRecipients = new UserMsgRecipients();
                    $modelRecipients->message_id = $model->message_id;
                    $modelRecipients->seq = $model->seq;
                    $modelRecipients->recipient_id = $user;
                    $modelRecipients->status = (($user == $sender_id) ? $model->status : UserMsg::STATUS_UNREAD);
                    $modelRecipients->save();
                    if (Yii::$app->user->id != $user) {
                        //send mail
                        $model->sendEmail($user);
                    }
                }

                $this->module->trigger('Send', AutoEvent::getNotifyMessage('Send',  $model->item_id, $model->message_id, ['model' => $model]));

                if(Yii::$app->request->isAjax){
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['code' => 'success', 'msg' => 'You are successfully sent the message.', 'message_id' => $model->message_id, 'seq' => $model->seq, 'text' => $model->text,];
                }else{
                    return $this->redirect(['/messages', 'message_id' => $model->message_id,]);
                }
            }

            return ['code' => 'failed', 'msg' => 'There was an error sending message.', 'errors' => $model->errors];
        }
        return ['code' => 'failed', 'msg' => 'There was an error sending message.', 'errors' => $model->errors];
    }

    protected function findModel($id, $seq)
    {
        if (($model = UserMsg::findOne($id, $seq)) !== null) {
            return $model;
        }

        return null;
    }

    protected function findModelByIdentifier($identifier, $seq)
    {
        if (($model = UserMsg::findOne(['identifier' => $identifier, 'seq' => $seq])) !== null) {
            return $model;
        }
        return null;
    }

    public function actionValidate()
    {
        $model = new UserMsg();
        if (Yii::$app->request->isAjax && Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $model->message_id = Yii::$app->request->get('message_id');
            $model->sender_id = Yii::$app->user->getId();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

    }

    public function actionAttachmentUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $code = 'failed';
        $modelAttachments = new UserMsgAttachments();
        $item_id = Yii::$app->request->get('item_id');
        $user_id = Yii::$app->request->get('user_id');
        $message_id = Yii::$app->request->get('message_id');

        $userMsgRecipientsSearch = new UserMsgRecipientsSearch();

        if (empty($message_id)) {
            $message_id = $userMsgRecipientsSearch->findMessageId($item_id, [$user_id, Yii::$app->user->id]);
        }

        $modelUserMsgSearch = new UserMsgSearch();
        $seq = $modelUserMsgSearch->findLastSeqId($message_id);

        $images = Yii::$app->upload->uploadMultiple($modelAttachments, 'attachment');

        if (isset($images) && count($images) > 0) {

            foreach ($images as $image) {
                $modelAttachment = clone $modelAttachments;
                $modelAttachment->message_id = $message_id;
                $modelAttachment->seq = $seq;
                $modelAttachment->sender_id = Yii::$app->user->getId();
                $modelAttachment->attachment = $image;
                $modelAttachment->save(false);
            }
            $code = 'success';
        }

        $info = ['type' => 'upload', 'code' => $code, 'message_id' => $message_id, 'seq' => $seq, 'text' => Yii::t('app', 'Your file uploading code: {code}', ['code'=>$code]), 'attachment_id' => $modelAttachment->attachment_id];
        return $info;

    }

    /**
     * --- Message ---
     * /v1/user-msg/delete?message_id=<message_id>&seq=<seq>
     *
     */

    public function actionAppendRecent()
    {
        $message_id = Yii::$app->request->get('message_id');
        $seq = Yii::$app->request->get('seq');

        $searchModel = new UserMsgRecipientsSearch();
        $searchModel->message_id = $message_id;
        $searchModel->seq = $seq - 1;
        $searchModel->recipient_id = Yii::$app->user->id;
        $dataProvider = $searchModel->viewMsg(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;

        return $this->renderAjax('partial/_chat', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAppendAttachment()
    {
        $message_id = Yii::$app->request->get('message_id');
        $seq = Yii::$app->request->get('seq');

        $searchModel = new UserMsgAttachmentsSearch();
        $searchModel->message_id = $message_id;
        $searchModel->seq = $seq;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        return $this->renderAjax('partial/_attachment', [ 'dataProvider' => $dataProvider,]);
    }


    /**
     * Deletes an existing UserMsg model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

    public function actionDelete($message_id, $seq = null)
    {
        $cnd = [];
        if ($message_id) {
            $cnd['message_id'] = $message_id;
        }
        if ($seq) {
            $cnd['seq'] = $seq;
        }
        $cnd['recipient_id'] = Yii::$app->user->id;

        UserMsgRecipients::updateAll(['status' => UserMsgRecipients::STATUS_DELETED], $cnd);
        return ['code' => 'success', 'msg' => 'Message successfully deleted.'];
    }

    public function actionMessage(){

        $item_id = Yii::$app->request->get('item_id');
        $user_id = Yii::$app->request->get('user_id');

        $userMsgRecipientsSearch = new UserMsgRecipientsSearch();
        $message_id = $userMsgRecipientsSearch->findMessageId($item_id, [$user_id, Yii::$app->user->id]);

        $model = new UserMsg();
        return $this->renderAjax('partial/_frm-message', ['model' => $model, 'item_id' => $item_id, 'user_id' => $user_id, 'message_id' => $message_id]);

    }


}