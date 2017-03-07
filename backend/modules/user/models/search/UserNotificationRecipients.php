<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserNotificationRecipients as UserNotificationRecipientsModel;

/**
 * UserNotificationRecipients represents the model behind the search form about `backend\modules\user\models\UserNotificationRecipients`.
 */
class UserNotificationRecipients extends UserNotificationRecipientsModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'seq', 'recipient_id', 'time'], 'integer'],
            [['ip', 'status'], 'safe'],
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
        $query = UserNotificationRecipientsModel::find();

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
            'message_id' => $this->message_id,
            'seq' => $this->seq,
            'recipient_id' => $this->recipient_id,
            'time' => $this->time,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
