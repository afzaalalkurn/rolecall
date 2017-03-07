<?php

namespace backend\modules\job\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\job\models\JobTransaction as JobTransactionModel;

/**
 * JobTransaction represents the model behind the search form about `backend\modules\job\models\JobTransaction`.
 */
class JobTransaction extends JobTransactionModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'job_id', 'expire_month', 'expire_year'], 'integer'],
            [['first_name', 'last_name', 'number', 'type', 'cvv2', 'data', 'dated'], 'safe'],
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
        $query = JobTransactionModel::find();

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
            'user_id' => $this->user_id,
            'job_id' => $this->job_id,
            'expire_month' => $this->expire_month,
            'expire_year' => $this->expire_year,
            'dated' => $this->dated,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'cvv2', $this->cvv2])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }

    public function searchPayment($params)
    {
        // add conditions that should always apply here
        $query = JobTransactionModel::find()->select(' count(job_id) as jobs , YEAR(dated) year, MONTHNAME(dated) month, ')->groupBy('MONTH(dated)')->andFilterWhere([' YEAR(dated) ' => date('Y'),]);

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
            'user_id' => $this->user_id,
            'job_id' => $this->job_id,
            'expire_month' => $this->expire_month,
            'expire_year' => $this->expire_year,
            'dated' => $this->dated,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'cvv2', $this->cvv2])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
