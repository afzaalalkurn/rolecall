<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_msg_recipients".
 *
 * @property integer $message_id
 * @property integer $seq
 * @property integer $recipient_id
 * @property string $status
 * @property integer $time
 *
 * @property UserMsg $message
 * @property User $recipient
 */
class UserMsgRecipients extends \yii\db\ActiveRecord
{
    const STATUS_READ = "Read";
    const STATUS_UNREAD = "UnRead";
    const STATUS_DELETED = "Deleted";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_msg_recipients';
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
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMsg::className(), 'targetAttribute' => ['message_id' => 'message_id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => 'Message ID',
            'seq' => 'Seq',
            'recipient_id' => 'Recipient ID',
            'status' => 'Status',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(UserMsg::className(), ['message_id' => 'message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }
}
