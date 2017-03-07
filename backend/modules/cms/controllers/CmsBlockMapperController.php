<?php

namespace backend\modules\cms\controllers;

use Yii;
use backend\modules\cms\models\CmsBlockMapper;
use backend\modules\cms\models\search\CmsBlockMapper as CmsBlockMapperSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsBlockMapperController implements the CRUD actions for CmsBlockMapper model.
 */
class CmsBlockMapperController extends Controller
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
     * Lists all CmsBlockMapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsBlockMapperSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsBlockMapper model.
     * @param string $block_id
     * @param string $cms_id
     * @return mixed
     */
    public function actionView($block_id, $cms_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($block_id, $cms_id),
        ]);
    }

    /**
     * Creates a new CmsBlockMapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsBlockMapper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'block_id' => $model->block_id, 'cms_id' => $model->cms_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CmsBlockMapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $block_id
     * @param string $cms_id
     * @return mixed
     */
    public function actionUpdate($block_id, $cms_id)
    {
        $model = $this->findModel($block_id, $cms_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'block_id' => $model->block_id, 'cms_id' => $model->cms_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CmsBlockMapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $block_id
     * @param string $cms_id
     * @return mixed
     */
    public function actionDelete($block_id, $cms_id)
    {
        $this->findModel($block_id, $cms_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsBlockMapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $block_id
     * @param string $cms_id
     * @return CmsBlockMapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($block_id, $cms_id)
    {
        if (($model = CmsBlockMapper::findOne(['block_id' => $block_id, 'cms_id' => $cms_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
