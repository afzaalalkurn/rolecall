<?php

namespace backend\modules\cms\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\cms\models\CmsCategoryPath as CmsCategoryPathModel;

/**
 * CmsCategoryPath represents the model behind the search form about `backend\modules\cms\models\CmsCategoryPath`.
 */
class CmsCategoryPath extends CmsCategoryPathModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'parent_id', 'level'], 'integer'],
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
        $query = CmsCategoryPathModel::find();

        // add conditions that should always apply here

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
            'category_id' => $this->category_id,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
        ]);

        return $dataProvider;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function getCategories($data = array()) {


        $query = self::find()->select("cms_category_path.category_id AS id, GROUP_CONCAT(cd1.`name` ORDER BY cms_category_path.`level` ASC SEPARATOR ' > ') AS `text` , c1.parent_id, c1.sort_order, cd2.`name` ")
            ->join('LEFT JOIN', 'cms_category c1', 'cms_category_path.category_id = c1.category_id')
            ->join('LEFT JOIN', 'cms_category c2', 'cms_category_path.parent_id = c2.category_id')
            ->join('LEFT JOIN', 'cms_category cd1', 'cms_category_path.parent_id = cd1.category_id')
            ->join('LEFT JOIN', 'cms_category cd2', 'cms_category_path.category_id = cd2.category_id')
            ->groupBy(['cms_category_path.category_id']);

        if(isset($data['name'])){
            $query->andFilterWhere(['like', 'cd2.`name`', $data['name']])   ;
        }

        return $query;
    }

    public function getItemPath($category_id) {

        return self::find()->select('*')
            ->andFilterWhere(['category_id' => $category_id,])
            ->orderBy(['level' => SORT_ASC]);
    }

    public function getItemPathLevel($category_id) {

        return self::find()->select('*')
            ->andFilterWhere(['parent_id' => $category_id,])
            ->orderBy(['level' => SORT_ASC]);
    }
}
