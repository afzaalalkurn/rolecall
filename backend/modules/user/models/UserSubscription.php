<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_subscription".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property string $create_date
 * @property string $modified_date
 */
class UserSubscription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['status'], 'integer'],
            [['create_date', 'modified_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
            'create_date' => 'Create Date',
            'modified_date' => 'Modified Date',
        ];
    }
}
