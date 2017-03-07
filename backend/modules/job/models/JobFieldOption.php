<?php

namespace backend\modules\job\models;

use Yii;

/**
 * This is the model class for table "job_field_option".
 *
 * @property string $option_id
 * @property string $field_id
 * @property string $name
 * @property string $value
 *
 * @property JobField $field
 */
class JobFieldOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_field_option';
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        
        return [
                [['field_id'], 'integer'],
                [['name', 'value'], 'string', 'max' => 100],
                [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobField::className(), 'targetAttribute' => ['field_id' => 'field_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id' => Yii::t('app', 'Option ID'),
            'field_id' => Yii::t('app', 'Field ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(JobField::className(), ['field_id' => 'field_id']);
    }
}
