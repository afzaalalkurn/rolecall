<?php

namespace frontend\modules\user\controllers;

use common\models\Upload;
use Yii;
use backend\modules\user\models\UserAds;
use backend\modules\user\models\search\UserAds as UserAdsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UserAdsController implements the CRUD actions for UserAds model.
 */
class UserAdsController extends Controller
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
     * Lists all UserAds models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserAdsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserAds model.
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
     * Creates a new UserAds model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserAds();
        $model->user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post())) {

            $modelUpload = new Upload();
            $modelUpload->file = UploadedFile::getInstance($model, 'image');
            $model->status = 0;
            $model->image = $modelUpload->upload();
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->ad_id]);
            }else{
                pr($model->getErrors());
            }


        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserAds model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {

            $modelUpload = new Upload();
            $modelUpload->file = UploadedFile::getInstance($model, 'image');
            $model->image = (!is_null($modelUpload->file)) ? $modelUpload->upload() : $model->getOldAttribute('image');
            $model->status = 0;
            $model->save();

            return $this->redirect(['view', 'id' => $model->ad_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserAds model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionRemove($id)
    {

        $model = $this->findModel($id);

        if ($model->load( Yii::$app->request->post() ) && $model->save()) {
            return $this->renderPartial('partial/_success', ['msg' => 'Your request successfully send to admin',]);
        }

        return $this->renderAjax('request', ['model' => $model,]);
    }

    /**
     * Finds the UserAds model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserAds the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserAds::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
