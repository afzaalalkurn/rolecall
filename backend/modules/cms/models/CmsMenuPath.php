<?php

namespace backend\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_menu_path".
 *
 * @property string $category_id
 * @property string $parent_id
 * @property integer $level
 */
class CmsMenuPath extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_menu_path';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'parent_id', 'level'], 'required'],
            [['menu_id', 'parent_id', 'level'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => Yii::t('app', 'Menu ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'level' => Yii::t('app', 'Level'),
        ];
    }
}
