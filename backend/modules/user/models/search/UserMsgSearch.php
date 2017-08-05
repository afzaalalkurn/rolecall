<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserMsg;

/**
 * UserMsgSearch represents the model behind the search form about `backend\modules\user\models\UserMsg`.
 */
class UserMsgSearch extends UserMsg
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id',/* 'seq', 'user_id', 'item_id',*/ 'sender_id'], 'integer'],
            [['text', /*'identifier', 'subject',  'status', 'created_at'*/], 'safe'],
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
        $query = UserMsg::find();

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
            'sender_id' => $this->sender_id,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }

    public function searchMsg($params)
    {
        $query = UserMsg::find();

        $query->select(['user_msg.message_id', 'user_msg.seq', 'user_msg.item_id', 'user_msg.identifier','user_msg.subject', 'user_msg.created_at','user_msg.sender_id', 'user_msg.text','user_msg_recipients.status'])
            ->innerJoin('user_msg_recipients', 'user_msg_recipients.message_id = user_msg.message_id and user_msg.seq = user_msg_recipients.seq')
            ->where(['in', 'user_msg_recipients.status', [UserMsg::STATUS_READ, UserMsg::STATUS_UNREAD] ])
            /*->andFilterWhere(['user_msg_recipients.seq',  '( select max(rr.seq) from user_msg_recipients rr where rr.message_id = user_msg.message_id and rr.status in ('.UserMsgModel::STATUS_UNREAD.', '.UserMsgModel::STATUS_READ.') )'])*/;

        //pr($query->createCommand()->rawSql);

        /*  $sql = "
  select m.mid, m.seq, m.created_at, m.created_by, m.body, r.status from message2_recips r
  inner join message2 m on m.mid=r.mid and m.seq=r.seq
  where r.uid=? and r.status in ('A', 'N')
  and r.seq=( select max(rr.seq) from message2_recips rr where rr.mid=m.mid and rr.status in ('A', 'N') )
  and if (m.seq=1 and m.created_by=?, 1=0, 1=1)
  order by created_at desc";*/

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
        $query->orderBy('user_msg.created_at desc');


        return $dataProvider;

    }

    public function findLastMessage($message_id){

        if(is_null($message_id) || empty($message_id)) return '';
        $seq = $this->findLastSeqId($message_id);
        $query = UserMsg::find()->select('*');
        $query->andFilterWhere(['message_id' => $message_id,'seq' => $seq,]);
        return $query->one();
    }

    public static function searchMaxSeqId($message_id = null){

        if(is_null($message_id) || empty($message_id)) return 1;

        $userMsg = new self();
        return $userMsg->findLastSeqId($message_id) + 1;
    }

    public function findLastSeqId($message_id = null){

        if(is_null($message_id) || empty($message_id)) return 1;
        $query = UserMsg::find()->select('max(seq) as seq');
        $query->andFilterWhere(['message_id' => $message_id,]);
        return ($query->count() > 0) ? $query->one()->seq : 1;
    }

    public function searchUnReadUserMsg($params)
    {
        $query = UserMsg::find();

        $query->select([
            'user_msg.message_id',
            'user_msg.seq',
            'user_msg.created_at',
            'user_msg.sender_id',
            'user_msg.text',
            'user_msg_recipients.status'])
            ->innerJoin('user_msg_recipients', 'user_msg_recipients.message_id = user_msg_recipients.message_id');

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        $query->where([
            'user_msg_recipients.status' => self::STATUS_UNREAD,
            'user_msg.seq' => 1,
            'user_msg_recipients.recipient_id' => Yii::$app->user->id]);
        $query->orderBy('user_msg_recipients.created_at desc');
        return $dataProvider;
    }

    public function countUnReadMsg()
    {
        $query = UserMsg::find();
        $query->innerJoin('user_msg_recipients', 'user_msg_recipients.message_id = user_msg_recipients.message_id');

        $query->where([
            'user_msg_recipients.status' => self::STATUS_UNREAD,
            'user_msg_recipients.recipient_id' => Yii::$app->user->id]);

        return $query->count();

    }





}
