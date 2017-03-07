<?php

namespace backend\modules\cms\controllers;

use Yii;
use backend\modules\cms\models\CmsWidgetMapper;
use backend\modules\cms\models\search\CmsWidgetMapper as CmsWidgetMapperSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsWidgetMapperController implements the CRUD actions for CmsWidgetMapper model.
 */
class CmsWidgetMapperController extends Controller
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
     * Lists all CmsWidgetMapper models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsWidgetMapperSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsWidgetMapper model.
     * @param string $widget_id
     * @param string $cms_id
     * @return mixed
     */
    public function actionView($widget_id, $cms_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($widget_id, $cms_id),
        ]);
    }

    /**
     * Creates a new CmsWidgetMapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsWidgetMapper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'widget_id' => $model->widget_id, 'cms_id' => $model->cms_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CmsWidgetMapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $widget_id
     * @param string $cms_id
     * @return mixed
     */
    public function actionUpdate($widget_id, $cms_id)
    {
        $model = $this->findModel($widget_id, $cms_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'widget_id' => $model->widget_id, 'cms_id' => $model->cms_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CmsWidgetMapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $widget_id
     * @param string $cms_id
     * @return mixed
     */
    public function actionDelete($widget_id, $cms_id)
    {
        $this->findModel($widget_id, $cms_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsWidgetMapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $widget_id
     * @param string $cms_id
     * @return CmsWidgetMapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($widget_id, $cms_id)
    {
        if (($model = CmsWidgetMapper::findOne(['widget_id' => $widget_id, 'cms_id' => $cms_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
