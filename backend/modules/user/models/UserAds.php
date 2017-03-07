<?php

namespace backend\modules\user\models;

use Yii;

use backend\modules\core\models\CoreAdsPlan;
use backend\modules\core\models\CoreAdsPosition;


/**
 * This is the model class for table "user_ads".
 *
 * @property string $ad_id
 * @property string $user_id
 * @property string $transaction_id
 * @property string $position_id
 * @property string $plan_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $link
 * @property integer $status
 *
 * @property User $user
 * @property CoreAdsPosition $position
 * @property UserTransaction $userTransaction
 * @property CoreAdsPlan $plan
 */
class UserAds extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_ads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'transaction_id', 'position_id', 'plan_id', 'description'], 'required'],
            [['user_id', 'transaction_id', 'position_id', 'plan_id', 'status', 'request_remove'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 250],
            [['image', 'link'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoreAdsPosition::className(), 'targetAttribute' => ['position_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoreAdsPlan::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ad_id' => Yii::t('app', 'Ad ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'transaction_id' => Yii::t('app', 'Transaction ID'),
            'position_id' => Yii::t('app', 'Position ID'),
            'plan_id' => Yii::t('app', 'Plan ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'link' => Yii::t('app', 'Link'),
            'status' => Yii::t('app', 'Status'),
            'request_remove' => Yii::t('app', 'Request For Remove'),
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
    public function getPosition()
    {
        return $this->hasOne(CoreAdsPosition::className(), ['id' => 'position_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(CoreAdsPlan::className(), ['id' => 'plan_id']);
    }
}
