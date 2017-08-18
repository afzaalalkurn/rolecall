<?php

namespace backend\modules\user\controllers;

use Yii;
use backend\modules\user\models\User;
use backend\modules\user\models\search\Director;
use backend\modules\user\models\search\UserField;
use backend\modules\user\models\UserAddress;
use backend\modules\user\models\UserProfile;
use backend\modules\user\models\UserSchool;

use common\models\Upload;
use common\models\User as CommonUser;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * SchoolController implements the CRUD actions for User model.
 **/
class DirectorController extends Controller
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
        $searchModel = new Director();
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
            'model' => $this->findModel($id)
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
        $userSchool = new UserSchool();
        if ($model->load(Yii::$app->request->post()) && $model->save() && $userSchool->load(Yii::$app->request->post())) {
            $userSchool->user_id = $model->id;
            if($userSchool->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'userSchool' => $userSchool,
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
        $modelUserSchool = $model->userSchool ?? new UserSchool;


        if ($model->load(Yii::$app->request->post()) && $modelUserProfile->load(Yii::$app->request->post()) && $modelUserAddress->load(Yii::$app->request->post()) &&  $modelUserSchool->load(Yii::$app->request->post())){


            if($model = $this->_signup($model)){


                if( $modelUserProfile->validate()) {
                    $modelUserProfile->user_id = $model->id;
                    $modelUserProfile->dob = date('Y-m-d', strtotime($modelUserProfile->dob));
                    $modelUpload = new Upload();
                    $modelUpload->file = UploadedFile::getInstance($modelUserProfile, 'avatar');
                    $modelUserProfile->avatar = (!is_null($modelUpload->file)) ? $modelUpload->upload() : $modelUserProfile->oldAttributes['avatar'];


                    $modelUpload = new Upload();
                    $modelUpload->file = UploadedFile::getInstance($modelUserProfile, 'cover_photo');
                    $modelUserProfile->cover_photo = (!is_null($modelUpload->file)) ? $modelUpload->upload() : $modelUserProfile->oldAttributes['cover_photo'];

                    $modelUserProfile->save();
                }

                if($modelUserAddress->validate()) {
                    $modelUserAddress->user_id = $model->id;
                    $modelUserAddress->save();
                }

                if($modelUserSchool->validate()) {
                    $modelUserSchool->user_id = $model->id;

                    $modelUpload = new Upload();
                    $modelUpload->file = UploadedFile::getInstance($modelUserSchool, 'logo');
                    $modelUserSchool->logo = (!is_null($modelUpload->file)) ? $modelUpload->upload() : $modelUserSchool->oldAttributes['logo'];


                    $modelUpload = new Upload();
                    $modelUpload->file = UploadedFile::getInstance($modelUserSchool, 'cover_photo');
                    $modelUserSchool->cover_photo = (!is_null($modelUpload->file)) ? $modelUpload->upload() : $modelUserSchool->oldAttributes['cover_photo'];

                    $modelUserSchool->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } else {

            return $this->render('update', [
                'model' => $model,
                'modelUserAddress' => $modelUserAddress,
                'modelUserProfile' => $modelUserProfile,
                'modelUserSchool' => $modelUserSchool,
                'modelUserFields'        => $modelUserFields,
                'modelUserFieldValues'   => $modelUserFieldValues,

            ]);
        }
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
