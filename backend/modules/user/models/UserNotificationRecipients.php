<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_notification_recipients".
 *
 * @property string $message_id
 * @property string $seq
 * @property string $recipient_id
 * @property string $ip
 * @property string $status
 * @property integer $time
 *
 * @property UserNotification $message
 * @property User $recipient
 */
class UserNotificationRecipients extends \yii\db\ActiveRecord
{
    const STATUS_READ          = 'Read';
    const STATUS_UNREAD        = 'UnRead';
    const STATUS_DELETED       = 'Deleted';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_notification_recipients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'seq', 'recipient_id'], 'required'],
            [['message_id', 'seq', 'recipient_id', 'time'], 'integer'],
            [['status'], 'string'],
            [['ip'], 'string', 'max' => 30],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserNotification::className(), 'targetAttribute' => ['message_id' => 'message_id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => Yii::t('app', 'Message ID'),
            'seq' => Yii::t('app', 'Seq'),
            'recipient_id' => Yii::t('app', 'Recipient ID'),
            'ip' => Yii::t('app', 'Ip'),
            'status' => Yii::t('app', 'Status'),
            'time' => Yii::t('app', 'Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(UserNotification::className(), ['message_id' => 'message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }
}
