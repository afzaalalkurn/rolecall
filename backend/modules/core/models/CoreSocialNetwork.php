<?php

namespace backend\modules\core\models;

use Yii;

/**
 * This is the model class for table "core_social_network".
 *
 * @property string $id
 * @property string $network
 * @property string $icons
 * @property string $image
 * @property string $thumb
 * @property integer $status
 *
 * @property UserSocial[] $userSocials
 * @property User[] $users
 */
class CoreSocialNetwork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'core_social_network';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['network'], 'required'],
            [['status'], 'integer'],
            [['network'], 'string', 'max' => 200],
            [['icons', 'image', 'thumb'], 'file', 'skipOnEmpty' => true, 'extensions' => 'ico, png, jpg, jpeg, gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'network' => 'Network',
            'icons' => 'Icons',
            'image' => 'Image',
            'thumb' => 'Thumb',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSocials()
    {
        return $this->hasMany(UserSocial::className(), ['network_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_social', ['network_id' => 'id']);
    }
}
