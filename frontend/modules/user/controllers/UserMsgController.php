<?php

namespace frontend\modules\user\controllers;

use backend\modules\job\models\JobItem;
use backend\modules\job\models\JobUserMapper;
use backend\modules\user\models\User;
use backend\modules\user\models\UserMsgAttachments;
use backend\modules\user\models\UserMsgRecipients as UserMsgRecipients;
use backend\modules\user\models\search\UserMsgRecipients as UserMsgRecipientsSearch;

use common\models\Upload;
use frontend\event\AutoEvent;
use Yii;
use backend\modules\user\models\UserMsg;
use backend\modules\user\models\search\UserMsg as UserMsgSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * UserMsgController implements the CRUD actions for UserMsg model.
 * user-msg
 */
class UserMsgController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserMsgRecipientsSearch();
        $searchModel->recipient_id  = Yii::$app->user->id;
        $searchModel->job_id        = Yii::$app->request->get('job_id');
        $dataProvider = $searchModel->searchMsg(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserMsg model.
     * @param string $id
     * @return mixed
     */
    public function actionView($message_id, $seq)
    {
        $searchModel = new UserMsgRecipientsSearch();
        $searchModel->recipient_id = Yii::$app->user->id;
        //$searchModel->identifier = $identifier;
        $searchModel->message_id = $message_id;
        $searchModel->seq = $seq;
        $dataProvider = $searchModel->viewMsg(Yii::$app->request->queryParams);
        $modelIdentifier = (empty($identifier)) ? $this->findModel($message_id, $seq) : $this->findModelByIdentifier($identifier, $seq);
        if ($modelIdentifier) {
            $identifier = $modelIdentifier->identifier;
        }

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'message_id' => $message_id,
            'identifier' => $identifier,
        ]);

    }

    public function actionReadMessage()
    {
        if (Yii::$app->request->isAjax) {

            $message_id = Yii::$app->request->post('message_id');
            $seq = Yii::$app->request->post('seq');
            $cnd = sprintf('message_id=%d and recipient_id=%d and seq=%d', $message_id, Yii::$app->user->id, $seq);
            UserMsgRecipients::updateAll(['status' => UserMsgRecipients::STATUS_READ], $cnd);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => true,];
        }
    }

    /**
     * Creates a new UserMsg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $identifier = Yii::$app->request->get('identifier');
        $message_id = Yii::$app->request->get('message_id');
        $seq = Yii::$app->request->get('seq') ?? 1;
        $sender_id = Yii::$app->user->id;
        $user_id = Yii::$app->request->get('user_id');
        $job_id = Yii::$app->request->get('job_id');
        $is_success = false;
        $model = new UserMsg();

        if (!empty($message_id) || !empty($identifier)) {

            $modelIdentifier = empty($identifier) ?
                $this->findModel($message_id, $seq) :
                $this->findModelByIdentifier($identifier, $seq);

            if ($modelIdentifier) {
                $identifier = $modelIdentifier->identifier;
                $job_id = $modelIdentifier->job_id;
                $user_id = $modelIdentifier->user_id;
            }
        }

        if ($model->load(Yii::$app->request->post())) {

            $is_success = false;
            
            /*if ((JobUserMapper::findOne(['job_id' => $job_id, 'user_id' => $sender_id, 'status' => 'Applied'])) == null) {
                $this->_applyNow();
            }*/

            if (!empty($identifier)) {

                /** get the recips first **/
                $modelRecipients = new UserMsgRecipientsSearch();
                $modelRecipients->message_id = $model->message_id;
                $recipientProvider = $modelRecipients->searchRecipients(Yii::$app->request->queryParams);

                $users = [];

                foreach ($recipientProvider->all() as $user) {
                    $users[$user->recipient_id] = $user->recipient_id;
                }

                /** get seq # **/
                $maxSeq = (new UserMsgSearch())->searchMaxSeqId($identifier)->one()->seq;

                } else {
                    
                    $modelJobItem = JobItem::findOne(['job_id' => $job_id]);
                    $maxSeq = 1;
                    $users[$sender_id] = $sender_id;
                    $users[$modelJobItem->user_id] = $modelJobItem->user_id;
                }

            if(!empty($user_id)){ $users[$user_id] = $user_id; } 

            /** get message_id # **/

            if (!empty($message_id)) {
                $model->message_id = $message_id;
            }

            $model->identifier = $identifier ?? Yii::$app->getSecurity()->generateRandomString(8);
            $model->job_id = $job_id;
            $model->user_id = $user_id;
            $model->seq = $maxSeq;
            $model->sender_id = $sender_id;
            $model->status = UserMsg::STATUS_READ;

            if ($users && $model->save(false)) { 
                
                foreach ($users as $user) { 
                   
                    $modelRecipients = new UserMsgRecipients();
                    $modelRecipients->message_id = $model->message_id;
                    $modelRecipients->seq = $model->seq;
                    $modelRecipients->recipient_id = $user;
                    $modelRecipients->status = (($user == $sender_id) ? $model->status : UserMsg::STATUS_UNREAD);
                    $modelRecipients->save();
                    if ($sender_id !== $user) {
                        $modelRecipient = User::findOne(['id' => $user]);
                        $this->_send($modelRecipient->email, '', 'message', $modelRecipient);
                    }
                }

                foreach (UploadedFile::getInstances($model, 'attachment') as $file) {
                    $modelAttachment = new UserMsgAttachments();
                    $modelAttachment->message_id = $model->message_id;
                    $modelAttachment->seq = $model->seq;
                    $modelAttachment->sender_id = $model->sender_id;
                    $modelUpload = new Upload();
                    $modelUpload->file = $file;
                    $modelAttachment->attachment = $modelUpload->upload();
                    $modelAttachment->save();
                }

                $is_success = true;
                Yii::$app->session->setFlash('success', Yii::t('app', 'Message sent successfully.' ) );

                return $this->renderAjax('partial/_success', [
                    'success' => $is_success,
                ]);
            }

            Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error sending email.'));

        } else {

            return $this->renderAjax('create', [
                'model' => $model,
                'job_id' => $job_id,
                'user_id' => $user_id,
                'sender_id' => $sender_id,
                'identifier' => $identifier,
                'message_id' => $message_id,
            ]);
        }
    }

    protected function _send($email, $body, $tpl = null, $model = null)
    {
        /* @var $user User */

        return Yii::$app
            ->mail
            ->compose(
                ['html' => $tpl . '-html', 'text' => $tpl . '-text'],
                ['model' => $model]
            )
            ->setTextBody($body)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject(Yii::t('app', sprintf('You Have new message %s.', Yii::$app->name)))
            ->send();
    }

    public function actionDownload($seq,$sender_id)
    {

        $model = UserMsgAttachments::findOne(['seq' => $seq, 'sender_id' => $sender_id]);
        $file = Yii::getAlias('@uploads/') . $model->attachment;
        if (file_exists($file)) {
            return Yii::$app->response->sendFile($file);
        }
    }

    private function _applyNow()
    {

        $model = new JobUserMapper();
        $model->job_id = Yii::$app->request->get('job_id');
        $model->status = JobUserMapper::STATUS_APPLIED;
        $model->user_id = Yii::$app->user->id;

        $success = false;
        if ($model->validate() && $model->save()) {
            Yii::$app->modules['user']->trigger($model->status, AutoEvent::generate($model->status, $model->job_id));
            $success = true;
            Yii::$app->session->addFlash('success', Yii::t('app', 'You are successfully applied to job.'));
        }
        return $success;
    }

    /**
     * Deletes an existing UserMsg model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($message_id, $seq = null)
    {
        $cnd = sprintf('message_id=%d and status != "%s" and recipient_id=%d', $message_id, UserMsgRecipients::STATUS_DELETED, Yii::$app->user->id);
        UserMsgRecipients::updateAll(['status' => UserMsgRecipients::STATUS_DELETED], $cnd);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Message deleted successfully.'));
        return $this->redirect(['index']);
    }


    public function actionArchive($message_id, $seq = null)
    {
        $cnd = sprintf('message_id=%d and status != "%s" and recipient_id=%d', $message_id, UserMsgRecipients::STATUS_ARCHIVED, Yii::$app->user->id);
        UserMsgRecipients::updateAll(['status' => UserMsgRecipients::STATUS_ARCHIVED], $cnd);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Message successfully moved to archive.'));
        return $this->redirect(['index']);
    }

    public function actionAllArchive(){

        $searchModel = new UserMsgRecipientsSearch();
        $searchModel->recipient_id  = Yii::$app->user->id;
        $searchModel->job_id        = Yii::$app->request->get('job_id');
        $dataProvider = $searchModel->archiveMsg(Yii::$app->request->queryParams);
        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the UserMsg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserMsg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $seq)
    {
        if (($model = UserMsg::findOne($id, $seq)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelByIdentifier($identifier, $seq)
    {
        if (($model = UserMsg::findOne(['identifier' => $identifier, 'seq' => $seq])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}