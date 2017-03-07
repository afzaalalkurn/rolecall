<?php

namespace backend\modules\core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\core\models\CoreAdsPlan as CoreAdsPlanModel;

/**
 * CoreAdsPlan represents the model behind the search form about `backend\modules\core\models\CoreAdsPlan`.
 */
class CoreAdsPlan extends CoreAdsPlanModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'frequency_interval', 'cycles', 'jobs', 'status', 'created_at'], 'integer'],
            [['paypal_plan_id', 'name', 'description', 'plan_type', 'payment_type', 'frequency', 'updated_at'], 'safe'],
            [['amount'], 'number'],
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
        $query = CoreAdsPlanModel::find();

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
            'id' => $this->id,
            'frequency_interval' => $this->frequency_interval,
            'cycles' => $this->cycles,
            'amount' => $this->amount,
            'jobs' => $this->jobs,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'paypal_plan_id', $this->paypal_plan_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'plan_type', $this->plan_type])
            ->andFilterWhere(['like', 'payment_type', $this->payment_type])
            ->andFilterWhere(['like', 'frequency', $this->frequency]);

        return $dataProvider;
    }
}
