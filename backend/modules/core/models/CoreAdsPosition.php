<?php

namespace backend\modules\core\models;

use Yii;

/**
 * This is the model class for table "core_ads_position".
 *
 * @property integer $id
 * @property string $title
 * @property integer $width
 * @property integer $height
 * @property integer $size
 * @property integer $status
 *
 * @property UserAds[] $userAds
 */
class CoreAdsPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'core_ads_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'width', 'height', 'size', 'status'], 'required'],
            [['width', 'height', 'size', 'status'], 'integer'],
            [['title'], 'string', 'max' => 230],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'size' => Yii::t('app', 'Size'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAds()
    {
        return $this->hasMany(UserAds::className(), ['position_id' => 'id']);
    }
}
