<?php

namespace backend\modules\cms\controllers;

use backend\modules\cms\models\CmsCategory;
use backend\modules\cms\models\CmsCategoryMapper;
use Yii;
use backend\modules\cms\models\CmsItem;
use backend\modules\cms\models\search\CmsItem as CmsItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsItemController implements the CRUD actions for CmsItem model.
 */
class CmsItemController extends Controller
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
     * Lists all CmsItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsItem model.
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
     * Creates a new CmsItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model   = new CmsItem(); 
        if ($model->validate() && $model->load(Yii::$app->request->post())) {

            $model->create_date = date('Y-m-d h:i:s', time());
            $model->layout_id = 1;
            $model->restricted = 0;
            $model->status = 1;

            if($model->save()){
               return $this->redirect(['view', 'id' => $model->id]);
            } 
        } else {
            return $this->render('create', [
                'model' => $model,
               
            ]);
        }
    }

    /**
     * Updates an existing CmsItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                
            ]);
        }
    }

    /**
     * Deletes an existing CmsItem model.
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
     * Finds the CmsItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CmsItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
