<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserAds as UserAdsModel;

/**
 * UserAds represents the model behind the search form about `backend\modules\user\models\UserAds`.
 */
class UserAds extends UserAdsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_id', 'user_id', 'transaction_id', 'position_id', 'plan_id', 'status', 'request_remove'], 'integer'],
            [['name', 'description', 'image', 'link'], 'safe'],
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
        $query = UserAdsModel::find();

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
            'ad_id' => $this->ad_id,
            'user_id' => $this->user_id,
            'transaction_id' => $this->transaction_id,
            'position_id' => $this->position_id,
            'plan_id' => $this->plan_id,
            'status' => $this->status,
            'request_remove' => $this->request_remove,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
