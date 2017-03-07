<?php

namespace frontend\modules\job\controllers;

use Yii;
use backend\modules\job\models\JobFieldValue;
use backend\modules\job\models\search\JobFieldValue as JobFieldValueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobFieldValueController implements the CRUD actions for JobFieldValue model.
 */
class JobFieldValueController extends Controller
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
     * Lists all JobFieldValue models.
     * @return mixed
     */
    public function actionIndex()
    {

        $job_id = Yii::$app->request->get('job_id');

        $searchModel = new JobFieldValueSearch();
        $searchModel->job_id = $job_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'job_id' => $job_id,
        ]);
    }

    /**
     * Displays a single JobFieldValue model.
     * @param string $job_id
     * @param string $field_id
     * @return mixed
     */
    public function actionView($job_id, $field_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($job_id, $field_id),
        ]);
    }

    /**
     * Creates a new JobFieldValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JobFieldValue();
        $job_id = Yii::$app->request->get('job_id');

        if ($model->load(Yii::$app->request->post())) {
            $model->job_id = $job_id;
            $model->save();
            return $this->redirect(['view', 'job_id' => $model->job_id, 'field_id' => $model->field_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'job_id' => $job_id,
            ]);
        }
    }

    /**
     * Updates an existing JobFieldValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $job_id
     * @param string $field_id
     * @return mixed
     */
    public function actionUpdate($job_id, $field_id)
    {
        $model = $this->findModel($job_id, $field_id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'job_id' => $model->job_id, 'field_id' => $model->field_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing JobFieldValue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $job_id
     * @param string $field_id
     * @return mixed
     */
    public function actionDelete($job_id, $field_id)
    {
        $this->findModel($job_id, $field_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the JobFieldValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $job_id
     * @param string $field_id
     * @return JobFieldValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($job_id, $field_id)
    {
        if (($model = JobFieldValue::findOne(['job_id' => $job_id, 'field_id' => $field_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
