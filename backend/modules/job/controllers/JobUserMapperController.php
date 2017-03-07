<?php

namespace backend\modules\job\controllers;

use Yii;
use backend\modules\job\models\JobUserMapper;
use backend\modules\job\models\search\JobUserMapper as JobUserMapperSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobUserMapperController implements the CRUD actions for JobUserMapper model.
 */
class JobUserMapperController extends Controller
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
     * Lists all JobUserMapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobUserMapperSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JobUserMapper model.
     * @param string $job_id
     * @param string $user_id
     * @return mixed
     */
    public function actionView($job_id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($job_id, $user_id),
        ]);
    }

    /**
     * Creates a new JobUserMapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JobUserMapper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'job_id' => $model->job_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing JobUserMapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $job_id
     * @param string $user_id
     * @return mixed
     */
    public function actionUpdate($job_id, $user_id)
    {
        $model = $this->findModel($job_id, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'job_id' => $model->job_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing JobUserMapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $job_id
     * @param string $user_id
     * @return mixed
     */
    public function actionDelete($job_id, $user_id)
    {
        $this->findModel($job_id, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the JobUserMapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $job_id
     * @param string $user_id
     * @return JobUserMapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($job_id, $user_id)
    {
        if (($model = JobUserMapper::findOne(['job_id' => $job_id, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
