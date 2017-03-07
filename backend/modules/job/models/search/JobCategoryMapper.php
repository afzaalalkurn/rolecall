<?php

namespace backend\modules\job\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\job\models\JobCategoryMapper as JobCategoryMapperModel;

/**
 * JobCategoryMapper represents the model behind the search form about `backend\modules\job\models\JobCategoryMapper`.
 */
class JobCategoryMapper extends JobCategoryMapperModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id', 'category_id'], 'integer'],
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
        $query = JobCategoryMapperModel::find();

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
            'job_id' => $this->job_id,
            'category_id' => $this->category_id,
        ]);

        return $dataProvider;
    }
}
