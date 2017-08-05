<?php
namespace frontend\modules\job\controllers;

use Yii;

use backend\modules\job\models\JobItem;
use backend\modules\job\models\JobCategoryMapper;
use backend\modules\job\models\search\JobItem as JobItemSearch;
use backend\modules\job\models\JobField;
use backend\modules\job\models\JobFieldValue;
use backend\modules\job\models\JobUserMapper;
use backend\modules\user\models\UserTransaction;
use backend\modules\user\models\UserField;

use yii\web\Response;

use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Upload;
use backend\modules\user\models\search\UserSchool as UserSchoolSearch;
use common\models\Model;
use frontend\event\AutoEvent;
use backend\modules\user\models\search\Talent;

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
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    /**
     * Lists all JobItem models.
     * 
     * @return mixed
     */
    public function actionIndex(){
        $tpls = [];

        $searchModel = new JobItemSearch();
        if(isset(Yii::$app->user->id) && Yii::$app->user->identity->isDirector() ){
           //$searchModel->user_id = Yii::$app->user->id;
           $tpls  = $this->_ownerButtons();
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $modelJobField = new JobField();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelJobFields' => $modelJobField,
            'tpls' => $tpls
        ]);

    }




    public function actionMyJobs(){
        $tpls = [];
        $searchModel = new JobItemSearch(); 

        if(isset(Yii::$app->user->id) && Yii::$app->user->identity->isDirector() ){
            $searchModel->user_id = Yii::$app->user->id;
            $tpls  = $this->_ownerButtons();
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modelJobField = new JobField();


        return $this->render('index', [
            'searchModel' => $searchModel, 
            'dataProvider' => $dataProvider,
            'modelJobFields' => $modelJobField,
            'tpls' => $tpls,
            'dashboardBreadcrumb' => ['label' => 'Dashboard', 'url' => ['/dashboard']]
        ]);
    }


    
    /**
     * Displays a single JobItem model.
     * 
     * @param string $id            
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $tpls = [];

        if( isset(Yii::$app->user->id) ){
            $tpls  =  ( Yii::$app->user->identity->isDirector() && Yii::$app->user->id == $model->user_id ) ? $this->_ownerButtons($id) : $this->_userButtons($id);
        }
        else{
            $tpls[]  = $this->_guestButtons($id);
        }

        return $this->render('view', [
            'model'  =>  $model,
            'tpls'   =>  $tpls ,
            'job_id' =>  $id,
            'sections' => $this->_jobFields($model),
            'gender' => $this->_findGender($model),
        ]);

    }

    protected function _findGender($model){

        $gender = '';
        foreach ($model->jobFieldValues as $i => $jobFieldValue){
            if(!empty($jobFieldValue->value) && $jobFieldValue->field->field == 'gender'){
                 $gender = $jobFieldValue->value;
                 break;
            }
        }
        return $gender;
    }

    protected function _jobFields($model){

        $fields = [];
        foreach ($model->jobFieldValues as $i => $jobFieldValue){
            if(!empty($jobFieldValue->value)){
                $fields[$jobFieldValue->field->layout][$jobFieldValue->field->field] = $jobFieldValue;
            }
        }
        return $fields;
    }

    protected function _guestButtons($id){             
               
        $model = $this->findModel($id);
        
        $tpl = [];
        if($model->user){

            $tpl = [
                'item'  =>  'Visit',
                'title' =>  'Director\'s Profile',
                'id'    =>  'status-Visit',
                'path'  =>  Url::to(['/user/user/view', 'user_id' => $model->user_id]),
                'class' =>  'btn btn-primary owner-button visit-director-btn',
            ];
        }
        
        return $tpl;

    }


    protected function _applyButtons($job_id){

        $tpl = [];

        if ( ($model = JobUserMapper::findOne(['job_id' => $job_id, 'user_id' => Yii::$app->user->id])) === null) {

            $tpl = [
                'item'  => 'Applied',
                'title' => 'Apply Now',
                'id' => 'status-Applied' ,
                'path' => Url::to(['/job/job-user-mapper/create', 'job_id' => $job_id, 'status' => 'Applied']),
                'class' => 'btn btn-primary user-mapper Applied',
            ];
        }

        return $tpl;

    }
    protected function _userButtons($job_id){

        //$tpls[] = $this->_guestButtons($job_id);
        $tpls = [];
        foreach ([/*'Favorite' => 'Mark Favorite',*/
                     /*'Saved' => 'Save It',*/
                     /*'Accept' => 'Accept',
                     'Decline' => 'Decline',*/
                     ] as $status => $name ) {

            if ( ($model = JobUserMapper::findOne(['job_id' => $job_id, 'user_id' => Yii::$app->user->id, 'status' => $status])) === null) {  
               
                $tpls[] = [
                            'item'  => $status,
                            'title' => $name,
                            'id' => 'status-' . $status,
                            'path' => Url::to(['/job/job-user-mapper/create', 'job_id' => $job_id, 'status' => $status]),
                            'class' => 'btn btn-primary user-mapper '.$status.'',
                         ];
                }   
        }

        //$tpls[] = $this->_applyButtons($job_id);
        return $tpls;

    }

    

    protected function _ownerButtons($job_id = null){
        
        $tpls  =  [];
        if( empty($job_id) ){

             $links  =   [
                            'Create Rolecall'       => Url::to(['create']),
                            /*'Talent Messages'    => Url::to(['/user/user-msg/index'])*/
                         ]; 

        }else{
             $links  =   [
                            'Edit'            => Url::to(['update', 'id' => $job_id]),
                            /*'Find Talents'      => Url::to(['talents', 'id' => $job_id]),
                            'Applied Talent'     => Url::to(['/job/job-user-mapper', 'job_id' => $job_id, 'status'=>'Applied']),*/
                 /*'Pending Request'     => Url::to(['/job/job-user-mapper', 'job_id' => $job_id, 'status'=>'Pending']),
                 'Approved Talent'     => Url::to(['/job/job-user-mapper', 'job_id' => $job_id, 'status'=>'Approved']),*/

                         ];

        }

       
        foreach ($links as $name => $path) { 

            $tpls[] = [ 
                        'item'      => $name,
                        'title'     => $name,
                        'path'      => $path,
                        'id'        => str_replace(' ' ,'-', $name),
                        'class'     => 'btn btn-primary owner-button',
                      ];
        }

        return $tpls;

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

        if ($model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->id;
            $model->create_dated = Yii::$app->formatter->asDate($model->create_dated, 'php:Y-m-d');
            $model->expire_date = Yii::$app->formatter->asDate($model->expire_date, 'php:Y-m-d');

            $modelUpload = new Upload();
            $modelUpload->file = UploadedFile::getInstance($model, 'logo');
            $model->logo = $modelUpload->upload();
            $model->status = 0;

            $address = $model->location;
            $prepAddr = str_replace(' ','+',$address);
            $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
            $output= json_decode($geocode);
            if($output->status == "OK") {
                $latitude = $output->results[0]->geometry->location->lat;
                $longitude = $output->results[0]->geometry->location->lng;
                $model->longitude = $longitude;
                $model->latitude = $latitude;
            }
            $modelJobFieldValues = Model::createMultiple(JobFieldValue::classname());
            Model::loadMultiple($modelJobFieldValues, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            if ($valid){
                $transaction = Yii::$app->db->beginTransaction();
                try {
                        if ( $flag = $model->save(false) ) {
                            /*$modelCategoryMapper = new JobCategoryMapper();
                            $modelCategoryMapper->category_id = 1;
                            $modelCategoryMapper->job_id = $model->job_id;
                            $modelCategoryMapper->save();*/
                            foreach ($modelJobFieldValues as $modelJobFieldValue){
                                $modelJobFieldValue->job_id = $model->job_id;
                                if( is_array( $modelJobFieldValue->value ) && count( $modelJobFieldValue->value ) > 0) {
                                    $modelJobFieldValue->value  = serialize($modelJobFieldValue->value);
                                }
                                $modelJobFieldValue->save(false);
                            }
                        }
                        if ($flag) {

                            Yii::$app->modules['job']
                                ->trigger('Job', AutoEvent::generate( 'Rolecall', $model->job_id ));

                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Successfully posted Rolecall.');
                            return $this->redirect(['talents', 'id' => $model->job_id]);

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

    public function actionTalents($id)
    {
        $model = $this->findModel($id); 

        $tpls = [];

        if( isset(Yii::$app->user->id) ){
            $tpls  =  ( Yii::$app->user->identity->isDirector()
                && Yii::$app->user->id == $model->user_id )
                ? $this->_ownerButtons($id) : $this->_userButtons($id);
        }else{
            $tpls[]  = $this->_guestButtons($id);
        }

        $searchModel = new Talent();
        $searchModel->job_id = $id;
        $searchModel->latitude = $model->latitude;
        $searchModel->longitude = $model->longitude;
        $searchModel->radius = $model->radius;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modelUserFields = new UserField(); 

        return $this->render('talent', [
            'model'  =>  $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelUserFields' => $modelUserFields,
            'tpls'   =>  $tpls ,
            'job_id' =>  $id,
        ]);

    }
    public function actionTalentStatus($status)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user_id = Yii::$app->request->post('user_id');
        $job_id  = Yii::$app->request->post('job_id');
        $modelJobUserMapper = JobUserMapper::findOne([
            'user_id'=>$user_id,
            'job_id'=>$job_id,
            'status'=>$status
        ]);

        if($modelJobUserMapper){
            return ['code' => 'failed','msg' => 'Your request already exist.'];
        }

        $modelJobItem = $this->findModel($job_id);
        $modelTalent = Talent::findOne($user_id);
        if(!$modelTalent){
            return ['code' => 'failed','msg' => 'User not exist.'];
        }

        if(!$modelJobItem){
            return ['code' => 'failed','msg' => 'Job not exist.'];
        }


        $modelJobUserMapper = JobUserMapper::findOne([
            'user_id'=>$user_id,
            'job_id'=>$job_id
        ]);

        if($modelJobUserMapper)
        {
            $modelJobUserMapper->status = $status;
        }
        else if($status == "Pending" || $status == "Passed")
        {
            $modelJobUserMapper = new JobUserMapper();
            $modelJobUserMapper->user_id = $user_id;
            $modelJobUserMapper->job_id = $job_id;
            $modelJobUserMapper->status = $status;
        }
        $notifyStatus = ($status == "Pending") ? 'Selected' : $status;

        if($modelJobUserMapper->save()){

            Yii::$app->modules['job']->trigger('Job',
                AutoEvent::getNotify( $notifyStatus ,
                    $modelJobUserMapper->job_id,$user_id));

            switch($status)
            {
                case "Pending":
                $msg = 'Your request Pending for approval.';
                break;

                case "Passed":
                $msg = 'You Passed the talent.';
                break;

                case "Booked":
                $msg = 'You Booked the talent.';
                break;

                case "Approved":
                $msg = 'You Approved the Rolecall request.';
                break;

                case "Declined":
                $msg = 'You Declined the Rolecall request.';
                break;
            }
            return ['code' => 'success','user' =>
                $modelTalent->userProfile->getName(),
                'job'=>$modelJobItem->name,
                'msg'=> $msg];
        }

        return ['code' => 'failed','msg'=>'Please try again later'];

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

        if ($model->load(Yii::$app->request->post()) ) {

            $model->create_dated = Yii::$app->formatter->asDate($model->create_dated, 'php:Y-m-d');
            $model->expire_date = Yii::$app->formatter->asDate($model->expire_date, 'php:Y-m-d');

            $modelUpload = new Upload();
            $modelUpload->file = UploadedFile::getInstance($model, 'logo');
            $model->logo = (!is_null($modelUpload->file)) ? $modelUpload->upload() : $model->getOldAttribute('logo');

            $address = $model->location;
            $prepAddr = str_replace(' ','+',$address);
            $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
            $output= json_decode($geocode);
            if($output->status == "OK") {
                $latitude = $output->results[0]->geometry->location->lat;
                $longitude = $output->results[0]->geometry->location->lng;
                $model->longitude = $longitude;
                $model->latitude = $latitude;
            }

            // additional fields
            $modelJobFieldValues = Model::createMultiple(JobFieldValue::classname());
            Model::loadMultiple($modelJobFieldValues, Yii::$app->request->post());

            $valid = $model->validate();

            /********** New Code ***************/
            if ($valid){
                $transaction = Yii::$app->db->beginTransaction();
                try {
                   if ( $flag = $model->save(false) ) {
                        JobFieldValue::deleteAll(
                            ['job_id' => $model->job_id]
                        );
                    /*foreach ( $modelJobFieldValues as $modelJobFieldValue ){
                        $modelJobFieldValue->job_id = $model->job_id;
                        if( is_array( $modelJobFieldValue->value )
                            && count( $modelJobFieldValue->value ) > 0
                        ) {
                            $modelJobFieldValue->value  =
                                serialize($modelJobFieldValue->value);
                        }
                        $modelJobFieldValue->save(false);
                    }*/

                       foreach ( $modelJobFieldValues as $modelJobFieldValue ){
                           $modelJobFieldValue->job_id = $model->job_id;
                           switch ($modelJobFieldValue->field->type){
                               case 'Text':
                               case 'TextArea':
                               case 'Radio':
                               case 'List':
                               case 'DropdownRange':
                               case 'TextRange':
                               case 'DatePicker':
                               $modelJobFieldValue->save(false);
                                   break;
                               case 'MultiList':
                                   if( is_array( $modelJobFieldValue->value ) && count( $modelJobFieldValue->value ) > 0) {
                                       if($modelJobFieldValue->field->is_serialize == 1){
                                           $modelJobFieldValue->value  = serialize($modelJobFieldValue->value);
                                           $modelJobFieldValue->save(false);
                                       }else{
                                           foreach($modelJobFieldValue->value as $value){
                                               $modelUserFieldValueEach = new JobFieldValue();
                                               $modelUserFieldValueEach->job_id = $modelJobFieldValue->job_id;
                                               $modelUserFieldValueEach->field_id = $modelJobFieldValue->field_id;
                                               $modelUserFieldValueEach->value = $value;
                                               $modelUserFieldValueEach->save(false);
                                           }
                                       }
                                   }
                                   break;
                               case 'File':

                                   foreach(Yii::$app->request->post('UserFieldValue') as $fieldID => $fv){

                                       if($fv['field_id'] == $modelJobFieldValue->field_id){


                                           $modelUpload = new Upload();
                                           $modelUpload->file = UploadedFile::getInstanceByName('UserFieldValue['.$fieldID.'][value]');
                                           $modelJobFieldValue->value = (!is_null($modelUpload->file)) ? $modelUpload->upload() :   $this->_userFile($model->userFieldValues, $modelJobFieldValue->field_id);
                                           $modelJobFieldValue->save(false);

                                       }
                                   }
                                   break;
                           }
                       }

                    }
        if ($flag) {
            Yii::$app->modules['job']->trigger('Job', AutoEvent::generate('updated Rolecall',$model->job_id));
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

    protected function _categoriesSave($job_id, $categories)
    {
        if ( $categories && !empty($job_id) ) {
            
            JobCategoryMapper::deleteAll([
                            'job_id' => $model->job_id
                        ]);

            foreach($categories as $category_id){
                $modelCategoryMapper = new JobCategoryMapper();
                $modelCategoryMapper->job_id = $job_id;
                $modelCategoryMapper->category_id = $category_id;
                $modelCategoryMapper->save(false);
            }
            return true;
        }
        return false; 
    }
    
    public function actionUsers($id){
        
        $model = $this->findModel($id);
        $modelUsers = $model->getJobUserMappers()->all(); 
        return $this->render('users', [
            'model' => $model,
            'modelUsers' => $modelUsers,
        ]);
    }

    /**
     * Deletes an existing JobItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * 
     * @param string $id            
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect([
            'index'
        ]);
    }

    public function actionTrascation(){

        $model = new UserTransaction();

        $job_id    = Yii::$app->request->get('job_id');
        if ( $model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->id;

            if($model->validate() && $model->save()){
                $modelJob = $this->findModel($job_id);
                $modelJob->is_featured = 1;
                if($modelJob->save(false)){
                    return $this->renderPartial('partial/_success');
                }
            }


        }

        return $this->renderAjax('transaction', [
            'model'     => $model,
            'job_id'    => Yii::$app->request->get('job_id'),
        ]);
    }


    public function actionArchive()
    {
        return $this->render('archive');
    }

    /**
     * Finds the JobItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param string $id            
     * @return JobItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = JobItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
