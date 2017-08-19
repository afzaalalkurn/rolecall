<?php

namespace frontend\modules\job\controllers;

use frontend\event\AutoEvent;
use Yii;
use backend\modules\job\models\JobUserMapper;
use backend\modules\job\models\search\JobUserMapper as JobUserMapperSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\modules\job\models\JobItem;
use yii\base\Event as Event;
use frontend\event\NotificationEvent;


/**
 * JobUserMapperController implements the CRUD actions for JobUserMapper model.
 */
class JobUserMapperController extends Controller
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
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all JobUserMapper models.
     * @return mixed
     */
    public function actionIndex()
    { 
        $searchModel = new JobUserMapperSearch();
        $status = Yii::$app->request->get('status');
        $user_id = Yii::$app->request->get('user_id');
        $job_id = Yii::$app->request->get('job_id');

        if(!empty($job_id)){  $searchModel->job_id = $job_id; }
        $searchModel->status = (!empty($status)) ? $status : 'Pending';
        $searchModel->user_id = (!empty($user_id)) ?$user_id : Yii::$app->user->id;

        if($status != "Passed")
        {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else if($status == "Passed"){
            $dataProviderPass = $searchModel->searchPass(Yii::$app->request->queryParams);
            $dataProviderDecline = $searchModel->searchDecline(Yii::$app->request->queryParams);
            return $this->render('passes', [
                'searchModel'  => $searchModel,
                'dataProviderPass' => $dataProviderPass,
                'dataProviderDecline' => $dataProviderDecline,
            ]);
        }
    }
 
    /**
     * Displays a single JobUserMapper model.
     * @param string $job_id
     * @param string $user_id
     * @param string $status
     * @return mixed
     */
    public function actionView($job_id, $user_id, $status)
    {
        return $this->render('view', [
            'model' => $this->findModel($job_id, $user_id, $status),
        ]);
    }

    /**
     * Creates a new JobUserMapper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      
        //if (Yii::$app->request->post())
        { 
            $model = new JobUserMapper(); 
            $model->job_id  = Yii::$app->request->get('job_id');
            $model->user_id = Yii::$app->user->id;
            $model->status  = Yii::$app->request->post('status');
            $success = false; 

            if($model->validate() && $model->save()){

                Yii::$app->modules['job']
                    ->trigger($model->status, AutoEvent::generate($model->status,$model->job_id));
                $model->refresh(); 
                $success = true;     
            } 
        }
         
        Yii::$app->response->format = 'json';   
        return [ 'success' => $success ?? false, ];
    }

    /**
     * Updates an existing JobUserMapper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $job_id
     * @param string $user_id
     * @param string $status
     * @return mixed
     */
    public function actionUpdate($job_id, $user_id, $status)
    {
        $model = $this->findModel($job_id, $user_id, $status);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'job_id' => $model->job_id, 'user_id' => $model->user_id, 'status' => $model->status]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing JobUserMapper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $job_id
     * @param string $user_id
     * @param string $status
     * @return mixed
     */
    public function actionDelete($job_id, $user_id, $status)
    {

        $this->findModel($job_id, $user_id, $status)->delete();
        Yii::$app->session->setFlash('success','Deleted! Record has been deleted successfully');
        return $this->redirect(['index', 'user_id' => $user_id, 'status' => $status]);
        

    }

    /**
     * Finds the JobUserMapper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $job_id
     * @param string $user_id
     * @param string $status
     * @return JobUserMapper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($job_id, $user_id, $status)
    {
        if (($model = JobUserMapper::findOne(['job_id' => $job_id, 'user_id' => $user_id, 'status' => $status])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
