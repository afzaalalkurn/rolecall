<?php

namespace backend\modules\user\models;

use Yii;
use backend\modules\job\models\JobItem;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $itemNames
 * @property JobItem[] $jobItems
 * @property JobMsg[] $jobMsgs
 * @property JobMsgRecipients[] $jobMsgRecipients
 * @property JobUserMapper[] $jobUserMappers
 * @property UserAddress $userAddress
 * @property UserAds[] $userAds
 * @property UserInstruments $userInstruments
 * @property UserJobCategoryMapper[] $userJobCategoryMappers
 * @property JobCategory[] $categories
 * @property UserMsg[] $userMsgs
 * @property UserMsgRecipients[] $userMsgRecipients
 * @property UserNotification[] $userNotifications
 * @property UserNotificationRecipients[] $userNotificationRecipients
 * @property UserProfile $userProfile
 * @property UserSchool $userSchool
 * @property UserSchoolImages[] $userSchoolImages
 * @property UserSchoolMsg[] $userSchoolMsgs
 * @property UserSchoolMsgAttachments[] $userSchoolMsgAttachments
 * @property UserSchoolMsgRecipients[] $userSchoolMsgRecipients
 * @property UserSocial[] $userSocials
 * @property CoreSocialNetwork[] $networks
 * @property UserTransaction[] $userTransactions
 * @property UserFieldValues[] $userFieldValues
 */
class User extends \yii\db\ActiveRecord
{

    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobItems()
    {
        return $this->hasMany(JobItem::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFieldValues()
    {
        return $this->hasMany(UserFieldValue::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobMsgs()
    {
        return $this->hasMany(JobMsg::className(), ['sender_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobMsgRecipients()
    {
        return $this->hasMany(JobMsgRecipients::className(), ['recipient_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobUserMappers()
    {
        return $this->hasMany(JobUserMapper::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddress()
    {
        return $this->hasOne(UserAddress::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAds()
    {
        return $this->hasMany(UserAds::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInstruments()
    {
        return $this->hasOne(UserInstruments::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserJobCategoryMappers()
    {
        return $this->hasMany(UserJobCategoryMapper::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(JobCategory::className(), ['category_id' => 'category_id'])->viaTable('user_job_category_mapper', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMsgs()
    {
        return $this->hasMany(UserMsg::className(), ['sender_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMsgRecipients()
    {
        return $this->hasMany(UserMsgRecipients::className(), ['recipient_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotifications()
    {
        return $this->hasMany(UserNotification::className(), ['sender_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotificationRecipients()
    {
        return $this->hasMany(UserNotificationRecipients::className(), ['recipient_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMsgAttachments()
    {
        return $this->hasMany(UserSchoolMsgAttachments::className(), ['sender_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSocials()
    {
        return $this->hasMany(UserSocial::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetworks()
    {
        return $this->hasMany(CoreSocialNetwork::className(),
            ['id' => 'network_id'])
            ->viaTable('user_social', ['user_id' => 'id']
            );
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTransactions()
    {
        return $this->hasMany(UserTransaction::className(), ['user_id' => 'id']);
    }

    public function getRoleName()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        if (!$roles) {
            return null;
        }

        reset($roles);

        /* @var $role \yii\rbac\Role */
        $role = current($roles);

        return $role->name;
    }

}
