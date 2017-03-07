<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_news".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property string $create_date
 * @property string $modified_date
 * @property string $publish_date
 */
class UserNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['create_date', 'modified_date', 'publish_date'], 'safe'],
            [['name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'create_date' => Yii::t('app', 'Create Date'),
            'modified_date' => Yii::t('app', 'Modified Date'),
            'publish_date' => Yii::t('app', 'Publish Date'),
        ];
    }
}
