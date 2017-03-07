<?php

namespace backend\modules\job\models;

use Yii;

/**
 * This is the model class for table "job_category".
 *
 * @property string $category_id
 * @property string $name
 * @property string $description
 * @property string $modified_date
 * @property string $create_date
 *
 * @property JobCategoryFr $jobCategoryFr
 * @property JobCategoryMapper[] $jobCategoryMappers
 * @property JobItem[] $jobs
 * @property JobCategoryTemplate $jobCategoryTemplate
 * @property JobCategoryTemplateFr $jobCategoryTemplateFr
 * @property JobField[] $jobFields
 * @property UserJobCategoryMapper[] $userJobCategoryMappers
 * @property User[] $users
 */
class JobCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['modified_date', 'create_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => Yii::t('app', 'Category ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'modified_date' => Yii::t('app', 'Modified Date'),
            'create_date' => Yii::t('app', 'Create Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobCategoryFr()
    {
        return $this->hasOne(JobCategoryFr::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobCategoryMappers()
    {
        return $this->hasMany(JobCategoryMapper::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(JobItem::className(), ['job_id' => 'job_id'])->viaTable('job_category_mapper', ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobCategoryTemplate()
    {
        return $this->hasOne(JobCategoryTemplate::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobCategoryTemplateFr()
    {
        return $this->hasOne(JobCategoryTemplateFr::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobFields()
    {
        return $this->hasMany(JobField::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserJobCategoryMappers()
    {
        return $this->hasMany(UserJobCategoryMapper::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_job_category_mapper', ['category_id' => 'category_id']);
    }
}
