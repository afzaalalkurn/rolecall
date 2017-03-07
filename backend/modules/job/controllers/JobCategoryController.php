<?php

namespace backend\modules\job\controllers;

use backend\modules\job\models\JobCategoryTemplate;
use Yii;
use backend\modules\job\models\JobCategory;
use backend\modules\job\models\search\JobCategory as JobCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\job\models\JobCategoryFr;

/**
 * JobCategoryController implements the CRUD actions for JobCategory model.
 */
class JobCategoryController extends Controller
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
     * Lists all JobCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JobCategory model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new JobCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JobCategory();
        $modelJobCategoryFr = new JobCategoryFr();
        $modelJobCategoryTemplate = new JobCategoryTemplate();
        $modelJobCategoryTemplateFr = new JobCategoryTemplateFr();

        if ($model->load(Yii::$app->request->post()) && $modelJobCategoryFr->load(Yii::$app->request->post())){

            $model->create_date = date('Y-m-d');
            if($model->save()){
                $modelJobCategoryFr->category_id = $model->category_id;
                $modelJobCategoryFr->save();

                $modelJobCategoryTemplate->category_id = $model->category_id;
                $modelJobCategoryTemplate->save();

                $modelJobCategoryTemplateFr->category_id = $model->category_id;
                $modelJobCategoryTemplateFr->save();
            }

            return $this->redirect(['view', 'id' => $model->category_id]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'modelJobCategoryFr' => $modelJobCategoryFr,
                'modelJobCategoryTemplate' => $modelJobCategoryTemplate,
                'modelJobCategoryTemplateFr' => $modelJobCategoryTemplateFr,
            ]);
        }
    }

    /**
     * Updates an existing JobCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
         $model = $this->findModel($id);
         $modelJobCategoryFr = $model->jobCategoryFr;
         $modelJobCategoryTemplate = $model->jobCategoryTemplate;
         $modelJobCategoryTemplateFr = $model->jobCategoryTemplateFr;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $modelJobCategoryFr->load(Yii::$app->request->post());
            $modelJobCategoryTemplate->load(Yii::$app->request->post());
            $modelJobCategoryTemplateFr->load(Yii::$app->request->post());

            //$modelJobCategoryFr->category_id = $model->category_id;
            $modelJobCategoryFr->save();

            //$modelJobCategoryTemplate->category_id = $model->category_id;
            $modelJobCategoryTemplate->save();
            $modelJobCategoryTemplateFr->save();

            return $this->redirect(['view', 'id' => $model->category_id]);

        } else {
            return $this->render('update', [
                'model' => $model,
                'modelJobCategoryFr' => $modelJobCategoryFr,
                'modelJobCategoryTemplate' => $modelJobCategoryTemplate,
                'modelJobCategoryTemplateFr' => $modelJobCategoryTemplateFr,
            ]);
        }
    }

    /**
     * Deletes an existing JobCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the JobCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return JobCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JobCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
