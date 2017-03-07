<?php

namespace backend\modules\user\controllers;

use Yii;
use backend\modules\user\models\UserNews;
use backend\modules\user\models\search\UserNews as UserNewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\user\models\UserNewsFr;

/**
 * UserNewsController implements the CRUD actions for UserNews model.
 */
class UserNewsController extends Controller
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
     * Lists all UserNews models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserNewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserNews model.
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
     * Creates a new UserNews model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserNews();
        $modelUserNewsFr = new UserNewsFr();

        if ($model->load(Yii::$app->request->post()) && $modelUserNewsFr->load(Yii::$app->request->post()) && $model->save()) {

            $modelUserNewsFr->news_id = $model->id;
            $modelUserNewsFr->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelUserNewsFr' => $modelUserNewsFr
            ]);
        }
    }

    /**
     * Updates an existing UserNews model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUserNewsFr = new UserNewsFr();

        if ($model->load(Yii::$app->request->post()) && $modelUserNewsFr->load(Yii::$app->request->post()) && $model->save()) {

            $modelUserNewsFr->news_id = $model->id;
            $modelUserNewsFr->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelUserNewsFr' => $modelUserNewsFr
            ]);
        }
    }

    /**
     * Deletes an existing UserNews model.
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
     * Finds the UserNews model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserNews the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserNews::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
