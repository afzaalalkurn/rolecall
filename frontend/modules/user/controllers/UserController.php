<?php

namespace frontend\modules\user\controllers;

use backend\modules\user\models\search\UserField;
use backend\modules\user\models\UserAddress;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Upload;
use backend\modules\user\models\UserFieldValue;
use common\models\Model;
use common\models\User as CommonUser;
use backend\modules\user\models\User;
use backend\modules\user\models\UserSocial;
use backend\modules\user\models\UserTransaction;
use backend\modules\job\models\search\JobUserMapper;
use frontend\components\Paypal;
use backend\modules\core\models\CorePlan;
use backend\modules\user\models\UserProfile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if( isset(Yii::$app->user->id) ){
            $tpls  =  ( Yii::$app->user->identity->isDirector() ) ? $this->_ownerButtons() : $this->_userButtons();

            //$tpls  =  array_merge( $tpls, $this->_commonButtons() );
            
        }else{
            $tpls[]  =  $this->_guestButtons();
        }
       return $this->renderAjax('view', [
            'model' => $this->findModel(),
            'tpls' => $tpls,
        ]);
    }

    public function actionArchive()
    {
        if( isset(Yii::$app->user->id) ){
            $tpls  =  ( Yii::$app->user->identity->isDirector() ) ? $this->_ownerButtons() : $this->_userButtons();

            //$tpls  =  array_merge( $tpls, $this->_commonButtons() );

        }else{
            $tpls[]  =  $this->_guestButtons();
        }
        return $this->renderAjax('view', [
            'model' => $this->findModel(),
            'tpls' => $tpls,
        ]);
        return $this->render('archive');
    }

     public function actionTalents(){
        
        $searchModel = new Talents(); 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('talents', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider, 
        ]);
    }


    public function actionJobTalents($status){
        $status = Yii::$app->request->get('status');
        $job_id = Yii::$app->request->get('id');
        $searchModel = new JobUserMapper();
        $searchModel->status = Yii::$app->request->get('status');
        $searchModel->job_id = Yii::$app->request->get('id');
        $dataProvider = $searchModel->searchJobUser(Yii::$app->request->queryParams);

        return $this->render('talents', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'status'        => $status,
            'id'        => $job_id,
        ]);

    }

    public function actionView(){
       $user_id = Yii::$app->request->get('user_id') ?? Yii::$app->user->id ;
       $job_id = Yii::$app->request->get('job_id');

       $model   =   $this->findModel($user_id);
       $role    =   $model->getRoleName();

       return $this->render('partial/_profile-' . strtolower($role), [
            'model'     => $model,
            'role'      => $role,
            'job_id'    => $job_id,
            'sections'  => $this->_userFields($model),
        ]);
    }


    protected function _commonButtons(){
        $links  =   [
                        'Change Password'   => Url::to(['/change-password']),
                        'Update'            => Url::to(['/update']),
                        'Profile'           => ( Yii::$app->user->identity->isDirector() ) ? Url::to(['/user/user/view']) : Url::to(['/user/user/view']),
                        'User Message'      => Url::to(['/user/user-msg'])
                    ];

        foreach ($links as $name => $path){

            $tpls[] = [ 
                        'item'      => $name,
                        'title'     => $name,
                        'path'      => $path,
                        'id'        => str_replace(' ' ,'-', $name),
                        'class'     => 'btn owner-button btn-'.strtolower(str_replace(' ' ,'-', $name)),
                    ];     
        } 

        return $tpls;

    }



    protected function _ownerButtons($job_id = null){
        
        $tpls   = [];
        if( empty($job_id) ){

            $links  =   [
                'Start New Rolecall'       => Url::to(['/job/job-item/create']),
                /*'Talent Messages'    => Url::to(['/user/user-msg/index'])*/
            ];

        }
        else{
            $links  =   [
                'Banner'              => Url::to(['/user/user-ads/']),
                'My Jobs'             => Url::to(['/my-jobs']),
            ];
        }

                    
        foreach ($links as $name => $path) { 

            $tpls[] = [ 
                            'item'      => $name,
                            'title'     => $name,
                            'path'      => $path,
                            'id'        => str_replace(' ' ,'-', $name),
                            'class'     => 'btn owner-button btn-'.strtolower(str_replace(' ' ,'-', $name)),
                    ];
        }
        return $tpls;

    }

    protected function _userButtons(){

        $tpls = [];
        foreach (['Applied' => 'Applied Jobs','Favorite' => 'Favorite Jobs','Saved' => 'Saved Jobs'] as $status => $name ) {

        $tpls[] =   [
                        'item'  => $status,
                        'title' => $name,
                        'id' => 'status-' . $status,
                        'path' => Url::to(['/job/job-user-mapper/index', 'user_id' => Yii::$app->user->id, 'status' => $status]),
                        'class' => 'btn user-mapper btn-'.strtolower($status),
                    ];
        }        

        return $tpls;
    }

    public function actionExecuteAgreement(){

        $agreement = Yii::$app->paypal->executeAgreement();
        $plan = $agreement->getPlan();

        $model = new \backend\modules\user\models\UserTransaction();
        $model->user_id = Yii::$app->user->id;
        $model->agreement_id = $agreement->getId();
        $model->first_name = $agreement->getPayer()->getPayerInfo()->getFirstName();
        $model->last_name = $agreement->getPayer()->getPayerInfo()->getLastName();
        $model->email = $agreement->getPayer()->getPayerInfo()->getEmail();
        $model->response_data = $agreement->toJSON();
        $model->state = $agreement->getState();
        $model->created_at = time();
        $model->updated_at = time();

        if(isset($agreement->plan->payment_definitions[0]) ){
            $plan  = $agreement->plan->payment_definitions[0];
            $modelPlan = CorePlan::findOne(['payment_type' => $plan->type, 'frequency'=> $plan->frequency, 'amount'=>$plan->amount->value,'cycles'=>$plan->cycles, 'frequency_interval'=>$plan->frequency_interval]);
        } 

        $plan_id = $modelPlan->id;
        $model->plan_id = $plan_id;

        if ( $model->save() ) {

            $userProfile = UserProfile::findOne(Yii::$app->user->id);
            $userProfile->transaction_id = $model->id;
            $userProfile->plan_id = $plan_id;
            $userProfile->update(false);

            Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');

            return $this->redirect('/dashboard');

        }

    }

    /* upgrade */

    public function actionUpgrade($id)
    {
        $modelTransaction = new \frontend\models\UserTransaction();

        if ($modelTransaction->load(Yii::$app->request->post()) && $modelTransaction->validate()){
            Yii::$app->paypal->payNow($modelTransaction);
        }

        return $this->renderAjax('upgrade', [ 'modelTransaction' => $modelTransaction]);

    }


    /* upgrade */

   /* public function actionUpgrade($id)
    {

        $modelTransaction = new UserTransaction();
        $payPal = new Paypal();
        $model = $this->findModel($id)->userProfile;
        if ($modelTransaction->load( Yii::$app->request->post()) && $model->load( Yii::$app->request->post())){
            $modelTransaction->user_id = Yii::$app->user->id;
            $agremment = Yii::$app->paypal->payNow($model);
            //$agremment = $payPal->payNow($model);
            if($modelTransaction->save() && $model->save()){
                return $this->redirect(['view']);
            }
        }

        return $this->renderAjax('upgrade', [ 'modelTransaction' => $modelTransaction, 'model' => $model]);

    }*/



    /**
     * Updates an existing USER model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model                      = $this->findModel();
        $modelUserFields            = new UserField();
        $modelUserFieldValues       = $model->userFieldValues;
        $modelUserProfile           = $model->userProfile;
        $modelUserAddress           = $model->userAddress;

        if(!$modelUserAddress){
            $modelUserAddress = new UserAddress();
        }

        /*$modelsUserSocial = [new UserSocial];

        if($model->userSocials && count($model->userSocials) > 0){
            foreach($model->userSocials as $modelUserSocial)
                $modelsUserSocial[$modelUserSocial->network_id]  = $modelUserSocial;
        }*/

        if ($model->load(Yii::$app->request->post())) {

            $valid = $model->validate();

            /********** New Code ***************/
            if ($valid){

                $transaction = Yii::$app->db->beginTransaction();
                try {

                        if ( $flag = $model->save(false) ) {

                            if($modelUserProfile->load(Yii::$app->request->post())){

                                $modelUserProfile->gender = $modelUserProfile->gender != '' ? $modelUserProfile->gender :'None';
                                $modelUserProfile->dob = $modelUserProfile->dob != '' ? Yii::$app->formatter->asDate($modelUserProfile->dob, 'php:Y-m-d H:i:s') : '';

                                $modelUpload = new Upload();
                                $modelUpload->file = UploadedFile::getInstance($modelUserProfile, 'avatar');
                                $modelUserProfile->avatar = (!is_null($modelUpload->file))
                                    ? $modelUpload->upload() : $modelUserProfile->getOldAttribute('avatar');
                                $modelUserProfile->save(false);
                            }

                            if($modelUserAddress->load(Yii::$app->request->post())){
                                $address = $modelUserAddress->location;
                                $prepAddr = str_replace(' ','+',$address);
                                $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
                                $output= json_decode($geocode);
                                if($output->status == "OK") {
                                    $latitude = $output->results[0]->geometry->location->lat;
                                    $longitude = $output->results[0]->geometry->location->lng;
                                    $modelUserAddress->longitude = $longitude;
                                    $modelUserAddress->latitude = $latitude;
                                }
                                $modelUserAddress->save(false);
                            }

                            // user social
                            /*if(Yii::$app->request->post('UserSocial')){
                                UserSocial::deleteAll(['user_id' => $model->id]);
                                foreach (Yii::$app->request->post('UserSocial') as $i => $dataUserSocial) {
                                    $modelUserSocial = new UserSocial();
                                    if (!empty($dataUserSocial)) {
                                        $modelUserSocial->load($dataUserSocial, '');
                                        if(!empty($modelUserSocial->network_id) && !empty($modelUserSocial->link)){
                                            $modelUserSocial->user_id = $model->id;
                                            $modelUserSocial->save();
                                        }
                                    }
                                }
                            }*/

                            // additional fields
                            $modelUserFieldValues = Model::createMultiple(UserFieldValue::classname());
                            Model::loadMultiple($modelUserFieldValues, Yii::$app->request->post());
                            UserFieldValue::deleteAll(['user_id' => $model->id]);
                            foreach ( $modelUserFieldValues as $modelUserFieldValue ){
                                $modelUserFieldValue->user_id = $model->id;
                                switch ($modelUserFieldValue->field->type){
                                    case 'Text':
                                    case 'TextArea':
                                    case 'Radio':
                                    case 'List':
                                    case 'DatePicker':
                                        $modelUserFieldValue->save(false);
                                    break;
                                    case 'MultiList':
                                        if( is_array( $modelUserFieldValue->value ) && count( $modelUserFieldValue->value ) > 0) {
                                            if($modelUserFieldValue->field->is_serialize == 1){
                                                $modelUserFieldValue->value  = serialize($modelUserFieldValue->value);
                                                $modelUserFieldValue->save(false);
                                            }else{
                                                foreach($modelUserFieldValue->value as $value){
                                                    $modelUserFieldValueEach = new UserFieldValue();
                                                    $modelUserFieldValueEach->user_id = $modelUserFieldValue->user_id;
                                                    $modelUserFieldValueEach->field_id = $modelUserFieldValue->field_id;
                                                    $modelUserFieldValueEach->value = $value;
                                                    $modelUserFieldValueEach->save(false);
                                                }
                                            }
                                        }
                                        break;
                                    case 'File':
                                    foreach(Yii::$app->request->post('UserFieldValue') as $fieldID => $fv){

                                        if($fv['field_id'] == $modelUserFieldValue->field_id){

                                            $modelUpload = new Upload();
                                            $modelUpload->file = UploadedFile::getInstanceByName('UserFieldValue['.$fieldID.'][value]');

                                            $modelUserFieldValue->value =
                                                (!is_null($modelUpload->file)) ?
                                                    $modelUpload->upload() :
                                                    $this->_userFile($model->userFieldValues,  $modelUserFieldValue->field_id);
                                            $modelUserFieldValue->save(false);

                                            if(isset($fv['image_data'])){
                                                $imageData = json_decode($fv['image_data']);
                                                $modelUserFieldValue->value = $modelUpload->crop($modelUserFieldValue->value, $imageData);
                                            }


                                        }
                                    }
                                    break;
                                }
                        }

                if ($flag) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success',
                        'Your profile has been updated successfully.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                        }

                }catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            /********** New Code ***************/
        }

        return $this->render('update', [
            'model'                     => $model,
            'modelUserFields'           => $modelUserFields,
            'modelUserFieldValues'      => $modelUserFieldValues,
            'modelUserProfile'          => $modelUserProfile,
            'modelUserAddress'          => $modelUserAddress,
        ]);
    }

    protected function _userFile($userFieldValues, $field_id){

        $value = null;
        foreach($userFieldValues as $userFieldValue){

            if($userFieldValue->field_id == $field_id){
                $value = $userFieldValue->value;
            }
        }
        return $value;

    }


    protected function _userFields($model){

        $fields = [];
        $role = strtolower(Yii::$app->user->identity->getRoleName());
        foreach ($model->userFieldValues as $i => $userFieldValue){
            if(!empty($userFieldValue->value)){
                if($role == "user")
                {
                    if(!in_array($userFieldValue->field->field, ['role-type'])){
                        $fields[$userFieldValue->field->layout][$userFieldValue->field->field] = $userFieldValue;
                    }
                }
                else{
                    $fields[$userFieldValue->field->layout][$userFieldValue->field->field] = $userFieldValue;
                }
            }
        }
        return $fields;
    }



    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id = null)
    {

        if($id == null || empty($id)){
            $id = Yii::$app->user->getId();
        }

        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}

