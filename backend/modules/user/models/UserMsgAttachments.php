<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "usermsg_attachments".
 *
 * @property string $attachment_id
 * @property string $message_id
 * @property string $attachment
 *
 * @property UserMsg $message
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
            [['message_id', 'attachment'], 'required'],
            [['message_id'], 'integer'],
            [['attachment'], 'string', 'max' => 250],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMsg::className(), 'targetAttribute' => ['message_id' => 'message_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attachment_id' => Yii::t('app', 'Attachment ID'),
            'message_id' => Yii::t('app', 'Message ID'),
            'attachment' => Yii::t('app', 'Attachment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(UserMsg::className(), ['message_id' => 'message_id']);
    }
}
