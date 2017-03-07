<?php

namespace backend\modules\job\models;

use Yii;

/**
 * This is the model class for table "job_field_value".
 *
 * @property string $value_id
 * @property string $job_id
 * @property string $field_id
 * @property string $value
 *
 * @property JobItem $job
 * @property JobField $field
 */
class JobFieldValue extends \yii\db\ActiveRecord
{
    const SECTION_PROJECT_OVERVIEW = "Project Overview";
    const SECTION_OTHER = "";
    const SECTION_ROLE_OVERVIEW = "Role Overview";
    const SECTION_TALENT_APPEARANCE = "Talent Appearance";
    const SECTION_VEHICLE_APPEARANCE = "Vehicle Appearance";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_field_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /*[['job_id', 'field_id', 'value'], 'required'],*/
            [['job_id', 'field_id'], 'integer'],
            ['value', 'each', 'rule' => ['string']],
            //['value' , 'filter', 'filter' => 'trim'],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobItem::className(), 'targetAttribute' => ['job_id' => 'job_id']],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobField::className(), 'targetAttribute' => ['field_id' => 'field_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'value_id' => Yii::t('app', 'Value ID'),
            'job_id' => Yii::t('app', 'Job ID'),
            'field_id' => Yii::t('app', 'Field ID'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(JobItem::className(), ['job_id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(JobField::className(), ['field_id' => 'field_id']);
    }
}
