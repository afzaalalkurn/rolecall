<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_msg_attachments".
 *
 * @property integer $attachment_id
 * @property integer $message_id
 * @property integer $sender_id
 * @property integer $seq
 * @property string $attachment
 *
 * @property UserMsg $message
 * @property User $sender
 */
class UserMsgAttachments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_msg_attachments';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'sender_id', 'seq'], 'required'],
            [['message_id', 'sender_id', 'seq'], 'integer'],
            [['attachment'],  'file',  'extensions'=>'jpg, jpeg, gif, png',  'maxFiles' => 10],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMsg::className(), 'targetAttribute' => ['message_id' => 'message_id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attachment_id' => 'Attachment ID',
            'message_id' => 'Message ID',
            'sender_id' => 'Sender ID',
            'seq' => 'Seq',
            'attachment' => 'Attachment',
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
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }
}
