<?php

namespace backend\modules\cms\controllers;

use Yii;
use backend\modules\cms\models\CmsCategoryMapper;
use backend\modules\cms\models\search\CmsCategoryMapper as CmsCategoryMapperSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsCategoryMapperController implements the CRUD actions for CmsCategoryMapper model.
 */
class CmsCategoryMapperController extends Controller
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
     * Lists all CmsCategoryMapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsCategoryMapperSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsCategoryMapper model.
     * @param string $cms_id
     * @param string $category_id
     * @return mixed
     */
    public function actionView($cms_id, $category_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cms_id, $category_id),
        ]);
    }

    /**
     * Creates a new CmsCategoryMapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsCategoryMapper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cms_id' => $model->cms_id, 'category_id' => $model->category_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CmsCategoryMapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $cms_id
     * @param string $category_id
     * @return mixed
     */
    public function actionUpdate($cms_id, $category_id)
    {
        $model = $this->findModel($cms_id, $category_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cms_id' => $model->cms_id, 'category_id' => $model->category_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CmsCategoryMapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $cms_id
     * @param string $category_id
     * @return mixed
     */
    public function actionDelete($cms_id, $category_id)
    {
        $this->findModel($cms_id, $category_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsCategoryMapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $cms_id
     * @param string $category_id
     * @return CmsCategoryMapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cms_id, $category_id)
    {
        if (($model = CmsCategoryMapper::findOne(['cms_id' => $cms_id, 'category_id' => $category_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
