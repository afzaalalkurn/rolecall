<?php

namespace backend\modules\job\models;

use Yii;

/**
 * This is the model class for table "job_field".
 *
 * @property string $field_id
 * @property string $category_id
 * @property string $field
 * @property string $name
 * @property string $type
 * @property string $is_serialize
 * @property integer $status
 *
 * @property JobCategory $category
 * @property JobFieldOption[] $jobFieldOptions
 * @property JobFieldValue[] $jobFieldValues
 * @property JobItem[] $jobs
 */
class JobField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'depend', 'status', 'order_by','is_serialize', 'is_searchable'], 'integer'],
            [['section', 'type', 'for_gender'], 'string'],
            [['layout', 'field', 'name', 'validation'], 'string', 'max' => 100],
            [['category_id'], 'exist', 'skipOnError' => true,
                'targetClass' => JobCategory::className(),
                'targetAttribute' => ['category_id' => 'category_id']],
            [['depend'], 'exist', 'skipOnError' => true,
                'targetClass' => JobField::className(),
                'targetAttribute' => ['depend' => 'field_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'field_id' => Yii::t('app', 'Field ID'),
            'depend' => Yii::t('app', 'Depend'),
            'section' => Yii::t('app', 'Section'),
            'category_id' => Yii::t('app', 'Category ID'),
            'field' => Yii::t('app', 'Field'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'is_searchable' => Yii::t('app', 'Searchable'),
            'is_serialize' => Yii::t('app', 'Is Serialize'),
            'for_gender' => Yii::t('app', 'For Gender'),
            'order_by' => Yii::t('app', 'Order By'),
            'validation' => Yii::t('app', 'Validation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(JobCategory::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobFieldOptions()
    {
        return $this->hasMany(JobFieldOption::className(), ['field_id' => 'field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobFieldValues()
    {
        return $this->hasMany(JobFieldValue::className(), ['field_id' => 'field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(JobItem::className(), ['job_id' => 'job_id'])->viaTable('job_field_value', ['field_id' => 'field_id']);
    }
}
