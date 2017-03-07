<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_address".
 *
 * @property string $user_id
 * @property string $location
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $address_line_3
 * @property string $pincode
 * @property string $latitude
 * @property string $longitude
 * @property string $is_primary
 *
 * @property User $user
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location'],'required'],
            [['latitude', 'longitude'], 'number'],
            [['is_primary'], 'string'],
            [['location'], 'string', 'max' => 250],
            [['address_line_1', 'address_line_2', 'address_line_3'], 'string', 'max' => 100],
            [['pincode'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'location' => 'Location',
            'address_line_1' => 'Address Line 1',
            'address_line_2' => 'Address Line 2',
            'address_line_3' => 'Address Line 3',
            'pincode' => 'Pincode',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'is_primary' => 'Is Primary',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
