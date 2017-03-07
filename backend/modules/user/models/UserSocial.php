<?php

namespace backend\modules\user\models;

use Yii;
use backend\modules\core\models\CoreSocialNetwork;

/**
 * This is the model class for table "user_social".
 *
 * @property string $user_id
 * @property string $network_id
 * @property string $name
 * @property string $link
 * @property string $access_key
 *
 * @property User $user
 * @property CoreSocialNetwork $network
 */
class UserSocial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_social';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'user_id',*/ 'network_id'], 'required'],
            [['user_id', 'network_id'], 'integer'],
            [['name', 'link', 'access_key'], 'string', 'max' => 200],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['network_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoreSocialNetwork::className(), 'targetAttribute' => ['network_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'network_id' => 'Network ID',
            'name' => 'Name',
            'link' => 'Link',
            'access_key' => 'Access Key',
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
    public function getNetwork()
    {
        return $this->hasOne(CoreSocialNetwork::className(), ['id' => 'network_id']);
    }
}
