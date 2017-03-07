<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_newsletter".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property string $create_date
 * @property string $modified_date
 */
class UserNewsletter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_newsletter';
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
