<?php

namespace backend\modules\user\models;

use backend\modules\job\models\JobItem as Item;
use Yii;

/**
 * This is the model class for table "user_msg".
 *
 * @property integer $message_id
 * @property integer $seq
 * @property string $identifier
 * @property integer $sender_id
 * @property integer $item_id
 * @property string $subject
 * @property string $text
 * @property string $status
 * @property string $created_at
 *
 * @property User $user
 * @property Item $item
 * @property User $sender
 * @property UserMsgAttachments[] $userMsgAttachments
 * @property UserMsgRecipients[] $userMsgRecipients
 */

class UserMsg extends \yii\db\ActiveRecord
{
    const STATUS_READ = "Read";
    const STATUS_UNREAD = "UnRead";
    const STATUS_DELETED = "Deleted";
    const STATUS_SPAN = "Span";
    const STATUS_ARCHIVED = "Archived";
    public $attachment;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['seq', 'item_id', 'item_type', 'sender_id'], 'integer'],
            [['text', 'status'], 'string'],
            [['created_at'], 'safe'],
            [['identifier'], 'string', 'max' => 25],
            [['subject'], 'string', 'max' => 250],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
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
            'identifier' => 'Identifier',
            'item_id' => 'Item ID',
            'item_type' => 'Item Type',
            'sender_id' => 'Sender ID',
            'subject' => 'Subject',
            'text' => 'Message',
            'category' => 'Category',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
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
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['job_id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMsgAttachments()
    {
        return $this->hasMany(UserMsgAttachments::className(), ['message_id' => 'message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMsgRecipients()
    {
        return $this->hasMany(UserMsgRecipients::className(), ['message_id' => 'message_id']);
    }

    public function sendEmail($user_id)
    {
        $subject = Yii::t('app', 'You have new message from {name}',[ 'name'=> Yii::$app->name]);
        $email = User::findOne($user_id)->email;
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->sender->email => $this->sender->email])
            ->setSubject( $subject )
            ->setTextBody( $this->text )
            ->send();
    }

}
