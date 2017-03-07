<?php
namespace frontend\modules\user\controllers;

use backend\modules\user\models\UserTransaction;
use Yii;
use yii\helpers\Url;
use backend\modules\job\models\JobItem;
use backend\modules\user\models\UserSchool;
use backend\modules\user\models\search\UserSchool as UserSchoolSearch;
use backend\modules\user\models\User;
use backend\modules\user\models\UserSocial;
use backend\modules\user\models\search\UserSocial as UserSocialSearch;
use backend\modules\user\models\search\UserNews as UserNewsSearch;
use common\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Upload;

/**
 * UserSchoolController implements the CRUD actions for UserSchool model.
 */
class UserSchoolController extends Controller
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
     * Lists all UserSchool models.
     * @return mixed
     **/

    public function actionIndex()
    {

        $id = Yii::$app->request->get('user_id') ?? Yii::$app->user->getId();

        $tpls = [];

        $model = $this->findModel($id);
        if( Yii::$app->user->getId() ){

            //user & job owner
            $tpls  = ( $id == Yii::$app->user->getId() ) ?
                $this->_ownerButtons() :
                $this->_userButtons( Yii::$app->request->get('user_id') );
        }else{
                //guest
                $tpls  =  $this->_guestButtons( Yii::$app->request->get('user_id') );
        }


        return $this->render('view', [
            'model' => $this->findModel($id),
            'tpls'  => $tpls
        ]);               
    }

    public function actionSchool()
    {
        $searchModel = new UserSchoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('director', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }


    public function actionShowInTab()
    {

       $id = Yii::$app->user->getId(); 

        $searchModel = new UserSocialSearch();
        $searchModel->user_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $social = $this->renderAjax('../user-social/index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]); 

        $searchModel = new UserNewsSearch();
        $searchModel->user_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 2;
        $news = $this->renderAjax('../user-news/newslist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_id' => $id
        ]);

        return $this->renderAjax('view', [
            'model'     => $this->findModel($id),
            'social'    => $social,
            'news'      => $news
        ]);               
    } 
     

    protected function _ownerButtons(){
        
        $tpls   = [];
        $links  = [
                    'Update Profile'     => Url::to(['update']),
                    'Gallery'     => Url::to(['user-director-images/index']),
                  ];
                    
        foreach ($links as $name => $path){
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


    protected function _userButtons($owner_id){
        
        if(empty($owner_id)) return [];

        $links  =   [ /*'View All'     => Url::to(['/user/user-news/index','user_id' => $owner_id]),*/];

        $tpls   = [];
        foreach ($links as $name => $path) {
            $tpls[] =   [
                            'item'      => $name,
                            'title'     => $name,
                            'path'      => $path,
                            'id'        => str_replace(' ' ,'-', $name),
                            'class'     => 'btn btn-primary user-button',
                        ];
        }
        return $tpls;
    }

    protected function _guestButtons($owner_id){
        
       if(empty($owner_id)) return [];

        $links  =   [
                       /* 'View All'     => Url::to(['/user/user-news/index', 'user_id' => $owner_id ]),*/
                    ]; 
        $tpls   = [];
                    
        foreach ($links as $name => $path) { 

            $tpls[] = [ 
                            'item'      => $name,
                            'title'     => $name,
                            'path'      => $path,
                            'id'        => str_replace(' ' ,'-', $name),
                            'class'     => 'btn btn-primary guest-button',
                        ];     
        }
        return $tpls;
    }

     
    
    protected function _upload($model, $attribute){

        $modelUpload = new Upload();
        $modelUpload->file = UploadedFile::getInstance($model, $attribute);
                return (!is_null($modelUpload->file)) ? $modelUpload->upload() : $model->oldAttributes[$attribute];

    }
   
    /**
     * Updates an existing UserSchool model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $id = Yii::$app->user->getId();
        $model = $this->findModel($id);
        $modelProfile = $model->user->userProfile;
        $modelsUserSocial = [new UserSocial];

        if($model->user->userSocials && count($model->user->userSocials) > 0){
            foreach($model->user->userSocials as $modelUserSocial)
                $modelsUserSocial[$modelUserSocial->network_id]  = $modelUserSocial;
        }


        if ($model->load(Yii::$app->request->post()) && $modelProfile->load(Yii::$app->request->post()) ) {

            $model->user_id = $id;
            $model->logo = $this->_upload($model, 'logo');
            $model->cover_photo = $this->_upload($model, 'cover_photo');

            if($model->save(false)){

                $modelProfile->avatar = $this->_upload($modelProfile, 'avatar');
                $modelProfile->cover_photo = $this->_upload($modelProfile, 'cover_photo');
                $modelProfile->save();

                if(Yii::$app->request->post('UserSocial')){
                    UserSocial::deleteAll( [ 'user_id' => $id ] );
                    foreach (Yii::$app->request->post('UserSocial') as $i => $dataUserSocial) {
                        $modelUserSocial = new UserSocial();
                        if (!empty($dataUserSocial)) {
                            $modelUserSocial->load($dataUserSocial, '');
                            if(!empty($modelUserSocial->network_id) && !empty($modelUserSocial->link)){
                                $modelUserSocial->user_id = $id;
                                $modelUserSocial->save();
                            }
                        }
                    }
                }

                /* Load Multiple */
               return $this->redirect(['index']);
            }
        }

        return $this->render('update',  [
            'model'             => $model,
            'modelProfile'      => $modelProfile,
            'modelsUserSocial'  => $modelsUserSocial,
            'modelUserSocial'   => $modelsUserSocial,
            ]
        );
    }

    /* upgrade */

    public function actionUpgrade($id)
    {
        $modelTransaction = new UserTransaction(); 
        $model = $this->findModel($id);

        if ($modelTransaction->load( Yii::$app->request->post()) && $model->load( Yii::$app->request->post())) {
            $modelTransaction->user_id = Yii::$app->user->id;



            if($modelTransaction->save() && $model->save()){
                $this->_payNow();
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('upgrade', [ 'modelTransaction' => $modelTransaction, 'model' => $model]);

    }

    protected function _payNow(){
        $payment = yii::$app->paypal->payNow();
        pr($payment);
    }

    /**
     * Deletes an existing UserSchool model.
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
     * Finds the UserSchool model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserSchool the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserSchool::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
