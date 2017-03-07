<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserSchoolMsgRecipients as UserSchoolMsgRecipientsModel;

/**
 * UserSchoolMsgRecipients represents the model behind the search form about `backend\modules\user\models\UserSchoolMsgRecipients`.
 */
class UserSchoolMsgRecipients extends UserSchoolMsgRecipientsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'seq', 'recipient_id', 'time'], 'integer'],
            [['status'], 'safe'],
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
        $query = UserSchoolMsgRecipientsModel::find();

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

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

    public function searchMsg($params)
    {
        $this->load($params);
        $sql ="SELECT    `user_school_msg`.`message_id`,
                         `user_school_msg`.`seq`,
                         `user_school_msg`.`school_id`,
                         `user_school_msg`.`job_id`,
                         `user_school_msg`.`identifier`,
                         `user_school_msg`.`subject`,
                         `user_school_msg`.`sender_id`,
                         `user_school_msg`.`text`,
                         `user_school_msg`.`created_on`,
                         `user_school_msg_recipients`.`status` ,
                         `user_school_msg_attachments`.`attachment`
                        FROM
                          `user_school_msg_recipients` 
                          INNER JOIN `user_school_msg` 
                            ON user_school_msg.message_id = user_school_msg_recipients.message_id 
                            AND user_school_msg.seq = user_school_msg_recipients.seq 
                          LEFT JOIN `user_school_msg_attachments` 
                            ON user_school_msg.message_id = user_school_msg_attachments.message_id
                            AND user_school_msg.seq = user_school_msg_attachments.seq
                             AND user_school_msg.sender_id = user_school_msg_attachments.sender_id
                        WHERE ";

                        if(!empty($this->job_id)){
                            $sql .=" `user_school_msg`.`job_id` = ".$this->job_id." AND ";
                        }

                        $sql .="
                        ( user_school_msg_recipients.recipient_id = ". $this->recipient_id .")
                        AND (  `user_school_msg_recipients`.`status` IN ('Read', 'UnRead') ) 
                        AND (
                                `user_school_msg_recipients`.`seq` = 
                                ( SELECT  MAX(rr.seq) FROM user_school_msg_recipients rr 
                                    WHERE rr.message_id = user_school_msg.message_id 
                                  AND rr.status IN ('UnRead', 'Read'))
                            )
                            
                       ORDER BY `user_school_msg`.`created_on` DESC";

        /*
         *                       AND if (user_school_msg.seq = 1 and user_school_msg.sender_id= ".$this->recipient_id.", 1=0, 1=1)
         *
         * */

        $query = self::findBySql($sql);

        /*
                $sql = "
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

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        /*$query->where('if (user_school_msg.seq=1 and user_school_msg.sender_id= "'.$this->sender_id.'", 1=0, 1=1)');*/
       /* $query->andFilterWhere([
            'user_school_msg_recipients.recipient_id' => $this->recipient_id
        ]);*/
        //pr($query->createCommand()->rawSql);
        return $dataProvider;

    }


    public function searchRecipients($params)
    {
        $query = UserSchoolMsgRecipientsModel::find();

        $query->select('distinct(recipient_id) recipient_id');

        // add conditions that should always apply here

        /*
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        */

        $this->load($params);

        /*if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/

        // grid filtering conditions
        $query->andFilterWhere([
            'message_id' => $this->message_id,
            'seq' => $this->seq,
            'recipient_id' => $this->recipient_id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $query;

        //return $dataProvider;
    }

    public function viewMsg($params){

        $this->load($params);

        $sql ="SELECT `user_school_msg`.`message_id`,
                         `user_school_msg`.`seq`,
                         `user_school_msg`.`school_id`,
                         `user_school_msg`.`job_id`,
                         `user_school_msg`.`identifier`,
                         `user_school_msg`.`subject`,
                         `user_school_msg`.`sender_id`,
                         `user_school_msg`.`text`,
                         `user_school_msg`.`created_on`,
                         `user_school_msg_recipients`.`status` 
                        FROM
                          `user_school_msg_recipients` 
                          INNER JOIN `user_school_msg` 
                            ON user_school_msg.message_id = user_school_msg_recipients.message_id 
                            AND user_school_msg.seq = user_school_msg_recipients.seq 
                        WHERE
                        ( user_school_msg_recipients.recipient_id = ". $this->recipient_id .")
                        AND (  `user_school_msg`.`message_id` = ". $this->message_id ." )
                        AND (  `user_school_msg_recipients`.`status` IN ('Read', 'UnRead') ) 
                       ORDER BY `user_school_msg`.`created_on` DESC";

        /*
         *                       AND if (user_school_msg.seq = 1 and user_school_msg.sender_id= ".$this->recipient_id.", 1=0, 1=1)
         *
         * */

        $query = self::findBySql($sql);


        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //pr($query->createCommand()->rawSql);
        return $dataProvider;
    }

    public static function countUnReadMsg( $recipient_id = null ){

        $query = UserSchoolMsgRecipientsModel::find();
        $query->select('message_id');
        $query->andFilterWhere([
            'recipient_id' => $recipient_id ?? Yii::$app->user->id,
        ]);
        $query->andFilterWhere(['like', 'status', UserSchoolMsgRecipientsModel::STATUS_UNREAD]);

        return $query;
    }


}
