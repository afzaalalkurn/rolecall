<?php

namespace backend\modules\cms\controllers;

use Yii;
use backend\modules\cms\models\CmsMenuPath;
use backend\modules\cms\models\search\CmsMenuPath as CmsMenuPathSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsMenuPathController implements the CRUD actions for CmsMenuPath model.
 */
class CmsMenuPathController extends Controller
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
     * Lists all CmsMenuPath models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsMenuPathSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsMenuPath model.
     * @param string $category_id
     * @param string $parent_id
     * @return mixed
     */
    public function actionView($category_id, $parent_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($category_id, $parent_id),
        ]);
    }

    /**
     * Creates a new CmsMenuPath model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsMenuPath();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'category_id' => $model->category_id, 'parent_id' => $model->parent_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CmsMenuPath model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $category_id
     * @param string $parent_id
     * @return mixed
     */
    public function actionUpdate($category_id, $parent_id)
    {
        $model = $this->findModel($category_id, $parent_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'category_id' => $model->category_id, 'parent_id' => $model->parent_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CmsMenuPath model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $category_id
     * @param string $parent_id
     * @return mixed
     */
    public function actionDelete($category_id, $parent_id)
    {
        $this->findModel($category_id, $parent_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsMenuPath model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $category_id
     * @param string $parent_id
     * @return CmsMenuPath the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($category_id, $parent_id)
    {
        if (($model = CmsMenuPath::findOne(['category_id' => $category_id, 'parent_id' => $parent_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
