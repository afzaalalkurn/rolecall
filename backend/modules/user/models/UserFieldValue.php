<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_field_value".
 *
 * @property string $value_id
 * @property string $user_id
 * @property string $field_id
 * @property string $value
 *
 * @property User $user
 * @property UserField $field
 */
class UserFieldValue extends \yii\db\ActiveRecord
{
    const SECTION_PHOTOS = 'Talent Photos';
    const SECTION_TALENT_OVERVIEW = 'Talent Overview';
    const SECTION_OTHER = '';
    const SECTION_TALENT_APPEARANCE = 'Talent Appearance';
    const SECTION_VEHICLE_PICTURES = 'Vehicle Pictures';
    const SECTION_VEHICLE_APPEARANCE = 'Vehicle Appearance';

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'user_field_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           /* [['user_id', 'field_id'], 'required'],*/
            [['user_id', 'field_id'], 'integer'],
            //[['value'], 'string', 'max' => 250],
            ['value', 'each', 'rule' => ['string']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserField::className(), 'targetAttribute' => ['field_id' => 'field_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'value_id' => 'Value ID',
            'user_id' => 'User ID',
            'field_id' => 'Field ID',
            'value' => 'Value',
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
    public function getField()
    {
        return $this->hasOne(UserField::className(), ['field_id' => 'field_id']);
    }
}
