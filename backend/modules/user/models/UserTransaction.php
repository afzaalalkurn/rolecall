<?php

namespace backend\modules\user\models;

use Yii;
use backend\modules\core\models\CorePlan;

/**
 * This is the model class for table "user_transaction".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $plan_id
 * @property string $agreement_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $address
 * @property string $method
 * @property string $request_data
 * @property string $response_data
 * @property string $state
 * @property string $start_date
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property UserSchool[] $userSchools
 * @property User $user
 * @property CorePlan $plan
 */
class UserTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'agreement_id', 'first_name', 'last_name'], 'required'],
            [['user_id', 'plan_id', 'created_at', 'updated_at'], 'integer'],
            [['method', 'request_data', 'response_data', 'state'], 'string'],
            [['agreement_id', 'start_date'], 'string', 'max' => 64],
            [['first_name', 'last_name', 'email', 'address'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => CorePlan::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'plan_id' => Yii::t('app', 'Plan ID'),
            'agreement_id' => Yii::t('app', 'Agreement ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'address' => Yii::t('app', 'Address'),
            'method' => Yii::t('app', 'Method'),
            'request_data' => Yii::t('app', 'Request Data'),
            'response_data' => Yii::t('app', 'Response Data'),
            'state' => Yii::t('app', 'State'),
            'start_date' => Yii::t('app', 'Start Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSchools()
    {
        return $this->hasMany(UserSchool::className(), ['transaction_id' => 'id']);
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
    public function getPlan()
    {
        return $this->hasOne(CorePlan::className(), ['id' => 'plan_id']);
    }
}
