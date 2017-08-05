<?php
namespace frontend\models;

use common\models\User;
use alkurn\recaptcha\ReCaptchaValidator;


/**
 * Signup form
 */
class BecomeJobOwnerForm extends SignupForm
{
    public $school_name;
    public $first_name;
    public $last_name;
    public $gender;
    public $dob;
    public $plan_id;

    public $username;
    public $email;
    public $password;
     
    public $is_subscriber;
    
    public $avatar;
    public $cover_photo;
    public $logo;

    public $verify_code;
    public $agree;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    
                    [[/*'school_name',  'username' ,*/ 'first_name',
                        'last_name', 'email', 'password', /*'plan_id'*/],
                        'required'],
                    ['school_name', 'filter', 'filter' => 'trim'],
                    ['school_name', 'string', 'max' => 255],

                    ['first_name', 'filter', 'filter' => 'trim'],
                    ['first_name', 'string', 'max' => 255],
                    
                    ['last_name', 'filter', 'filter' => 'trim'],
                    ['last_name', 'string', 'max' => 255], 
             
                    [['avatar'], 'file'],
                    [['avatar'], 'string', 'max' => 250],
                    
                    [['cover_photo'], 'file'],
                    [['cover_photo'], 'string', 'max' => 250],

                    [['logo'], 'file'],
                    [['logo'], 'string', 'max' => 250],
                    
                    ['username', 'filter', 'filter' => 'trim'],
                    ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
                    ['username', 'string', 'min' => 2, 'max' => 255],
                    
                    ['is_subscriber', 'filter', 'filter' => 'trim'],
                        
        
                    ['email', 'filter', 'filter' => 'trim'], 
                    ['email', 'email'],
                    ['email', 'string', 'max' => 255],
                    ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

                    ['password', 'string', 'min' => 6],

                    [['verify_code'],  ReCaptchaValidator::className()],
                    ['agree', 'required','requiredValue' => 1,
                        'message' => 'Please agree the terms and condition'
                    ],

        ];
    }

    public function attributeLabels()
    {
        return [
            'plan_id' => 'Plan',
            'agree' => 'Accept Terms & Conditions',
            'verify_code' => 'Captcha',
        ];
    }
    
}
