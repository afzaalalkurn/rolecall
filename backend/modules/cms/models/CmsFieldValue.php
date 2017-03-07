<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_field_value".
 *
 * @property string $value_id
 * @property string $cms_id
 * @property string $field_id
 * @property string $value
 *
 * @property CmsItem $cms
 * @property CmsField $field
 */
class CmsFieldValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_field_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_id', 'field_id', 'value'], 'required'],
            [['cms_id', 'field_id'], 'integer'],
            [['value'], 'string', 'max' => 250],
            [['cms_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsItem::className(), 'targetAttribute' => ['cms_id' => 'id']],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsField::className(), 'targetAttribute' => ['field_id' => 'field_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'value_id' => Yii::t('app', 'Value ID'),
            'cms_id' => Yii::t('app', 'Cms ID'),
            'field_id' => Yii::t('app', 'Field ID'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCms()
    {
        return $this->hasOne(CmsItem::className(), ['id' => 'cms_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(CmsField::className(), ['field_id' => 'field_id']);
    }
}
