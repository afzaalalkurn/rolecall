<?php

namespace backend\modules\job\models;

use Yii;

/**
 * This is the model class for table "job_transaction".
 *
 * @property string $id
 * @property string $user_id
 * @property string $job_id
 * @property string $first_name
 * @property string $last_name
 * @property string $number
 * @property string $type
 * @property integer $expire_month
 * @property string $expire_year
 * @property string $cvv2
 * @property string $data
 * @property string $dated
 *
 * @property User $user
 * @property JobItem $job
 */
class JobTransaction extends \yii\db\ActiveRecord
{

    public $jobs;
    public $year;
    public $month;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'job_id', 'first_name', 'last_name', 'number', 'type', 'expire_month', 'expire_year', 'cvv2'], 'required'],
            [['user_id', 'job_id', 'expire_month', 'expire_year'], 'integer'],
            [['data'], 'string'],
            [['dated'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['number', 'type', 'cvv2'], 'string', 'max' => 32],
           /* [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],*/
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobItem::className(), 'targetAttribute' => ['job_id' => 'job_id']],
            ['cc', 'bryglen\validators\CreditCardValidator'],

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
            'job_id' => Yii::t('app', 'Job ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'number' => Yii::t('app', 'Card Number'),
            'type' => Yii::t('app', 'Card Type'),
            'expire_month' => Yii::t('app', 'Expire Month'),
            'expire_year' => Yii::t('app', 'Expire Year'),
            'cvv2' => Yii::t('app', 'Cvv2'),
            'data' => Yii::t('app', 'Data'),
            'dated' => Yii::t('app', 'Dated'),
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
    public function getJob()
    {
        return $this->hasOne(JobItem::className(), ['job_id' => 'job_id']);
    }

}
