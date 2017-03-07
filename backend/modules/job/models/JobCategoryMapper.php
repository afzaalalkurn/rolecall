<?php

namespace backend\modules\job\models;

use Yii;
use backend\modules\user\models\UserJobCategoryMapper;

/**
 * This is the model class for table "job_category_mapper".
 *
 * @property string $job_id
 * @property string $category_id
 *
 * @property JobItem $job
 * @property JobCategory $category
 */
class JobCategoryMapper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_category_mapper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id', 'category_id'], 'required'],
            [['job_id', 'category_id'], 'integer'],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobItem::className(), 'targetAttribute' => ['job_id' => 'job_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobCategory::className(), 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'job_id' => 'Job ID',
            'category_id' => 'Category ID',
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
    public function getCategory()
    {
        return $this->hasOne(JobCategory::className(), ['category_id' => 'category_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */

    public function getUserJobCategoryMapper()
    {
        return $this->hasMany(UserJobCategoryMapper::className(), ['category_id' => 'category_id']);
    }
}
