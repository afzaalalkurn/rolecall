<?php

namespace backend\modules\cms\controllers;

use Yii;
use backend\modules\cms\models\CmsPath;
use backend\modules\cms\models\search\CmsPath as CmsPathSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsPathController implements the CRUD actions for CmsPath model.
 */
class CmsPathController extends Controller
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
     * Lists all CmsPath models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsPathSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsPath model.
     * @param string $cms_id
     * @param string $path_id
     * @return mixed
     */
    public function actionView($cms_id, $path_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cms_id, $path_id),
        ]);
    }

    /**
     * Creates a new CmsPath model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsPath();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cms_id' => $model->cms_id, 'path_id' => $model->path_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CmsPath model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $cms_id
     * @param string $path_id
     * @return mixed
     */
    public function actionUpdate($cms_id, $path_id)
    {
        $model = $this->findModel($cms_id, $path_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cms_id' => $model->cms_id, 'path_id' => $model->path_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CmsPath model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $cms_id
     * @param string $path_id
     * @return mixed
     */
    public function actionDelete($cms_id, $path_id)
    {
        $this->findModel($cms_id, $path_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsPath model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $cms_id
     * @param string $path_id
     * @return CmsPath the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cms_id, $path_id)
    {
        if (($model = CmsPath::findOne(['cms_id' => $cms_id, 'path_id' => $path_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
