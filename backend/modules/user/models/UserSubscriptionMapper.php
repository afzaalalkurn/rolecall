<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_subscription_mapper".
 *
 * @property string $subscription_id
 * @property string $email
 */
class UserSubscriptionMapper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_subscription_mapper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'string', 'max' => 100],
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
