<?php

namespace backend\modules\user\controllers;

use Yii;
use backend\modules\user\models\User;
use backend\modules\user\models\search\Talent;
use backend\modules\user\models\search\UserField;
use backend\modules\user\models\UserAddress;
use backend\modules\user\models\UserProfile;
use backend\modules\user\models\UserInstruments;
use common\models\Upload;
use common\models\User as CommonUser;
use yii\web\UploadedFile;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeacherController implements the CRUD actions for User model.
 */
class TalentController extends Controller
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
        $searchModel = new Talent();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    protected function _assignAuth($user_id, $role){
        // the following three lines were added:
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole($role);

        if( $auth->assign($authorRole, $user_id) ){
            return true;
        }

        throw new HttpException(405, 'Error saving model authorRole');

    }

    protected function _profile($user_id){

        $model = new UserProfile();
        $model->user_id = $user_id;
        $model->save();
    }

    protected function _address($user_id){

        $model = new UserAddress();
        $model->user_id = $user_id;
        $model->save();
    }

    protected function _signup($model)
    {
        $user = CommonUser::findIdentity($model->id);
        $user->username = $model->username;
        $user->email = $model->email;
        if(!empty($model->password)){
            $user->setPassword($model->password);
        }

        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUserFields            = new UserField();
        $modelUserFieldValues       = $model->userFieldValues;
        $modelUserAddress = $model->userAddress ?? new UserAddress;
        $modelUserProfile = $model->userProfile ?? new UserProfile;
        $modelUserInstruments = $model->userInstruments ?? new UserInstruments;



        if (
            $model->load(Yii::$app->request->post()) &&
            $modelUserProfile->load(Yii::$app->request->post()) &&
            $modelUserAddress->load(Yii::$app->request->post()) &&
            $modelUserInstruments->load(Yii::$app->request->post())
        ){
            if($model->validate() && $model = $this->_signup($model)){

                $modelUserInstruments->user_id = $model->id;
                if( $modelUserInstruments->validate()) {
                    $modelUserInstruments->save();
                }

                if( $modelUserProfile->validate()) {
                    $modelUserProfile->user_id = $model->id;

                    $modelUserProfile->dob = date('Y-m-d', strtotime($modelUserProfile->dob));
                    $modelUpload = new Upload();
                    $modelUpload->file = UploadedFile::getInstance($modelUserProfile, 'avatar');
                    $modelUserProfile->avatar = (!is_null($modelUpload->file)) ? $modelUpload->upload() : $modelUserProfile->oldAttributes['avatar'];

                    $modelUpload = new Upload();
                    $modelUpload->file = UploadedFile::getInstance($modelUserProfile, 'cover_photo');
                    $modelUserProfile->cover_photo = (!is_null($modelUpload->file)) ? $modelUpload->upload() :
                        $modelUserProfile->oldAttributes['cover_photo'];
                    $modelUserProfile->save();
                }

                $modelUserAddress->user_id = $model->id;
                if($modelUserAddress->validate()) {
                    $modelUserAddress->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update', [
                'model' => $model,
                'modelUserAddress' => $modelUserAddress,
                'modelUserProfile' => $modelUserProfile,
                'modelUserInstruments' => $modelUserInstruments,
                'modelUserFields'        => $modelUserFields,
                'modelUserFieldValues'   => $modelUserFieldValues,
            ]);
        }
    }


    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
