<?php
namespace common\models;

use Yii;
use yii\base\Model; 

/**
 * Password change request form
 */
class ChangePasswordForm extends User
{
    public $password;
    public $newpass;
    public $repeatnewpass;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','newpass','repeatnewpass'],'required'],
            [['password','newpass','repeatnewpass'], 'string', 'min'=>6],
            ['password','matchPassword'],
            ['repeatnewpass','compare','compareAttribute'=>'newpass'],
        ];
    } 

    public function attributeLabels(){
        return [
            'password'=>'Old Password',
            'newpass'=>'New Password',
            'repeatnewpass'=>'Repeat New Password',
        ];
    } 

    public function matchPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            
            if (!$this->validatePassword($this->password)) {
                
                $this->addError($attribute, 'Incorrect password.');
            }
            return true; 
        } 
    }
}
