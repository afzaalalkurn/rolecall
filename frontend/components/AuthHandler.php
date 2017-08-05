<?php

namespace frontend\components;

use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use common\models\Auth;
use common\models\User;
use frontend\controllers\SiteController;
use backend\modules\user\models\UserProfile;
use yii\web\HttpException;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler extends SiteController
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $type = $_GET['type'];
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $name = ArrayHelper::getValue($attributes, 'name');
        $first_name = ArrayHelper::getValue($attributes, 'first_name');
        $last_name = ArrayHelper::getValue($attributes, 'last_name');
        $username = $this->getUsernameFromEmail($email);

        /* @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                /* @var User $user */
                $user = $auth->user;
                $this->updateUserInfo($user);
                /*Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);*/
                Yii::$app->getUser()->login($user); // autologin
                $user->last_login = time();
                $user->save(false, ["last_login"]);
                if(Yii::$app->user->identity->isDirector())
                {
                    return $this->redirect('/dashboard');
                }
                else
                {
                    return $this->redirect(['/job/job-user-mapper/index',
                        'user_id'=>Yii::$app->user->id,
                        'status' => 'Pending']);
                }
            } else { // signup
                if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();

                    $transaction = User::getDb()->beginTransaction();

                    if ($user->save()) {
                        $this->_assignAuth($user->id, $type);
                        $this->saveUserProfile($user->id, $first_name,$last_name);
                        $this->_saveAddress($user->id, $user);

                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $this->client->getId(),
                            'source_id' => (string)$id,
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->getUser()->login($user); // autologin
                            $user->last_login = time();
                            $user->save(false, ["last_login"]);
                            $this->sendWelcomeMail($email,$username,$password); // send welcome mail
                            if(Yii::$app->user->identity->isDirector())
                            {
                                return $this->redirect('/dashboard');
                            }
                            else
                            {
                                return $this->redirect(['/job/job-user-mapper/index',
                                    'user_id'=>Yii::$app->user->id,
                                    'status' => 'Pending']);
                            }
                            /*Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);*/
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app',  'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
                }
            }

        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string)$attributes['id'],
                ]);
                if ($auth->save()) {
                    /** @var User $user */
                    $user = $auth->user;
                    $this->updateUserInfo($user);
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle()
                        ]),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app',
                        'Unable to link {client} account. There is another user using it.',
                        ['client' => $this->client->getTitle()]),
                ]);
            }
        }
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $username = $this->getUsernameFromEmail($email);
        if ($user->username === null && $username) {
            $user->username = $username;
            $user->save();
        }
    }

    /**
     * @param $email
     * @return string
     */
    private function getUsernameFromEmail($email){
        $pos = strpos($email, '@');
        $username = substr($email, 0, $pos);
        return $username;
    }

    private function saveUserProfile($user_id,$first_name,$last_name)
    {
        $modelProfile = new UserProfile();
        $modelProfile->user_id = $user_id;
        $modelProfile->first_name = $first_name;
        $modelProfile->last_name = $last_name;

        if ($modelProfile->save(false)) {
            return true;
        }
        throw new HttpException(405, 'Error saving model modelProfile');
    }

    private function sendWelcomeMail($email,$username,$password){
        $subject = Yii::t('app','You have been successfully registered on {name}',
            ['name' => Yii::$app->name]
        );
        return Yii::$app->mail->compose()
            ->setTo($email)
            ->setFrom([$email => 'RoleCall'])
            ->setSubject($subject)
            ->setHtmlBody(Yii::t(
                'app','<b>Hello '.$username.',</b><br/><br/>Welcome to {name} , You have been successfully registered on {name}. <br/><br/>Below are the login details:<br/>
                email : {email}<br/>
                password : {password}<br/>
                <br/> Thank you for connecting with us.
                <br/><br/><b>Regards,</b><br/>
                <b>{name} Team</b>',
                ['email' => $email,
                    'name' => Yii::$app->name ,
                    'password' => $password,
                ]))
            ->send();
    }
}