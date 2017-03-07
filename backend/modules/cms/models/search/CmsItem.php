<?php

namespace backend\modules\cms\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\cms\models\CmsItem as CmsItemModel;

/**
 * CmsItem represents the model behind the search form about `backend\modules\cms\models\CmsItem`.
 */
class CmsItem extends CmsItemModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'layout_id', 'restricted', 'status'], 'integer'],
            [['slug', 'external_url', 'title', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'create_date', 'modified_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CmsItemModel::find();

       /* $_field = 'cms_item.id,cms_item.parent_id,cms_item.layout_id,cms_item.slug,cms_item.external_url,cms_item.title,cms_item.content,cms_item.restricted,cms_item.status, cms_item.meta_title,cms_item.meta_description,cms_item.meta_keywords,cms_item.create_date,cms_item.modified_date';

        if(Yii::$app->language == 'fr'){
            $query->join('LEFT JOIN', 'cms_item_fr', 'cms_item_fr.id = cms_item.id');
            $_field .=',
                IF(`cms_item_fr`.`title`         <> "", `cms_item_fr`.`title`, `cms_item`.`title` ) as title,
                IF(`cms_item_fr`.`content`  <> "", `cms_item_fr`.`content`, `cms_item`.`content` ) as content,
                IF(`cms_item_fr`.`meta_title`  <> "", `cms_item_fr`.`meta_title`, `cms_item`.`meta_title` ) as meta_title,
                IF(`cms_item_fr`.`meta_description`  <> "", `cms_item_fr`.`meta_description`, `cms_item`.`meta_description` ) as meta_description,
                IF(`cms_item_fr`.`meta_keywords`  <> "", `cms_item_fr`.`meta_keywords`, `cms_item`.`meta_keywords` ) as meta_keywords';
        }
        // add conditions that should always apply here
        $query->select($_field);*/
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'layout_id' => $this->layout_id,
            'restricted' => $this->restricted,
            'status' => $this->status,
            'create_date' => $this->create_date,
            'modified_date' => $this->modified_date,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'external_url', $this->external_url])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords]);

        return $dataProvider;
    }


}
