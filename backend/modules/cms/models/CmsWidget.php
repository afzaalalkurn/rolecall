<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_widget".
 *
 * @property string $widget_id
 * @property string $widget
 * @property string $data
 *
 * @property CmsWidgetMapper[] $cmsWidgetMappers
 * @property CmsItem[] $cms
 */
class CmsWidget extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_widget';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget'], 'required'],
            [['data'], 'string'],
            [['widget'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'widget_id' => Yii::t('app', 'Widget ID'),
            'widget' => Yii::t('app', 'Widget'),
            'data' => Yii::t('app', 'Data'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsWidgetMappers()
    {
        return $this->hasMany(CmsWidgetMapper::className(), ['widget_id' => 'widget_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCms()
    {
        return $this->hasMany(CmsItem::className(), ['id' => 'cms_id'])->viaTable('cms_widget_mapper', ['widget_id' => 'widget_id']);
    }
}
