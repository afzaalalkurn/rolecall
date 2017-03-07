<?php

namespace backend\modules\user\models;

use backend\modules\core\models\CorePlan;
use Yii;

/**
 * This is the model class for table "user_school".
 *
 * @property string $user_id
 * @property string $plan_id
 * @property string $name
 * @property string $logo
 * @property string $cover_photo
 * @property string $description
 * @property string $location
 * @property string $zipcode
 *
 * @property User $user
 * @property CorePlan $plan
 */
class UserSchool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_school';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'logo', 'cover_photo', 'location'], 'string', 'max' => 250],
            [['zipcode'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => CorePlan::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'plan_id' => 'Plan',
            'name' => 'Name',
            'logo' => 'Logo',
            'cover_photo' => 'Cover Photo',
            'description' => 'Description',
            'location' => 'Location',
            'zipcode' => 'Zipcode',
        ];
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
    public function getPlan()
    {
        return $this->hasOne(CorePlan::className(), ['id' => 'plan_id']);
    }
}
