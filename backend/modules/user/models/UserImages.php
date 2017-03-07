<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "user_images".
 *
 * @property string $image_id
 * @property string $user_id
 * @property string $image
 * @property string $order_by
 */
class UserImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'image'], 'required'],
            [['user_id', 'order_by'], 'integer'],
            [['image'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_id' => 'Image ID',
            'user_id' => 'User ID',
            'image' => 'Image',
            'order_by' => 'Order By',
        ];
    }
}
