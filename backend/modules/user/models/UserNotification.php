<?php

namespace backend\modules\user\models;

use Yii;
use backend\modules\job\models\JobItem;
use frontend\event\NotificationEvent;
 

/**
 * This is the model class for table "user_notification".
 *
 * @property string $message_id
 * @property string $identifier
 * @property string $job_id
 * @property string $seq
 * @property string $sender_id
 * @property string $text
 * @property string $ip
 * @property string $category
 * @property string $status
 * @property integer $time
 * @property string $created_on
 *
 * @property JobItem $job
 * @property User $sender
 * @property UserNotificationRecipients[] $userNotificationRecipients
 */
class UserNotification extends \yii\db\ActiveRecord
{
    const STATUS_READ          = 'Read';
    const STATUS_UNREAD        = 'UnRead';
    const STATUS_DELETED       = 'Deleted';
    const STATUS_SPAN          = 'Span';
    const STATUS_ARCHIVED      = 'Archived';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id', 'seq', 'sender_id', 'time'], 'required'],
            [['job_id', 'seq', 'sender_id', 'time'], 'integer'],
            [['text', 'category', 'status'], 'string'],
            [['created_on'], 'safe'],
            [['identifier'], 'string', 'max' => 60],
            [['ip'], 'string', 'max' => 30],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobItem::className(), 'targetAttribute' => ['job_id' => 'job_id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => Yii::t('app', 'Message ID'),
            'identifier' => Yii::t('app', 'Identifier'),
            'job_id' => Yii::t('app', 'Job ID'),
            'seq' => Yii::t('app', 'Seq'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'text' => Yii::t('app', 'Text'),
            'ip' => Yii::t('app', 'Ip'),
            'category' => Yii::t('app', 'Category'),
            'status' => Yii::t('app', 'Status'),
            'time' => Yii::t('app', 'Time'),
            'created_on' => Yii::t('app', 'Created On'),
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
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotificationRecipients()
    {
        return $this->hasMany(UserNotificationRecipients::className(), ['message_id' => 'message_id']);
    }  
    
}
