<?php

namespace backend\modules\user\models;

use Yii;
use backend\modules\core\models\CorePlan;

/**
 * This is the model class for table "user_profile".
 *
 * @property string $user_id
 * @property string $plan_id
 * @property string $language
 * @property string $avatar
 * @property string $cover_photo
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $dob
 * @property string $joining_date
 * @property string $about_us
 * @property string $mobile
 * @property string $telephone
 * @property integer $is_free
 * @property integer $is_subscriber
 * @property integer $is_deleted
 *
 * @property User $user
 * @property CorePlan $plan
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['gender', 'about_us'], 'string'],
            [['dob', 'joining_date'], 'safe'],
            [['is_free', 'plan_id',], 'integer'],
            [['is_subscriber','is_deleted'], 'integer'],
            [['language'], 'string', 'max' => 25],
            [['avatar'], 'string', 'max' => 250],
            [['cover_photo'], 'string', 'max' => 250],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['mobile', 'telephone'], 'string', 'max' => 15],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'plan_id' => Yii::t('app', 'Plan ID'),
            'language' => Yii::t('app', 'Language'),
            'avatar' => Yii::t('app', 'Avatar'),
            'cover_photo' => Yii::t('app', 'Cover Photo'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender' => Yii::t('app', 'Gender'),
            'dob' => Yii::t('app', 'Dob'),
            'joining_date' => Yii::t('app', 'Joining Date'),
            'about_us' => Yii::t('app', 'About Us'),
            'mobile' => Yii::t('app', 'Mobile'),
            'telephone' => Yii::t('app', 'Telephone'),
            'is_free' => Yii::t('app', 'Is Free'),
            'is_subscriber' => Yii::t('app', 'Is Subscriber'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getName()
    {
        return sprintf("%s %s",$this->first_name,$this->last_name);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getPlan()
    {
        return $this->hasOne(CorePlan::className(), ['id' => 'plan_id']);
    }
}
