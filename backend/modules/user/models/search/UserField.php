<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserField as UserFieldModel;

/**
 * UserField represents the model behind the search form about `backend\modules\user\models\UserField`.
 */
class UserField extends UserFieldModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_id', 'depend', 'order_by', 'is_searchable', 'is_serialize', 'status'], 'integer'],
            [['section','layout', 'field', 'name', 'type', 'validation'], 'safe'],
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
        $query = UserFieldModel::find();
         

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
            'order_by' => $this->order_by,
            'is_searchable' => $this->is_searchable,
            'status' => $this->status,
        ]);


        $query->andFilterWhere(['like', 'section', $this->section])
            ->andFilterWhere(['like', 'field', $this->field])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
