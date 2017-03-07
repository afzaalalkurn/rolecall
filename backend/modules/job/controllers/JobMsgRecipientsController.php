<?php

namespace backend\modules\job\controllers;

use Yii;
use backend\modules\job\models\JobMsgRecipients;
use backend\modules\job\models\search\JobMsgRecipients as JobMsgRecipientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobMsgRecipientsController implements the CRUD actions for JobMsgRecipients model.
 */
class JobMsgRecipientsController extends Controller
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
     * Lists all JobMsgRecipients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobMsgRecipientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JobMsgRecipients model.
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
     * Creates a new JobMsgRecipients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JobMsgRecipients();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'message_id' => $model->message_id, 'seq' => $model->seq, 'recipient_id' => $model->recipient_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing JobMsgRecipients model.
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
     * Deletes an existing JobMsgRecipients model.
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
     * Finds the JobMsgRecipients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $message_id
     * @param string $seq
     * @param string $recipient_id
     * @return JobMsgRecipients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($message_id, $seq, $recipient_id)
    {
        if (($model = JobMsgRecipients::findOne(['message_id' => $message_id, 'seq' => $seq, 'recipient_id' => $recipient_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
