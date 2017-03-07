<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserSchool as UserSchoolModel;

/**
 * UserSchool represents the model behind the search form about `backend\modules\user\models\UserSchool`.
 */
class UserSchool extends UserSchoolModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['name', 'logo', 'cover_photo', 'description', 'location', 'zipcode'], 'safe'],
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
        $query = UserSchoolModel::find();

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
            'user_id' => $this->user_id,
        ]);

        $names = explode(' ',$this->name);
        if(count($names) > 0){
            foreach($names as $name){
                if(!empty($name)){
                    $query->orFilterWhere(['like', 'name', $name]);
                }
            }
        }else{
            $query->andFilterWhere(['like', 'name', $this->name]);
        }
        $query->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'cover_photo', $this->cover_photo])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'location', $this->location]);
        return $dataProvider;
    }
}
