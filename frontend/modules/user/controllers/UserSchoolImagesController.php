<?php

namespace frontend\modules\user\controllers;

use common\models\Upload;
use Yii;
use backend\modules\user\models\UserSchoolImages;
use backend\modules\user\models\search\UserSchoolImages as UserSchoolImagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * UserSchoolImagesController implements the CRUD actions for UserSchoolImages model.
 */
class UserSchoolImagesController extends Controller
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
     * Lists all UserSchoolImages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new UserSchoolImages();

        return $this->render('index', [
            'model' => $model,

        ]);
    }


    public function actionUpload(){

        $success = false;

        if (Yii::$app->request->isAjax) {

            $modelUpload = new Upload();
            $model = new UserSchoolImages();
            $modelUpload->file = UploadedFile::getInstanceByName('image');
            $model->image = $modelUpload->upload();
            $model->user_id = Yii::$app->user->id;
            if($model->save()){
                $success = true;
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => $success,];

    }

    /**
     * Displays a single UserSchoolImages model.
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
     * Creates a new UserSchoolImages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserSchoolImages();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {

            $modelUploadLogo = new Upload();
            $modelUploadLogo->file = UploadedFile::getInstance($model, 'image');
            $model->image = $modelUploadLogo->upload();
            $model->save();
            return $this->redirect(['view', 'id' => $model->image_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserSchoolImages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $modelUploadLogo = new Upload();
            $modelUploadLogo->file = UploadedFile::getInstance($model, 'image');
            $model->image = $modelUploadLogo->upload() ?? $this->findModel($id)->image;
            $model->save();

            return $this->redirect(['view', 'id' => $model->image_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserSchoolImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $success = false;
        if (Yii::$app->request->isAjax) {
            $success = $this->findModel($id)->delete();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => $success,];
    }

    /**
     * Finds the UserSchoolImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserSchoolImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserSchoolImages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
