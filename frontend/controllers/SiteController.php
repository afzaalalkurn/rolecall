<?php

namespace frontend\controllers;

use backend\modules\job\models\JobFieldOption;
use backend\modules\user\models\search\UserAddress;

use backend\modules\user\models\search\UserSubscriber;
use backend\modules\user\models\UserFieldOption;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\web\Cookie;

use common\models\LoginForm;
use common\models\User;
use common\models\ChangePasswordForm;
use common\models\Upload;

use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\ResetPasswordForm;
use frontend\models\BecomeJobOwnerForm;
use frontend\models\PasswordResetRequestForm;

use common\models\User as CommonUser;
use backend\modules\user\models\UserProfile;
use backend\modules\user\models\UserCompany;
use backend\modules\user\models\UserJobCategoryMapper;
use backend\modules\user\models\UserSubscriptionMapper;

use backend\modules\job\models\JobItem;
use backend\modules\job\models\JobCategoryMapper;
use backend\modules\job\models\search\JobItem as JobItemSearch;
use backend\modules\user\models\UserInstruments;
use backend\modules\user\models\search\UserProfile as UserProfileSearch;
use frontend\models\UserTransaction;
use frontend\components\AuthHandler;

/*
 * about-us
 * plans
 * privacy-policy
 * term-condition
 * faq
 * sitemap
 * blogs
 * how-to-apply
 * privacy-policy
 * terms
 * help
 * plans
 *
 * */

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
        //$userAttributes = $client->getUserAttributes();
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new UserSubscriber();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionPolicy()
    {
        return $this->render('policy');
    }

    public function actionTerms()
    {
        return $this->render('terms');
    }

    public function actionDirector()
    {
        return $this->render('director');
    }

    public function actionTalent()
    {
        return $this->render('talent');
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionDashboard()
    {
        return $this->render('dashboard');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /*return $this->goBack();*/
            $user = User::findOne(Yii::$app->user->id);
            $user->last_login = time();
            $user->save(false, ["last_login"]);
            if (Yii::$app->user->identity->isDirector()) {
                return $this->redirect('/dashboard');
            } else {
                return $this->redirect(['/job/job-user-mapper/index',
                    'user_id' => Yii::$app->user->id,
                    'status' => 'Pending']);
            }

        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success',
            'You have logged out successfully.');
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
            return $this->refresh();
        } else {

            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionPayment()
    {
        $modelTransaction = new UserTransaction();
        if ($modelTransaction->load(Yii::$app->request->post()) && $modelTransaction->validate()) {
            Yii::$app->paypal->payNow($modelTransaction);
        }
        return $this->render('transaction', [
            'modelTransaction' => $modelTransaction,
        ]);

    }

    public function actionBecomeJobOwner()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //$this->_payNow();
        $model = new BecomeJobOwnerForm();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($user = $model->signup()) {
                    $user_id = $user->getId();
                    $this->_assignAuth($user_id, 'Director');
                    $this->_saveProfile($user_id, $model);
                    $this->_saveAddress($user_id, $model);

                    $transaction->commit();
                    /* $this->_payNow($user_id, $model); */
                    $model->sendEmail();
                    $user->status = 0;
                    $user->save();

                    Yii::$app->session->setFlash('success',
                        'Congrats! you have been resgistered successfully...! 
                        Activation link has been sent to your registered email ID.');

                    /*$modelPlan = CorePlan::findOne($model->plan_id);
                    $url = ( $modelPlan->amount > 0) ? '/payment' : '/dashboard';
                    return $this->redirect($url);*/

                    return $this->goHome();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('become-job-owner', [
            'model' => $model,
        ]);
    }

    protected function _assignAuth($user_id, $role)
    {
        // the following three lines were added:
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole($role);

        if ($auth->assign($authorRole, $user_id)) {
            return true;
        }

        throw new HttpException(405, 'Error saving model authorRole');

    }

    protected function _saveProfile($user_id, $model)
    {

        $modelProfile = new UserProfile();
        $modelProfile->user_id = $user_id;
        $modelProfile->is_subscriber = $model->is_subscriber;


        $modelProfile->first_name = $model->first_name;
        $modelProfile->last_name = $model->last_name;

        /*
        $modelProfile->is_subscriber = $model->is_subscriber;
        $modelProfile->language = 0;
        $modelProfile->gender = 'None';
        $modelProfile->about_us = '';
        $modelProfile->dob = '';
        $modelProfile->is_free = 0;
        $modelProfile->mobile = '';
        $modelProfile->telephone = '';

        $modelUpload = new Upload();
        if ($modelUpload->file = UploadedFile::getInstance($model, 'avatar')) {
            $modelProfile->avatar = $modelUpload->upload();
        }

        $modelUpload = new Upload();
        if ($modelUpload->file = UploadedFile::getInstance($model, 'cover_photo')) {
            $modelProfile->cover_photo = $modelUpload->upload();
        }
    */

        if ($modelProfile->save(false)) {
            return true;
        }
        throw new HttpException(405, 'Error saving model modelProfile');
    }

    protected function _saveAddress($user_id, $model)
    {
        $modelAddress = new UserAddress();
        $modelAddress->user_id = $user_id;
        $modelAddress->save(false);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($user = $model->signup()) {
                    $user_id = $user->getId();
                    $this->_assignAuth($user_id, 'User');
                    $this->_saveProfile($user_id, $model);
                    $this->_saveAddress($user_id, $model);
                    $transaction->commit();
                    $model->sendEmail();
                    $user->status = 0;
                    $user->save();
                    Yii::$app->session->setFlash('success',
                        'Congrats! you have been resgistered successfully..!
                        Activation link has been sent to your registered email ID.');
                    return $this->goHome();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('request-password-reset-token', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post())
            && $model->validate() && $model->resetPassword()
        ) {
            Yii::$app->session->setFlash(
                'success',
                'New password was saved.'
            );

            return $this->goHome();
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionChangePassword()
    {
        $model = ChangePasswordForm::findOne(['id' => Yii::$app->user->getId()]);;


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->setPassword($model->newpass);

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Successfully chnage your password.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to change password.');
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    /**
     * User update page.
     */
    public function actionUpdate()
    {

        $model = Yii::$app->user->identity->userProfile;
        if ($model && $model->load(Yii::$app->request->post())) {

            $modelUpload = new Upload();
            $modelUpload->file = UploadedFile::getInstance($model, 'avatar');
            $model->avatar = !is_null($modelUpload->file) ?
                $modelUpload->upload() : $model->getOldAttribute('avatar');

            if ($model->validate()) {
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success',
                        'User successfully updated!');
                    return $this->redirect('/dashboard');
                } else {
                    Yii::$app->session->setFlash('danger',
                        'User failed to updated!');
                }
                return $this->refresh();
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionSiteInfo()
    {
        phpinfo();
        exit;
    }

    /**
     * @param $token
     * @return User
     */
    public function actionAccessVerification($token)
    {
        $user = CommonUser::findByActivationToken($token);

        if (!$user) {
            //throw new InvalidParamException('Invalid token.');
            Yii::$app->session->setFlash('danger', 'Invalid token.');
            return $this->goHome();
        } else {
            $user->removePasswordResetToken();
            $user->status = 10;
            if ($user->save(false)) {
                if (Yii::$app->getUser()->login($user)) {
                    $user = User::findOne(Yii::$app->user->id);
                    $user->last_login = time();
                    $user->save(false, ["last_login"]);

                    Yii::$app->session->setFlash('success',
                        'Congrats! Your account has been activated 
                    successfully...!');
                    if (Yii::$app->user->identity->isDirector()) {
                        return $this->redirect('/dashboard');
                    } else {
                        return $this->redirect(['/job/job-user-mapper/index',
                            'user_id' => Yii::$app->user->id,
                            'status' => 'Pending']);
                    }
                }
                //return $model;
            }
        }
    }

    public function actionTestmail()
    {

        $res = Yii::$app->mail->compose()
            ->setTo('vasundhara.alkurn@gmail.com')
            ->setFrom('app.alkurn@gmail.com')
            ->setSubject('Registered On ' . Yii::$app->name)
            ->setTextBody('You have been successfully registered on ' . Yii::$app->name)
            ->setHtmlBody('<b>Hello </b><br/><br/>Welcome to Site , You have been successfully registered on ' . Yii::$app->name . '. Thank you for connecting with us.<br/><br/><b>Regards,</b><br/><b>' . Yii::$app->name . ' Team</b>')
            ->send();
    }

    public function actionSubscribe()
    {
        $model = new UserSubscriber();
        if ($model && $model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->validate()) {
                    $transaction->commit();
                    $model->save(false);
                    Yii::$app->session->setFlash('success',
                        'You have successfully subscribed for newsletter');
                } else {
                    Yii::$app->session->setFlash('danger',
                        'Newsletter subscription failed.');
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                if ($e->getCode() == 23000) {
                    Yii::$app->session->setFlash('danger',
                        'This email address already exist.');
                }
            }
            return $this->goHome();
        }
        return $this->render('subscribe', ['model' => $model]);
    }

    protected function _saveInstruments($user_id, $model)
    {
        $modelUserInstruments = new UserInstruments;
        $modelUserInstruments->user_id = $user_id;
        $modelUserInstruments->title = $model->instruments;

        if ($modelUserInstruments->save()) {
            return true;
        }

        throw new HttpException(405, 'Error saving model UserJobCategoryMapper');
    }

    protected function _saveCategory($user_id, $model)
    {
        $UserJobCategoryMapper = new UserJobCategoryMapper;
        $UserJobCategoryMapper->category_id = 1;
        $UserJobCategoryMapper->user_id = $user_id;
        if ($UserJobCategoryMapper->save(false)) {
            return true;
        }
        throw new HttpException(405, 'Error saving model UserJobCategoryMapper');
    }

    protected function _saveSubscription($model)
    {
        $modelUserSubscriptionMapper = new UserSubscriptionMapper();
        $modelUserSubscriptionMapper->email = $model->email;
        if ($modelUserSubscriptionMapper->save(false)) {
            return true;
        }
        throw new HttpException(405, 'Error saving model modelUserSubscriptionMapper');


    }

    public function actionUserCustomeFields(){

        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [];
        $depdropParents = Yii::$app->request->post('depdrop_parents');
        if ($depdropParents) {

            if ($depdropParents != null && !empty($depdropParents[0])) {

                $parent = UserFieldOption::findOne(['value' => $depdropParents[0]]);

                foreach($parent->userFieldOptions as $fieldOption){
                    $out[] = ['id'=>$fieldOption->value, 'name'=>$fieldOption->name];
                }
                return ['code'=> 'success', 'output' => $out,'selected' => ''];
            }
        }

        return ['code' => 'failed', 'output'=>'', 'selected'=>''];
    }

    public function actionJobCustomeFields(){

        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [];
        $depdropParents = Yii::$app->request->post('depdrop_parents');
        if ($depdropParents) {

            if ($depdropParents != null && !empty($depdropParents[0])) {

                $parent = JobFieldOption::findOne(['value' => $depdropParents[0]]);

                foreach($parent->jobFieldOptions as $fieldOption){
                    $out[] = ['id'=>$fieldOption->value, 'name'=>$fieldOption->name];
                }
                return ['code'=> 'success', 'output' => $out,'selected' => ''];
            }
        }

        return ['code' => 'failed', 'output'=>'', 'selected'=>''];
    }

}

