<?php

namespace backend\modules\cms\controllers;

use Yii;
use backend\modules\cms\models\CmsRelation;
use backend\modules\cms\models\search\CmsRelation as CmsRelationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsRelationController implements the CRUD actions for CmsRelation model.
 */
class CmsRelationController extends Controller
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
     * Lists all CmsRelation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsRelationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsRelation model.
     * @param string $cms_id
     * @param string $keyword_id
     * @return mixed
     */
    public function actionView($cms_id, $keyword_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cms_id, $keyword_id),
        ]);
    }

    /**
     * Creates a new CmsRelation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsRelation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cms_id' => $model->cms_id, 'keyword_id' => $model->keyword_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CmsRelation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $cms_id
     * @param string $keyword_id
     * @return mixed
     */
    public function actionUpdate($cms_id, $keyword_id)
    {
        $model = $this->findModel($cms_id, $keyword_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cms_id' => $model->cms_id, 'keyword_id' => $model->keyword_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CmsRelation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $cms_id
     * @param string $keyword_id
     * @return mixed
     */
    public function actionDelete($cms_id, $keyword_id)
    {
        $this->findModel($cms_id, $keyword_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsRelation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $cms_id
     * @param string $keyword_id
     * @return CmsRelation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cms_id, $keyword_id)
    {
        if (($model = CmsRelation::findOne(['cms_id' => $cms_id, 'keyword_id' => $keyword_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
