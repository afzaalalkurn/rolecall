<?php

namespace backend\modules\job\models;

use Yii;

/**
 * This is the model class for table "job_field_option".
 *
 * @property integer $option_id
 * @property integer $parent_id
 * @property integer $field_id
 * @property string $name
 * @property string $value
 *
 * @property JobField $field
 * @property JobFieldOption $parent
 * @property JobFieldOption[] $jobFieldOptions
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
                [['parent_id', 'field_id'], 'integer'],
                [['name', 'value'], 'string', 'max' => 100],
                [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobField::className(), 'targetAttribute' => ['field_id' => 'field_id']],
                [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobFieldOption::className(), 'targetAttribute' => ['parent_id' => 'option_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id' => Yii::t('app', 'Option ID'),
            'parent_id' => Yii::t('app', 'Parent'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(JobFieldOption::className(), ['option_id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobFieldOptions()
    {
        return $this->hasMany(JobFieldOption::className(), ['parent_id' => 'option_id']);
    }
}
