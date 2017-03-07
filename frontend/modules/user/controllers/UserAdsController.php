<?php

namespace frontend\modules\user\controllers;

use backend\modules\user\models\UserTransaction;
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
        $searchModel->user_id = Yii::$app->user->getId();
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
        $model                  = new UserAds();
        $modelUserTransaction   = new UserTransaction();
        $model->user_id = Yii::$app->user->id;
        $modelUserTransaction->user_id = Yii::$app->user->id;
        if ( $modelUserTransaction->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post()) && $modelUserTransaction->save() ) {
            $model->transaction_id = $modelUserTransaction->id ;

            $modelUpload = new Upload();
            $modelUpload->file = UploadedFile::getInstance($model, 'image');
            $model->status = 0;
            $model->image = $modelUpload->upload();
            $model->save();

            return $this->redirect(['view', 'id' => $model->ad_id]);

        } else {


            return $this->render('create', ['model' => $model,
                'modelUserTransaction' => $modelUserTransaction  ]);
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

        if ($model->load( Yii::$app->request->post() )) {
            $model->request_remove = 1;
            $model->save();
            return $this->renderPartial('partial/_success', ['msg' => 'Your request successfully send to admin',]);
        }

        return $this->renderAjax('request', ['model' => $model,]);
    }

    public function actionRenew($id)
    {

        $modelUserTransaction = new UserTransaction();
        if ($modelUserTransaction->load( Yii::$app->request->post())) {
            $modelUserTransaction->user_id = Yii::$app->user->id;
            if($modelUserTransaction->save()){
                $model = $this->findModel($id);
                $model->transaction_id = $modelUserTransaction->id;
                if($model->save()){
                    return $this->renderPartial('partial/_success', ['msg' => 'Your payment successfully done.',]);
                }
            }
        }

        return $this->renderAjax('renew', ['model' => $modelUserTransaction,]);
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
