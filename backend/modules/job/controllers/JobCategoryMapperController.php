<?php

namespace backend\modules\job\controllers;

use Yii;
use backend\modules\job\models\JobCategoryMapper;
use backend\modules\job\models\search\JobCategoryMapper as JobCategoryMapperSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobCategoryMapperController implements the CRUD actions for JobCategoryMapper model.
 */
class JobCategoryMapperController extends Controller
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
     * Lists all JobCategoryMapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobCategoryMapperSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JobCategoryMapper model.
     * @param string $job_id
     * @param string $category_id
     * @return mixed
     */
    public function actionView($job_id, $category_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($job_id, $category_id),
        ]);
    }

    /**
     * Creates a new JobCategoryMapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JobCategoryMapper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'job_id' => $model->job_id, 'category_id' => $model->category_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing JobCategoryMapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $job_id
     * @param string $category_id
     * @return mixed
     */
    public function actionUpdate($job_id, $category_id)
    {
        $model = $this->findModel($job_id, $category_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'job_id' => $model->job_id, 'category_id' => $model->category_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing JobCategoryMapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $job_id
     * @param string $category_id
     * @return mixed
     */
    public function actionDelete($job_id, $category_id)
    {
        $this->findModel($job_id, $category_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the JobCategoryMapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $job_id
     * @param string $category_id
     * @return JobCategoryMapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($job_id, $category_id)
    {
        if (($model = JobCategoryMapper::findOne(['job_id' => $job_id, 'category_id' => $category_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
