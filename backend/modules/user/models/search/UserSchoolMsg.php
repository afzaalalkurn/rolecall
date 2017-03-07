<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserSchoolMsg as UserSchoolMsgModel;

/**
 * UserSchoolMsg represents the model behind the search form about `backend\modules\user\models\UserSchoolMsg`.
 */
class UserSchoolMsg extends UserSchoolMsgModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'school_id', 'sender_id'], 'integer'],
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
        $query = UserSchoolMsgModel::find();

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
            'school_id' => $this->school_id,
            'sender_id' => $this->sender_id,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }

    public function searchMsg($params)
    {
        $query = UserSchoolMsgModel::find();

        $query->select(['user_school_msg.message_id', 'user_school_msg.seq', 'user_school_msg.school_id', 'user_school_msg.job_id', 'user_school_msg.identifier','user_school_msg.subject', 'user_school_msg.created_on','user_school_msg.sender_id', 'user_school_msg.text','user_school_msg_recipients.status'])
            ->innerJoin('user_school_msg_recipients', 'user_school_msg_recipients.message_id = user_school_msg.message_id and user_school_msg.seq = user_school_msg_recipients.seq')
            ->where(['in', 'user_school_msg_recipients.status', [UserSchoolMsgModel::STATUS_READ, UserSchoolMsgModel::STATUS_UNREAD] ])
            /*->andFilterWhere(['user_school_msg_recipients.seq',  '( select max(rr.seq) from user_school_msg_recipients rr where rr.message_id = user_school_msg.message_id and rr.status in ('.UserSchoolMsgModel::STATUS_UNREAD.', '.UserSchoolMsgModel::STATUS_READ.') )'])*/;

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
         * $query->where('if (user_school_msg.seq=1 and user_school_msg.sender_id= "'.$this->sender_id.'", 1=0, 1=1)');
         *
         * */
        /*$query->where('if (user_school_msg.seq=1 and user_school_msg.sender_id= "'.$this->sender_id.'", 1=0, 1=1)');*/
        /*

        */

        $query->andFilterWhere([
            'user_school_msg.seq' => $this->seq,
            'user_school_msg_recipients.recipient_id' => $this->sender_id
        ]);
        $query->orderBy('user_school_msg.created_on desc');


        return $dataProvider;

    }

    public function searchMaxSeqId($identifier){

        $query = UserSchoolMsgModel::find()->select('max(seq)+1 as seq');
        // grid filtering conditions
        $query->andFilterWhere(['identifier' => $identifier,]);
        return $query;

    }
}
