<?php

namespace backend\modules\job\controllers;


use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use backend\modules\job\models\JobItem;
use backend\modules\job\models\search\JobItem as JobItemSearch;
use backend\modules\job\models\JobField;
use backend\modules\job\models\JobFieldOption;
use backend\modules\job\models\JobFieldValue;
use backend\modules\job\models\JobUserMapper ;
use backend\modules\job\models\search\JobUserMapper as JobUserMapperSearch;

use backend\modules\job\models\search\JobFieldValue as JobFieldValueSearch;


use common\models\Upload;
use common\models\Model;

/**
 * JobItemController implements the CRUD actions for JobItem model.
 */
class JobItemController extends Controller
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
     * Lists all JobItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobItemSearch();
        $searchModel->user_id = Yii::$app->request->get('user_id');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJobData(){

        $model = new JobItemSearch();
        $model->updateJobData();
    }

    public function actionImportData(){
        $model = new JobItemSearch();
        $model->importData();
    }

    public function actionIndexAjax()
    {
        $searchModel = new JobItemSearch();
        $searchModel->user_id = Yii::$app->request->get('user_id');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('ajax/_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single JobItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new JobFieldValueSearch();
        $searchModel->job_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $misc = $this->renderAjax('../job-field-value/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        $searchModelAppliedUser = new JobUserMapperSearch();
        $searchModelAppliedUser->job_id = $id;
        $searchModelAppliedUser->status = JobUserMapper::STATUS_APPLIED;
        $dataProviderAppliedUser = $searchModelAppliedUser->search(Yii::$app->request->queryParams);
        $appliedUser = $this->renderAjax('partial/_user', [
            'searchModel' => $searchModelAppliedUser,
            'dataProvider' => $dataProviderAppliedUser,
        ]); 

        return $this->render('view', [
            'model' => $this->findModel($id),
            'misc' => $misc,
            'user' => $appliedUser
        ]);
    }

    public function actionViewAjax($id)
    {
        $searchModel = new JobFieldValueSearch();
        $searchModel->job_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $misc = $this->renderAjax('../job-field-value/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


        return $this->renderAjax('ajax/_view', [
            'model' => $this->findModel($id),
            'misc' => $misc
        ]);
    }

    /**
     * Creates a new JobItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JobItem();
        $modelJobFields = new JobField();
        $modelJobFieldValues = [new JobFieldValue()];
        $modelJobTransaction = new JobTransaction();

        if ($model->load(Yii::$app->request->post())) {

            $model->expire_date = date('Y-d-m h:i:s', strtotime("+1 month"));
            $modelUpload = new Upload();
            $modelUpload->file = UploadedFile::getInstance($model, 'logo');
            $model->logo = $modelUpload->upload();
            $model->status = 0;
            $modelJobFieldValues = Model::createMultiple( JobFieldValue::classname() );
            Model::loadMultiple( $modelJobFieldValues, Yii::$app->request->post() );

            // validate all models
            $valid = $model->validate();

            //$valid = Model::validateMultiple($modelJobFieldValues) && $valid;

            if ($valid){

                $transaction = Yii::$app->db->beginTransaction();
                try {

                    if ( $flag = $model->save(false) ) {

                        foreach ($modelJobFieldValues as $modelJobFieldValue){

                            foreach ($modelJobFieldValues as $modelJobFieldValue){

                                $modelJobFieldValue->job_id = $model->job_id;
                                if(is_array($modelJobFieldValue->value) && count($modelJobFieldValue->value) > 0){
                                    $modelJobFieldValue->value = serialize($modelJobFieldValue->value);
                                }
                                $modelJobFieldValue->save(false);
                            }
                        }
                        
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->job_id]);
                    }

                }catch (Exception $e) {
                    $transaction->rollBack();
                }

            }
        }
        return $this->render('create', [
            'model'                 => $model,
            'modelJobFields'        => $modelJobFields,
            'modelJobFieldValues'   => $modelJobFieldValues,
        ]);

    }

    /**
     * Updates an existing JobItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model                      = $this->findModel($id);
        $modelJobFields             = new JobField();
        $modelJobFieldValues        = $model->jobFieldValues;



        if ($model->load(Yii::$app->request->post())) {
            // additional fields
            $modelJobFieldValues = Model::createMultiple(JobFieldValue::classname());
            Model::loadMultiple($modelJobFieldValues, Yii::$app->request->post());


            $valid = $model->validate();

            /********** New Code ***************/
            if ($valid){

                $transaction = Yii::$app->db->beginTransaction();
                try {

                    if ( $flag = $model->save(false) ) {

                        JobFieldValue::deleteAll(['job_id' => $model->job_id]);
                        foreach ( $modelJobFieldValues as $modelJobFieldValue ){

                            $modelJobFieldValue->job_id = $model->job_id;
                            if( is_array( $modelJobFieldValue->value ) && count( $modelJobFieldValue->value ) > 0) {

                                $modelJobFieldValue->value  = serialize($modelJobFieldValue->value);
                            }elseif(is_string($modelJobFieldValue->value)){
                                $modelJobFieldValue->job_id = $model->job_id;
                            }

                            $modelJobFieldValue->save(false);
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->job_id]);
                    }

                }catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            /********** New Code ***************/


        }

        return $this->render('update', [
            'model'                     => $model,
            'modelJobFields'            => $modelJobFields,
            'modelJobFieldValues'       => $modelJobFieldValues,
        ]);
    }


    /**
     * Updates an existing JobItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     * @return mixed
     */

    public function actionUpdateAjax($id)
    {
        $model                      = $this->findModel($id);
        $modelJobFields             = new JobField();
        $modelJobFieldValues        = $model->jobFieldValues;

        if ($model->load(Yii::$app->request->post())) {

            $modelUpload = new Upload();
            $modelUpload->file = UploadedFile::getInstance($model, 'logo');
            $model->logo = (!is_null($modelUpload->file)) ? $modelUpload->upload() : $model->getOldAttribute('logo');

            // additional fields
            $modelJobFieldValues = Model::createMultiple(JobFieldValue::classname());
            Model::loadMultiple($modelJobFieldValues, Yii::$app->request->post());

            $valid = $model->validate();

            /********** New Code ***************/
            if ($valid){

                $transaction = Yii::$app->db->beginTransaction();
                try {

                    if ( $flag = $model->save(false) ) {


                        JobFieldValue::deleteAll(['job_id' => $model->job_id]);

                        foreach ( $modelJobFieldValues as $modelJobFieldValue ){

                            $modelJobFieldValue->job_id = $model->job_id;
                            if( is_array( $modelJobFieldValue->value ) && count( $modelJobFieldValue->value ) > 0) {

                                $modelJobFieldValue->value  = serialize($modelJobFieldValue->value);
                            }elseif(is_string($modelJobFieldValue->value)){
                                $modelJobFieldValue->job_id = $model->job_id;
                            }
                            $modelJobFieldValue->save(false);
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->actionViewAjax($model->job_id);
                    }

                }catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            /********** New Code ***************/


        }

        return $this->renderAjax('update', [
            'model'                     => $model,
            'modelJobFields'            => $modelJobFields,
            'modelJobFieldValues'       => $modelJobFieldValues,
        ]);
    }






    /**
     * Deletes an existing JobItem model.
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
     * Deletes an existing JobItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDeleteAjax($id)
    {
        $this->findModel($id)->delete();

        return $this->actionIndexAjax();
    }

    /**
     * Finds the JobItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return JobItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JobItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
