<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_field_option".
 *
 * @property string $option_id
 * @property string $field_id
 * @property string $name
 * @property string $value
 *
 * @property UserField $field
 */
class UserFieldOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_field_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_id'], 'integer'],
            [['name', 'value'], 'string', 'max' => 100],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserField::className(), 'targetAttribute' => ['field_id' => 'field_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id' => 'Option ID',
            'field_id' => 'Field ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(UserField::className(), ['field_id' => 'field_id']);
    }
}
