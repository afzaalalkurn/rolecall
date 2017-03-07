<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_subscriber".
 *
 * @property string $subscription_id
 * @property string $email
 */
class UserSubscriber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_subscriber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'string', 'max' => 100],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subscription_id' => 'Subscription ID',
            'email' => 'Email',
        ];
    }
}
