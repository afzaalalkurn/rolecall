<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserMsgAttachments;

/**
 * UserMsgAttachmentsSearch represents the model behind the search form about `backend\modules\user\models\UserMsgAttachments`.
 */
class UserMsgAttachmentsSearch extends UserMsgAttachments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attachment_id', 'message_id', 'sender_id', 'seq'], 'integer'],
            [['attachment'], 'safe'],
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
        $query = UserMsgAttachments::find();

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
            'attachment_id' => $this->attachment_id,
            'message_id' => $this->message_id,
            'sender_id' => $this->sender_id,
            'seq' => $this->seq,
        ]);

        $query->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}
