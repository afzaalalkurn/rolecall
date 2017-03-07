<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_keyword".
 *
 * @property string $keyword_id
 * @property string $name
 *
 * @property CmsRelation[] $cmsRelations
 * @property CmsItem[] $cms
 */
class CmsKeyword extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_keyword';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'keyword_id' => Yii::t('app', 'Keyword ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsRelations()
    {
        return $this->hasMany(CmsRelation::className(), ['keyword_id' => 'keyword_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCms()
    {
        return $this->hasMany(CmsItem::className(), ['id' => 'cms_id'])->viaTable('cms_relation', ['keyword_id' => 'keyword_id']);
    }
}
