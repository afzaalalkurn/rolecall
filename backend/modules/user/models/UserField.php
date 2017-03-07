<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_field".
 *
 * @property string $field_id
 * @property string $depend
 * @property string $section
 * @property string $layout
 * @property string $field
 * @property string $name
 * @property string $type
 * @property string $order_by
 * @property string $validation
 * @property integer $is_searchable
 * @property integer $is_serialize
 * @property string $for_gender
 * @property integer $status
 *
 * @property UserField $depend0
 * @property UserField[] $userFields
 * @property UserFieldOption[] $userFieldOptions
 * @property UserFieldValue[] $userFieldValues
 */
class UserField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['depend', 'order_by', 'is_searchable', 'is_serialize', 'status'], 'integer'],
            [['section', 'type', 'for_gender'], 'string'],
            [['layout', 'field', 'name', 'validation'], 'string', 'max' => 100],
            [['depend'], 'exist', 'skipOnError' => true,
                'targetClass' => UserField::className(),
                'targetAttribute' => ['depend' => 'field_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'field_id' => 'Field ID',
            'depend' => 'Depend',
            'section' => 'Section',
            'layout' => 'Layout',
            'field' => 'Field',
            'name' => 'Name',
            'type' => 'Type',
            'order_by' => 'Order By',
            'validation' => 'Validation',
            'is_searchable' => 'Is Searchable',
            'is_serialize' => 'Is Serialize',
            'for_gender' => 'For Gender',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepend0()
    {
        return $this->hasOne(UserField::className(), ['field_id' => 'depend']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFields()
    {
        return $this->hasMany(UserField::className(), ['depend' => 'field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFieldOptions()
    {
        return $this->hasMany(UserFieldOption::className(), ['field_id' => 'field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFieldValues()
    {
        return $this->hasMany(UserFieldValue::className(), ['field_id' => 'field_id']);
    }
}
