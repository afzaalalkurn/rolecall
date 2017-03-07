<?php

namespace backend\modules\core\models;

use Yii;

/**
 * This is the model class for table "core_plan".
 *
 * @property integer $id
 * @property string $paypal_plan_id
 * @property string $name
 * @property string $description
 * @property string $plan_type
 * @property string $payment_type
 * @property string $frequency
 * @property integer $frequency_interval
 * @property integer $cycles
 * @property string $amount
 * @property integer $jobs
 * @property integer $status
 * @property integer $created_at
 * @property string $updated_at
 *
 * @property UserSchool[] $userSchools
 */
class CorePlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'core_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description', 'plan_type', 'payment_type', 'frequency', 'status',], 'string'],
            [['frequency_interval', 'cycles', 'jobs', 'created_at'], 'integer'],
            [['amount'], 'number'],
            [['updated_at'], 'safe'],
            [['paypal_plan_id'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'paypal_plan_id' => Yii::t('app', 'Paypal Plan'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'plan_type' => Yii::t('app', 'Plan Type'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'frequency' => Yii::t('app', 'Frequency'),
            'frequency_interval' => Yii::t('app', 'Frequency Interval'),
            'cycles' => Yii::t('app', 'Cycles'),
            'amount' => Yii::t('app', 'Amount'),
            'jobs' => Yii::t('app', 'Jobs'),
            'status' => Yii::t('app', 'Plan Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSchools()
    {
        return $this->hasMany(UserSchool::className(), ['plan_id' => 'id']);
    }
}
