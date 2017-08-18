<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_field_option".
 *
 * @property integer $option_id
 * @property integer $parent_id
 * @property integer $field_id
 * @property string $name
 * @property string $value
 *
 * @property UserField $field
 * @property UserFieldOption $parent
 * @property UserFieldOption[] $userFieldOptions
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
            [['parent_id', 'field_id'], 'integer'],
            [['name', 'value'], 'string', 'max' => 100],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserField::className(), 'targetAttribute' => ['field_id' => 'field_id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserFieldOption::className(), 'targetAttribute' => ['parent_id' => 'option_id']],
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
            'parent_id' => 'Parent ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(UserFieldOption::className(), ['option_id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFieldOptions()
    {
        return $this->hasMany(UserFieldOption::className(), ['parent_id' => 'option_id']);
    }
}
