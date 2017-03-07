<?php

namespace backend\modules\cms\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\cms\models\CmsMenuPath as CmsMenuPathModel;

/**
 * CmsMenuPath represents the model behind the search form about `backend\modules\cms\models\CmsMenuPath`.
 */
class CmsMenuPath extends CmsMenuPathModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'parent_id', 'level'], 'integer'],
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
        $query = CmsMenuPathModel::find();

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
            'menu_id' => $this->menu_id,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
        ]);

        return $dataProvider;
    }
    public function getCategories($data = array()) {


        $query = self::find()->select("cms_menu_path.menu_id AS id, GROUP_CONCAT(cd1.`name` ORDER BY cms_menu_path.`level` ASC SEPARATOR ' > ') AS `text` , c1.parent_id, c1.order, cd2.`name` ")
            ->join('LEFT JOIN', 'cms_menu c1', 'cms_menu_path.menu_id = c1.menu_id')
            ->join('LEFT JOIN', 'cms_menu c2', 'cms_menu_path.parent_id = c2.menu_id')
            ->join('LEFT JOIN', 'cms_menu cd1', 'cms_menu_path.parent_id = cd1.menu_id')
            ->join('LEFT JOIN', 'cms_menu cd2', 'cms_menu_path.menu_id = cd2.menu_id')
            ->groupBy(['cms_menu_path.menu_id']);

        if(isset($data['name'])){
            $query->andFilterWhere(['like', 'cd2.`name`', $data['name']])   ;
        }

        return $query;
    }

    public function getItemPath($menu_id) {

        return self::find()->select('*')
            ->andFilterWhere(['menu_id' => $menu_id,])
            ->orderBy(['level' => SORT_ASC]);
    }

    public function getItemPathLevel($menu_id) {

        return self::find()->select('*')
            ->andFilterWhere(['parent_id' => $menu_id,])
            ->orderBy(['level' => SORT_ASC]);
    }
}
