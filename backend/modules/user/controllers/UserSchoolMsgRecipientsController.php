<?php

namespace backend\modules\user\controllers;

use Yii;
use backend\modules\user\models\UserSchoolMsgRecipients;
use backend\modules\user\models\search\UserSchoolMsgRecipients as UserSchoolMsgRecipientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserSchoolMsgRecipientsController implements the CRUD actions for UserSchoolMsgRecipients model.
 */
class UserSchoolMsgRecipientsController extends Controller
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
     * Lists all UserSchoolMsgRecipients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSchoolMsgRecipientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserSchoolMsgRecipients model.
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
     * Creates a new UserSchoolMsgRecipients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserSchoolMsgRecipients();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'message_id' => $model->message_id, 'seq' => $model->seq, 'recipient_id' => $model->recipient_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserSchoolMsgRecipients model.
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
     * Deletes an existing UserSchoolMsgRecipients model.
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
     * Finds the UserSchoolMsgRecipients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $message_id
     * @param string $seq
     * @param string $recipient_id
     * @return UserSchoolMsgRecipients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($message_id, $seq, $recipient_id)
    {
        if (($model = UserSchoolMsgRecipients::findOne(['message_id' => $message_id, 'seq' => $seq, 'recipient_id' => $recipient_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
