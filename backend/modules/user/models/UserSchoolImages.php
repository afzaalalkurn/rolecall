<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_school_images".
 *
 * @property string $image_id
 * @property string $user_id
 * @property string $image
 * @property string $order_by
 *
 * @property User $user
 */
class UserSchoolImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_school_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpeg, gif, png', 'maxFiles' => 10],
            [['user_id', 'order_by'], 'integer'],
            [['image'], 'string', 'max' => 200],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_id' => Yii::t('app', 'Image ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'image' => Yii::t('app', 'Image'),
            'order_by' => Yii::t('app', 'Order By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
