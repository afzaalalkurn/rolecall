<?php

namespace backend\modules\job\models;

    use backend\modules\user\models\UserMsg;
    use backend\modules\user\models\UserNotification;
    use Yii;

use backend\modules\user\models\User;
/**
 * This is the model class for table "job_item".
 *
 * @property string $job_id
 * @property string $user_id
 * @property string $name
 * @property string $requirement
 * @property string $logo
 * @property string $description
 * @property string $responsibility
 * @property string $about
 * @property string $ref_url
 * @property integer $is_featured
 * @property integer $status
 * @property string $fee
 * @property string $renewal
 * @property string $expire_date
 * @property string $create_dated
 * @property string $modified_dated
 *
 * @property JobCategoryMapper[] $jobCategoryMappers
 * @property JobCategory[] $categories
 * @property JobFieldValue[] $jobFieldValues
 * @property User $user

 * @property JobTransaction[] $jobTransactions
 * @property JobUserMapper[] $jobUserMappers
 * @property UserMsg[] $userMsgs
 * @property UserNotification[] $userNotifications
 */
class JobItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $job_categories = [];
    public $job_category;
    public $school_name;
    public $zipcode;

    public static function tableName()
    {
        return 'job_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['user_id', 'name','location'], 'required'],
                [['create_dated'], 'required','message' => 'Start Date cannot be blank'],
                [['expire_date'], 'required','message' => 'End Date cannot be blank'],
                [['user_id', 'is_featured', 'status','radius','is_archive'], 'integer'],
                [['latitude', 'longitude'], 'number'],
                [['requirement', 'description', 'location'], 'string'],
                [['expire_date', 'create_dated', 'modified_dated'], 'safe'],
                [['name'], 'string', 'max' => 255],
                [['logo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpeg, jpg, gif, png'],
                [['ref_url'],'url'],
                [['ref_url'], 'string', 'max' => 250],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'job_id' => Yii::t('app', 'Job ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'requirement' => Yii::t('app', 'Requirement (Education/Skills)'),
            'logo' => Yii::t('app', 'Logo (200X200)'),
            'description' => Yii::t('app', 'Description'),
            'location' => Yii::t('app', 'Location'),
            'radius' => Yii::t('app', 'Radius'),
            'longitude' => Yii::t('app', 'Longitude'),
            'latitude' => Yii::t('app', 'Latitude'),
            'ref_url' => Yii::t('app', 'Ref Url'),
            'is_featured' => Yii::t('app', 'Is Featured'),
            'status' => Yii::t('app', 'Status'),
            'expire_date' => Yii::t('app', 'Expire Date'),
            'create_dated' => Yii::t('app', 'Create Dated'),
            'modified_dated' => Yii::t('app', 'Modified Dated'),
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobCategoryMappers()
    {
        return $this->hasMany(JobCategoryMapper::className(), ['job_id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(JobCategory::className(), ['category_id' => 'category_id'])->viaTable('job_category_mapper', ['job_id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobFieldValues()
    {
        return $this->hasMany(JobFieldValue::className(), ['job_id' => 'job_id']);
    }

    public function getJobFieldValue($field){

        foreach($this->jobFieldValues as $jobFieldValue){

            if($jobFieldValue->field->field ==  $field){

                switch($jobFieldValue->field->type){
                    case 'MultiList':
                        if($jobFieldValue->field->is_serialize == 1){
                            return ( $data = @unserialize($jobFieldValue->value)) ? /*implode(', ',$data)*/ $data[0]: $jobFieldValue->value;
                        }else{
                            return trim($jobFieldValue->value) ?? Yii::t('job', 'Not Given');
                        }
                        break;
                    case 'List':
                        if($jobFieldValue->value == 'Other'){
                            foreach ($jobFieldValue->field->jobFields as $field){
                                foreach($field->jobFieldValues as $value){
                                    return $value->value;
                                }
                            }
                        }else{
                            return $jobFieldValue->value;
                        }
                        break;
                    case 'Text':
                        return $jobFieldValue->value;
                        break;
                    default:
                }
            }
        }
        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobTransactions()
    {
        return $this->hasMany(JobTransaction::className(), ['job_id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobUserMappers()
    {
        return $this->hasMany(JobUserMapper::className(), ['job_id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMsgs()
    {
        return $this->hasMany(UserMsg::className(), ['job_id' => 'job_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotifications()
    {
        return $this->hasMany(UserNotification::className(), ['job_id' => 'job_id']);
    }

}
