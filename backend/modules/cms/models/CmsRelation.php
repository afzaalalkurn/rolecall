<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_relation".
 *
 * @property string $cms_id
 * @property string $keyword_id
 *
 * @property CmsItem $cms
 * @property CmsKeyword $keyword
 */
class CmsRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_id', 'keyword_id'], 'required'],
            [['cms_id', 'keyword_id'], 'integer'],
            [['cms_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsItem::className(), 'targetAttribute' => ['cms_id' => 'id']],
            [['keyword_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsKeyword::className(), 'targetAttribute' => ['keyword_id' => 'keyword_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cms_id' => Yii::t('app', 'Cms ID'),
            'keyword_id' => Yii::t('app', 'Keyword ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCms()
    {
        return $this->hasOne(CmsItem::className(), ['id' => 'cms_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKeyword()
    {
        return $this->hasOne(CmsKeyword::className(), ['keyword_id' => 'keyword_id']);
    }
}
