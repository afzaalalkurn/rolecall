<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_widget_mapper".
 *
 * @property string $widget_id
 * @property string $cms_id
 * @property string $order_by
 *
 * @property CmsWidget $widget
 * @property CmsItem $cms
 */
class CmsWidgetMapper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_widget_mapper';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_id', 'cms_id', 'order_by'], 'required'],
            [['widget_id', 'cms_id', 'order_by'], 'integer'],
            [['widget_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsWidget::className(), 'targetAttribute' => ['widget_id' => 'widget_id']],
            [['cms_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsItem::className(), 'targetAttribute' => ['cms_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'widget_id' => Yii::t('app', 'Widget ID'),
            'cms_id' => Yii::t('app', 'Cms ID'),
            'order_by' => Yii::t('app', 'Order By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidget()
    {
        return $this->hasOne(CmsWidget::className(), ['widget_id' => 'widget_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCms()
    {
        return $this->hasOne(CmsItem::className(), ['id' => 'cms_id']);
    }
}
