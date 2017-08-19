<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider; 

/**
 * School represents the model behind the search form about `backend\modules\user\models\User`.
 */
class Director extends User
{
    public $is_deleted;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'is_deleted'], 'safe'],
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
          $query = User::find();
          $query->join('inner join', 'user_profile', 'user_profile.user_id = id');
          $query->join('inner join','auth_assignment','auth_assignment.user_id = id')->where(['auth_assignment.item_name' => self::ROLE_DIRECTOR]);

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '`user_profile`.`is_deleted`' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

    public function getCount()
    {
        $query = User::find();
        $query->join('inner join', 'auth_assignment', 'auth_assignment.user_id = id')->where(['auth_assignment.item_name' => self::ROLE_DIRECTOR]);

        return $query->count();
    }
}
