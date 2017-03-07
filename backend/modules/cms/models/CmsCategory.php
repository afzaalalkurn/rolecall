<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_category".
 *
 * @property string $category_id
 * @property string $parent_id
 * @property string $name
 * @property string $description
 * @property integer $sort_order
 * @property string $modified_date
 * @property string $create_date
 *
 * @property CmsCategoryMapper[] $cmsCategoryMappers
 * @property CmsItem[] $cms
 * @property CmsCategoryPath[] $cmsCategoryPaths
 * @property CmsCategoryPath[] $cmsCategoryPaths0
 * @property CmsCategory[] $parents
 * @property CmsCategory[] $categories
 * @property CmsField[] $cmsFields
 */
class CmsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort_order'], 'integer'],
            [['description'], 'string'],
            [['modified_date', 'create_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => Yii::t('app', 'Category ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'modified_date' => Yii::t('app', 'Modified Date'),
            'create_date' => Yii::t('app', 'Create Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsCategoryMappers()
    {
        return $this->hasMany(CmsCategoryMapper::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCms()
    {
        return $this->hasMany(CmsItem::className(), ['id' => 'cms_id'])->viaTable('cms_category_mapper', ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsCategoryPaths()
    {
        return $this->hasMany(CmsCategoryPath::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsCategoryPaths0()
    {
        return $this->hasMany(CmsCategoryPath::className(), ['parent_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(CmsCategory::className(), ['category_id' => 'parent_id'])->viaTable('cms_category_path', ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(CmsCategory::className(), ['category_id' => 'category_id'])->viaTable('cms_category_path', ['parent_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsFields()
    {
        return $this->hasMany(CmsField::className(), ['category_id' => 'category_id']);
    }
}
