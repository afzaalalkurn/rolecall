<?php

namespace backend\modules\job\models;

use Yii;
use common\models\User;
use backend\modules\user\models\UserProfile;

/**
 * This is the model class for table "job_user_mapper".
 *
 * @property string $job_id
 * @property string $user_id
 * @property string $status
 *
 * @property JobItem $job
 * @property User $user
 */
class JobUserMapper extends \yii\db\ActiveRecord
{

    const STATUS_APPLIED    = 'Applied';
    const STATUS_FAVORITE   = 'Favorite';
    const STATUS_SAVED      = 'Saved';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_user_mapper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id', 'user_id', 'status'], 'required'],
            [['job_id', 'user_id'], 'integer'],
            [['status'], 'string'],
            [['dated'], 'safe'],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobItem::className(), 'targetAttribute' => ['job_id' => 'job_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'job_id' => 'Job ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'dated' => 'Dated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(JobItem::className(), ['job_id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
