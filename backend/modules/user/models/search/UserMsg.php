<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserMsg as UserMsgModel;

/**
 * UserMsg represents the model behind the search form about `backend\modules\user\models\UserMsg`.
 */
class UserMsg extends UserMsgModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'user_id', 'sender_id'], 'integer'],
            [['text'], 'safe'],
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
        $query = UserMsgModel::find();

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
            'user_id' => $this->user_id,
            'sender_id' => $this->sender_id,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }

    public function searchMsg($params)
    {
        $query = UserMsgModel::find();

        $query->select(['user_msg.message_id', 'user_msg.seq', 'user_msg.user_id', 'user_msg.job_id', 'user_msg.identifier','user_msg.subject', 'user_msg.created_on','user_msg.sender_id', 'user_msg.text','user_msg_recipients.status'])
            ->innerJoin('user_msg_recipients', 'user_msg_recipients.message_id = user_msg.message_id and user_msg.seq = user_msg_recipients.seq')
            ->where(['in', 'user_msg_recipients.status', [UserMsgModel::STATUS_READ, UserMsgModel::STATUS_UNREAD] ])
            /*->andFilterWhere(['user_msg_recipients.seq',  '( select max(rr.seq) from user_msg_recipients rr where rr.message_id = user_msg.message_id and rr.status in ('.UserMsgModel::STATUS_UNREAD.', '.UserMsgModel::STATUS_READ.') )'])*/;

        //pr($query->createCommand()->rawSql);

        /*  $sql = "
  select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status from message2_recips r
  inner join message2 m on m.mid=r.mid and m.seq=r.seq
  where r.uid=? and r.status in ('A', 'N')
  and r.seq=( select max(rr.seq) from message2_recips rr where rr.mid=m.mid and rr.status in ('A', 'N') )
  and if (m.seq=1 and m.created_by=?, 1=0, 1=1)
  order by created_on desc";

        */

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

        /*
         * $query->where('if (user_msg.seq=1 and user_msg.sender_id= "'.$this->sender_id.'", 1=0, 1=1)');
         *
         * */
        /*$query->where('if (user_msg.seq=1 and user_msg.sender_id= "'.$this->sender_id.'", 1=0, 1=1)');*/
        /*

        */

        $query->andFilterWhere([
            'user_msg.seq' => $this->seq,
            'user_msg_recipients.recipient_id' => $this->sender_id
        ]);
        $query->orderBy('user_msg.created_on desc');


        return $dataProvider;

    }

    public function searchMaxSeqId($identifier){

        $query = UserMsgModel::find()->select('max(seq)+1 as seq');
        // grid filtering conditions
        $query->andFilterWhere(['identifier' => $identifier,]);
        return $query;

    }
}
