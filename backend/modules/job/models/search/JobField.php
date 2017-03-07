<?php

namespace backend\modules\job\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\job\models\JobField as JobFieldModel;

/**
 * JobField represents the model behind the search form about `backend\modules\job\models\JobField`.
 */
class JobField extends JobFieldModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_id', 'category_id', 'status', 'is_searchable', 'is_serialize'], 'integer'],
            [['field', 'name', 'type'], 'safe'],
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
        $query = JobFieldModel::find();

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
            'field_id' => $this->field_id,
            'category_id' => $this->category_id,
            'is_searchable' => $this->is_searchable,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'field', $this->field])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
