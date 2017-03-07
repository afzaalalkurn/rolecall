<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_block".
 *
 * @property string $block_id
 * @property string $name
 * @property string $contents
 *
 * @property CmsBlockMapper[] $cmsBlockMappers
 * @property CmsItem[] $cms
 */
class CmsBlock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contents'], 'string'],
            [['name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'block_id' => Yii::t('app', 'Block ID'),
            'name' => Yii::t('app', 'Name'),
            'contents' => Yii::t('app', 'Contents'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsBlockMappers()
    {
        return $this->hasMany(CmsBlockMapper::className(), ['block_id' => 'block_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCms()
    {
        return $this->hasMany(CmsItem::className(), ['id' => 'cms_id'])->viaTable('cms_block_mapper', ['block_id' => 'block_id']);
    }
}
