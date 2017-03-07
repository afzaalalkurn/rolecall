<?php

namespace frontend\modules\user\controllers;

use Yii;
use backend\modules\user\models\UserNotificationRecipients;
use backend\modules\user\models\search\UserNotificationRecipients as UserNotificationRecipientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * UserNotificationRecipientsController implements the CRUD actions for UserNotificationRecipients model.
 */
class UserNotificationRecipientsController extends Controller
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

    /**
     * Lists all UserNotificationRecipients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserNotificationRecipientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserNotificationRecipients model.
     * @param string $message_id
     * @param string $seq
     * @param string $recipient_id
     * @return mixed
     */
    public function actionView($message_id, $seq, $recipient_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($message_id, $seq, $recipient_id),
        ]);
    }

    /**
     * Creates a new UserNotificationRecipients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserNotificationRecipients();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'message_id' => $model->message_id, 'seq' => $model->seq, 'recipient_id' => $model->recipient_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionRead(){
        $success = false;

        if (Yii::$app->request->isAjax && Yii::$app->request->post()){
            $message_id = Yii::$app->request->post('message_id');
            $seq = 1;
            $recipient_id = Yii::$app->user->id;
            $model = $this->findModel($message_id, $seq, $recipient_id);
            $model->status = UserNotificationRecipients::STATUS_READ;
            if ($model->save()) {
                $success = true;
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [ 'success' => $success];
    }

    /**
     * Updates an existing UserNotificationRecipients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $message_id
     * @param string $seq
     * @param string $recipient_id
     * @return mixed
     */
    public function actionUpdate($message_id, $seq, $recipient_id)
    {
        $model = $this->findModel($message_id, $seq, $recipient_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'message_id' => $model->message_id, 'seq' => $model->seq, 'recipient_id' => $model->recipient_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserNotificationRecipients model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $message_id
     * @param string $seq
     * @param string $recipient_id
     * @return mixed
     */
    public function actionDelete($message_id, $seq, $recipient_id)
    {
        $this->findModel($message_id, $seq, $recipient_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserNotificationRecipients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $message_id
     * @param string $seq
     * @param string $recipient_id
     * @return UserNotificationRecipients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($message_id, $seq, $recipient_id)
    {
        if (($model = UserNotificationRecipients::findOne(['message_id' => $message_id, 'seq' => $seq, 'recipient_id' => $recipient_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
