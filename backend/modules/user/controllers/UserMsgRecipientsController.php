<?php

namespace backend\modules\user\controllers;

use Yii;
use backend\modules\user\models\UserMsgRecipients;
use backend\modules\user\models\search\UserMsgRecipients as UserMsgRecipientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserMsgRecipientsController implements the CRUD actions for UserMsgRecipients model.
 */
class UserMsgRecipientsController extends Controller
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
     * Lists all UserMsgRecipients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserMsgRecipientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserMsgRecipients model.
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
     * Creates a new UserMsgRecipients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserMsgRecipients();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'message_id' => $model->message_id, 'seq' => $model->seq, 'recipient_id' => $model->recipient_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserMsgRecipients model.
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
     * Deletes an existing UserMsgRecipients model.
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
     * Finds the UserMsgRecipients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $message_id
     * @param string $seq
     * @param string $recipient_id
     * @return UserMsgRecipients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($message_id, $seq, $recipient_id)
    {
        if (($model = UserMsgRecipients::findOne(['message_id' => $message_id, 'seq' => $seq, 'recipient_id' => $recipient_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
