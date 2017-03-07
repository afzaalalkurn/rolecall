<?php

namespace backend\modules\user\models;

use Yii;
use backend\modules\job\models\JobItem;

/**
 * This is the model class for table "user_msg".
 *
 * @property string $message_id
 * @property string $seq
 * @property string $identifier
 * @property string $user_id
 * @property string $job_id
 * @property string $sender_id
 * @property string $subject
 * @property string $text
 * @property string $status
 * @property string $created_on
 *
 * @property UserCompany $director
 * @property JobItem $job
 * @property User $sender
 * @property UserCompanyMsgAttachments[] $userCompanyMsgAttachments
 * @property UserCompanyMsgRecipients[] $userCompanyMsgRecipients
 */
class UserMsg extends \yii\db\ActiveRecord
{

    const STATUS_READ        = 'Read';
    const STATUS_UNREAD      = 'UnRead';
    const STATUS_DELETED     = 'Deleted';
    const STATUS_SPAN        = 'Span';
    const STATUS_ARCHIVED    = 'Archived';

    public $attachment = [];
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
            [['seq', 'identifier', 'user_id', 'job_id', 'sender_id', 'subject', 'text'], 'required'],
            [['seq', 'user_id', 'job_id', 'sender_id'], 'integer'],
            [['text', 'status'], 'string'],
            [['created_on'], 'safe'],
            [['identifier'], 'string', 'max' => 25],
            [['subject'], 'string', 'max' => 250],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
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
            'seq' => Yii::t('app', 'Seq'),
            'identifier' => Yii::t('app', 'Identifier'),
            'user_id' => Yii::t('app', 'School ID'),
            'job_id' => Yii::t('app', 'Job ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'subject' => Yii::t('app', 'Subject'),
            'text' => Yii::t('app', 'Text'),
            'status' => Yii::t('app', 'Status'),
            'created_on' => Yii::t('app', 'Created On'),
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




}
