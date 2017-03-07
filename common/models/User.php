<?php
namespace common\models;

use backend\modules\job\models\JobItem;
use backend\modules\user\models\UserFieldValue;
use backend\modules\user\models\UserSchool;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use backend\modules\user\models\User as UserModel;
use backend\modules\user\models\UserProfile;
use backend\modules\user\models\UserAddress;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const ROLE_DIRECTOR = 'Director';
    const ROLE_USER = 'User';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,

        ]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByActivationToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_DELETED,

        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    { 
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getRoleName()
    {
        if(empty($this->id)) return false;
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        if (!$roles) {
            return null;
        }

        reset($roles);

        /* @var $role \yii\rbac\Role */
        $role = current($roles);

        return $role->name;
    }

    public function isDirector(){
        return self::ROLE_DIRECTOR == $this->getRoleName();
    }

    public function isDirectorUserId($id){

        return ( $this->isDirector() && $id == $this->id );
    }

    public function isUser(){
        return self::ROLE_USER == $this->getRoleName();
    }

    public function isUserId($id){

        return ( $this->isUser() && $id == $this->id );
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(){

        return $this->hasOne(UserModel::className(), ['id' => 'id']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile(){

        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    public function getJobItems()
    {
        return $this->hasMany(JobItem::className(), ['user_id' => 'id']);
    }

    public function getUserAddress(){

        return $this->hasOne(UserAddress::className(), ['user_id' => 'id']);
    }

    public function getUserFieldValue()
    {
        return $this->hasMany(UserFieldValue::className(),['user_id' => 'id']);
    }

    public function lastActiveLogin($user_id = null, $show_first=false){

        $model = (empty($user_id)) ? $this : User::findOne($user_id);

        $currentTime =  Yii::$app->formatter->asDatetime(time(), "php:d M Y");
        $lastLoginTime = isset($model->last_login) ? Yii::$app->formatter->asDatetime($model->last_login, "php:H:i:s") : '';

        $intervals = ['y'=>'yr(s)',  'm'=> 'month(s)', 'd'=>'day(s)', 'h'=>'hr(s)', 'i'=>'min(s)', 's'=>'sec(s)',];

        $interval = date_diff(new \DateTime($currentTime), new \DateTime($lastLoginTime));
        $lastActive = [];
        foreach($interval as $key => $element){
            if($element > 0) {
                if($show_first == true ){
                    return sprintf('%s %s ago', $element, $intervals[$key]);
                }
                $lastActive[] = sprintf('%s %s', $element, $intervals[$key]);
            }
        }

        return implode(" ", $lastActive) . ' ago';
    }

}
