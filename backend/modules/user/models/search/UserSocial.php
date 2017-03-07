    <?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserSocial as UserSocialModel;

/**
 * UserSocial represents the model behind the search form about `backend\modules\user\models\UserSocial`.
 */
class UserSocial extends UserSocialModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'network_id'], 'integer'],
            [['name', 'link', 'access_key'], 'safe'],
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
        $query = UserSocialModel::find();

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
            'network_id' => $this->network_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->network])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'access_key', $this->access_key]);

        return $dataProvider;
    }
}
