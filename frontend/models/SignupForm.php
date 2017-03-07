<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use himiklab\recaptcha\ReCaptchaValidator;
use Yii;
use yii\helpers\Url;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $instruments;
    public $first_name;
    public $last_name;
    public $gender;
    public $dob;
    public $status;

   /* public $category;  */
    public $is_subscriber;

    public $username;
    public $email;
    public $password; 
    
    public $avatar;
    public $cover_photo; 

    public $verify_code;
    public $agree;

    


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
                    [[/*'instruments','username',*/
                    'first_name', 'last_name', 'email', 'password'],
                        'required'],

                    ['first_name', 'filter', 'filter' => 'trim'],
                    ['first_name', 'string', 'max' => 255],
                    
                    ['last_name', 'filter', 'filter' => 'trim'],                    
                    ['last_name', 'string', 'max' => 255],
                 
                    [['avatar'], 'file'],
                    [['avatar'], 'string', 'max' => 250],
            
                    [['cover_photo'], 'file'],
                    [['cover_photo'], 'string', 'max' => 250], 
            
                    ['username', 'filter', 'filter' => 'trim'],                    
                    ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
                    ['username', 'string', 'min' => 2, 'max' => 255], 
            
                    ['is_subscriber', 'filter', 'filter' => 'trim'],
                    
                   /* [['category'], 'required'],         */           
        
                    ['email', 'filter', 'filter' => 'trim'],                    
                    ['email', 'email'],
                    ['email', 'string', 'max' => 255],
                    ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],        
                    
                    ['password', 'string', 'min' => 6],

                    [['verify_code'],ReCaptchaValidator::className()],
                    ['status', 'integer'],
                    ['agree', 'required','requiredValue' => 1,
                        'message' => 'Please agree the terms and condition'
                    ],

        ];
    }
    
    public function attributeLabels()
    {
        return [
            'instruments' => 'Instruments You Teach',
            'verify_code' => 'Verification Code',
            'agree' => 'Accept Terms & Conditions',
            'is_subscriber' => 'Newsletter Subcription',
            'logo' => 'School Logo',
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {  
        if ( !$this->validate() ) {
            return null;
        }   

        $user = new User();
        $user->email = $this->email;
        $user->username = substr($this->email, 0, strpos($this->email, '@'));
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null; 
    }

    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if ( !User::isPasswordResetTokenValid( $user->password_reset_token ) ) {
            $user->generatePasswordResetToken();
        }

        if (!$user->save()) {
            return false;
        }

        $subject = Yii::t('app','You have been successfully registered on {name}',
            ['name' => Yii::$app->name]
        );

        $accessLink = Yii::$app->urlManager->createAbsoluteUrl(['site/access-verification', 'token' => $user->password_reset_token]);

        return Yii::$app->mail->compose()
            ->setTo($this->email)
            ->setFrom([$this->email => 'RoleCall'])
            ->setSubject($subject)
            ->setHtmlBody(Yii::t(
                'app','<b>Hello '.$user->username.',</b><br/><br/>Welcome to {name} , You have   been successfully registered on {name}. <br/><br/>By clicking on the following link, you are confirming your email address and agreeing to {name} Terms of Service.
<a href="{token_url}">Confirm Email Address</a>
                <br/> Thank you for connecting with us.
                <br/><br/><b>Regards,</b><br/>
                <b>{name} Team</b>',
                ['email' => $user->email,
                    'name' => Yii::$app->name ,
                    'token_url' => $accessLink,
                ]))
            ->send();
    }
}
