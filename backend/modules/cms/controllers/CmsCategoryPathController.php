<?php

namespace backend\modules\cms\controllers;

use Yii;
use backend\modules\cms\models\CmsCategoryPath;
use backend\modules\cms\models\search\CmsCategoryPath as CmsCategoryPathSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsCategoryPathController implements the CRUD actions for CmsCategoryPath model.
 */
class CmsCategoryPathController extends Controller
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
     * Lists all CmsCategoryPath models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsCategoryPathSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsCategoryPath model.
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
     * Creates a new CmsCategoryPath model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsCategoryPath();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'category_id' => $model->category_id, 'parent_id' => $model->parent_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CmsCategoryPath model.
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
     * Deletes an existing CmsCategoryPath model.
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
     * Finds the CmsCategoryPath model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $category_id
     * @param string $parent_id
     * @return CmsCategoryPath the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($category_id, $parent_id)
    {
        if (($model = CmsCategoryPath::findOne(['category_id' => $category_id, 'parent_id' => $parent_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
