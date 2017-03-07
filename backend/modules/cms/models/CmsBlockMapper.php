<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_block_mapper".
 *
 * @property string $block_id
 * @property string $cms_id
 * @property string $order_by
 *
 * @property CmsBlock $block
 * @property CmsItem $cms
 */
class CmsBlockMapper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_block_mapper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['block_id', 'cms_id', 'order_by'], 'required'],
            [['block_id', 'cms_id', 'order_by'], 'integer'],
            [['block_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsBlock::className(), 'targetAttribute' => ['block_id' => 'block_id']],
            [['cms_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsItem::className(), 'targetAttribute' => ['cms_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'block_id' => Yii::t('app', 'Block ID'),
            'cms_id' => Yii::t('app', 'Cms ID'),
            'order_by' => Yii::t('app', 'Order By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(CmsBlock::className(), ['block_id' => 'block_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCms()
    {
        return $this->hasOne(CmsItem::className(), ['id' => 'cms_id']);
    }
}
