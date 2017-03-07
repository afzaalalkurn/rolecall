<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserNews as UserNewsModel;

/**
 * UserNews represents the model behind the search form about `backend\modules\user\models\UserNews`.
 */
class UserNews extends UserNewsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status'], 'integer'],
            [['name', 'description', 'create_date', 'modified_date', 'publish_date'], 'safe'],
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
        $query = UserNewsModel::find();

        // add conditions that should always apply here

        $_field = 'user_news.id, user_news.user_id, user_news.name, user_news.description, user_news.status, user_news.create_date, user_news.modified_date, user_news.publish_date';


        $query->select($_field);

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
            'user_news.id' => $this->id,
            'user_news.user_id' => $this->user_id,
            'user_news.status' => $this->status,
            'create_date' => $this->create_date,
            'modified_date' => $this->modified_date,
            'publish_date' => $this->publish_date,
        ]);

            $query->andFilterWhere(['like', 'user_news.name', $this->name])
                ->andFilterWhere(['like', 'user_news.description', $this->description]);



        return $dataProvider;
    }
}
