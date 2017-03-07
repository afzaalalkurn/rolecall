<?php

namespace backend\modules\core\controllers;

use common\models\Upload;
use Yii;
use backend\modules\core\models\CoreSocialNetwork;
use backend\modules\core\models\search\CoreSocialNetwork as CoreSocialNetworkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CoreSocialNetworkController implements the CRUD actions for CoreSocialNetwork model.
 */
class CoreSocialNetworkController extends Controller
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
     * Lists all CoreSocialNetwork models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoreSocialNetworkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CoreSocialNetwork model.
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
     * Creates a new CoreSocialNetwork model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CoreSocialNetwork();

        if ($model->load(Yii::$app->request->post())) {

            $modelUpload = new Upload() ;
            if($modelUpload->file = UploadedFile::getInstance($model, 'icons')){
                    $model->icons = $modelUpload->upload();
            }
            if($modelUpload->file = UploadedFile::getInstance($model, 'image')){
                $model->image = $modelUpload->upload();
            }
            if($modelUpload->file = UploadedFile::getInstance($model, 'thumb')){
                $model->thumb = $modelUpload->upload();
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
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
     * Updates an existing CoreSocialNetwork model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $modelUpload = new Upload() ;
            if($modelUpload->file = UploadedFile::getInstance($model, 'icons')){
                $model->icons = $modelUpload->upload();
            }
            if($modelUpload->file = UploadedFile::getInstance($model, 'image')){
                $model->image = $modelUpload->upload();
            }
            if($modelUpload->file = UploadedFile::getInstance($model, 'thumb')){
                $model->thumb = $modelUpload->upload();
            }

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                pr($model->getErrors());
            }


        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CoreSocialNetwork model.
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
     * Finds the CoreSocialNetwork model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CoreSocialNetwork the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CoreSocialNetwork::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
