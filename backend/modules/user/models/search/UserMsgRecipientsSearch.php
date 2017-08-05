<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserMsgRecipients;
use yii\db\Query;

/**
 * @property $item_id
 * UserMsgRecipientsSearch represents the model behind the search form about `backend\modules\user\models\UserMsgRecipients`.
 */
class UserMsgRecipientsSearch extends UserMsgRecipients
{
    public $item_id;

    public static function countUnReadMsg($recipient_id = null)
    {

        $query = UserMsgRecipients::find();
        $query->distinct()->select('message_id');
        $query->andFilterWhere([
            'recipient_id' => $recipient_id ?? Yii::$app->user->id,
        ]);
        $query->andFilterWhere(['like', 'status', UserMsgRecipients::STATUS_UNREAD]);
        return $query;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'seq', 'recipient_id', 'time', 'item_id'], 'integer'],
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
        $query = UserMsgRecipients::find();

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

        $query = (new Query());

        $fields = ['user_msg.message_id',
            'user_msg.seq',
            'user_msg.identifier',
            'user_msg.sender_id',
            'user_msg.item_id',
            'user_msg.item_type',
            'user_msg.text',
            'user_msg.created_at',
            'user_msg_recipients.status',
            'user_msg_attachments.attachment',
            '( select GROUP_CONCAT(DISTINCT rrr.recipient_id)  from user_msg_recipients rrr WHERE  
               rrr.message_id = user_msg.message_id group by  rrr.message_id ) recipients '
        ];

        $query->select($fields);

        $query->from('user_msg_recipients');
        $query->join('INNER JOIN', 'user_msg', '`user_msg`.`message_id` = `user_msg_recipients`.`message_id`  AND `user_msg`.`seq` = `user_msg_recipients`.`seq` ');

        $query->join('LEFT JOIN', 'user_msg_attachments', '`user_msg`.`message_id` = `user_msg_attachments`.`message_id` AND `user_msg`.`seq` = `user_msg_attachments`.`seq` AND `user_msg`.`sender_id` = `user_msg_attachments`.`sender_id` ');


        $this->load($params);

        $query->andFilterWhere(['user_msg_recipients.recipient_id' => $this->recipient_id,]);
        $query->andFilterWhere(['IN', 'user_msg_recipients.status', ['Read', 'UnRead'],]);

        $subQuery = (new Query())->select(' MAX(rr.seq) ')->from('user_msg_recipients rr')->where('rr.message_id = user_msg.message_id and rr.status IN ("UnRead", "Read")');

        /*$query->andFilterWhere(['IN','user_msg_recipients.seq', "(SELECT  MAX(rr.seq) FROM user_msg_recipients rr WHERE rr.message_id = user_msg.message_id AND rr.status IN ('UnRead', 'Read'))"]);*/

        $query->andFilterWhere(['IN', 'user_msg_recipients.seq', $subQuery]);
        $query->orderBy('user_msg.created_at DESC');


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

        //pr($query->createCommand()->rawSql);

        return $dataProvider;

    }

    public function searchReceipents()
    {
        $sql = "SELECT   `r2`.`recipient_id`,
    `user`.`username`,
    `user_profile`.`avatar`,
    `r2`.`message_id`     
    FROM `user_msg_recipients` AS  `r2` INNER JOIN
    ( SELECT   `msg`.`message_id`,  MAX(`msg`.`seq`)  AS `seq` ,  MAX(`msg`.`created_at`)  AS `created_at` FROM  `user_msg` `msg` 
    WHERE `msg`.`message_id` IN 
    
    ( SELECT `r1`.`message_id` FROM `user_msg_recipients` `r1` WHERE `r1`.`recipient_id` = :recipient_id   GROUP BY   `r1` .`message_id`) 
      
    GROUP BY  `msg`.`message_id` ORDER BY `created_at` DESC ) AS `m`  ON  `m`.`message_id`  =   `r2`.`message_id`  AND  `m`. `seq`  =   `r2`. `seq` 
    INNER JOIN `user` 
      ON `r2`.`recipient_id` = `user`.`id` 
    INNER JOIN `user_profile` 
      ON `r2`.`recipient_id` = `user_profile`.`user_id` WHERE (`r2`.`recipient_id` <> :recipient_id)";

        return Yii::$app->db->createCommand($sql, [':recipient_id' => $this->recipient_id])->queryAll();
    }

    public function findRecipientById($users)
    {

        $query = (new Query());
        $query->select(' `user`.`id`, `user`.`username`, `user_profile`.`avatar` ');
        $query->from(' `user` ');
        $query->leftJoin(' `user_profile` ', ' `user`.`id` = `user_profile`.`user_id` ');
        $query->where(['IN', ' `user`.`id` ', $users]);
        return $query;
    }

    public function findMessageId($item_id, $recipients)
    {
        $recipient = Yii::$app->db->createCommand("SELECT msg.message_id from user_msg msg where msg.message_id in ( SELECT DISTINCT msg_recipients.message_id FROM (SELECT message_id,GROUP_CONCAT(DISTINCT recipient_id) recipients FROM `user_msg_recipients` 
GROUP BY `message_id`) AS msg_recipients WHERE msg_recipients.recipients LIKE :recipients OR msg_recipients.recipients LIKE :recipientsRev) AND msg.item_id = :item_id");

        $recipient->bindValue(':item_id', $item_id);
        $recipient->bindValue(':recipients', implode(',', $recipients));
        $recipient->bindValue(':recipientsRev', implode(',', array_reverse($recipients)));
        $result = $recipient->query();

        if ($result->count() > 0) {
            $row = $result->read();
            return $row['message_id'];
        }
        return false;
    }


    public function searchMessageReceipents()
    {
        $query = (new Query());
        $query->distinct()->select(' `r2`.`recipient_id`, `user`.`username`,`user_profile`.`avatar`, `r2`.`message_id` ');
        $query->from('`user_msg_recipients` as  `r1`');
        $query->innerJoin('`user_msg_recipients` as `r2`', '`r1`.`message_id` = `r2`.`message_id`');
        $query->leftJoin('`user`', '`r2`.`recipient_id` = `user`.`id`');
        $query->leftJoin('`user_profile`', '`r2`.`recipient_id` = `user_profile`.`user_id`');


        // grid filtering conditions
        $query->andFilterWhere(['r1.message_id' => $this->message_id,]);
        $query->andFilterWhere(['r1.recipient_id' => $this->recipient_id,]);
        $query->andFilterWhere(['<>', 'r2.recipient_id', $this->recipient_id]);
        $query->andFilterWhere(['like', 'status', $this->status]);

        //pr($query->createCommand()->rawSql);

        return $query;
    }

    public function msgIsExist($recipients)
    {


        $recipient = Yii::$app->db->createCommand("SELECT DISTINCT msg_recipients.message_id, msg_recipients.recipients FROM (SELECT message_id,GROUP_CONCAT(DISTINCT recipient_id) recipients FROM `user_msg_recipients` 
GROUP BY `message_id`) AS msg_recipients WHERE msg_recipients.recipients LIKE :recipients OR msg_recipients.recipients LIKE :recipientsRev ");

        $recipient->bindValue(':recipients', implode(',', $recipients));
        $recipient->bindValue(':recipientsRev', implode(',', array_reverse($recipients)));
        $result = $recipient->query();

        if ($result->count() > 0) {
            $row = $result->read();
            return $row['message_id'];
        }
        return false;
    }

    public function viewMsg($params)
    {

        $query = $this->query($params);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /*echo ($query->createCommand()->rawSql);
        exit;*/
        return $dataProvider;
    }

    public function query($params)
    {

        $this->load($params);

        $query = (new Query());

        $fields = ['user_msg.message_id',
            'user_msg.seq',
            'user_msg.identifier',
            'user_msg.sender_id',
            'user_msg.item_id',
            'user_msg.item_type',
            'user_msg.text',
            'user_msg.created_at',
            'user_msg_recipients.status',
            /*'user_msg_attachments.attachment',*/
            '( select GROUP_CONCAT(DISTINCT rrr.recipient_id)  from user_msg_recipients rrr WHERE  
               rrr.message_id = user_msg.message_id group by  rrr.message_id ) recipients '
        ];

        $query->select($fields);

        $query->from('user_msg_recipients');
        $query->join('INNER JOIN', 'user_msg', '`user_msg`.`message_id` = `user_msg_recipients`.`message_id`  AND `user_msg`.`seq` = `user_msg_recipients`.`seq` ');

        /*$query->join('LEFT JOIN', 'user_msg_attachments', '`user_msg`.`message_id` = `user_msg_attachments`.`message_id` AND `user_msg`.`seq` = `user_msg_attachments`.`seq` AND `user_msg`.`sender_id` = `user_msg_attachments`.`sender_id` ');*/


        $this->load($params);

        $query->andFilterWhere([' `user_msg_recipients`.`recipient_id` ' => $this->recipient_id,]);
        $query->andFilterWhere([' `user_msg`.`message_id` ' => $this->message_id,]);
        $query->andFilterWhere(['IN', 'user_msg_recipients.status', ['Read', 'UnRead'],]);

        $subQuery = (new Query())->select(' MAX(rr.seq) ')->from('user_msg_recipients rr')->where('rr.message_id = user_msg.message_id')->where('rr.status IN ("UnRead", "Read")');

        $query->andFilterWhere([' > ', 'user_msg_recipients.seq', $this->seq]);
        $query->orderBy('user_msg.created_at');
        return $query;

    }

    public function currentSeq($query = null)
    {
        if ($query) {
            $query->select('max(`user_msg`.`seq`) as seq');
            $query->select('max(`user_msg`.`seq`) as seq');
            $query->groupBy('`user_msg`.`message_id`');
            $query->orderBy(null);
        }

        return $query;
    }

    public function markAsRead($message_id, $seq, $recipient_id)
    {
        $model = UserMsgRecipients::findOne(['message_id' => $message_id, 'seq' => $seq, 'recipient_id' => $recipient_id]);
        if ($model->status == UserMsgRecipients::STATUS_UNREAD) {
            $model->status = UserMsgRecipients::STATUS_READ;
            $model->save();
        }
    }

    public static function showAllUnreadMsg($item_id){
        $query = self::find()
            ->select(['COUNT(*) AS cnt'])
            ->innerJoin('user_msg',
                'user_msg.message_id = user_msg_recipients.message_id
        AND `user_msg`.`seq` = `user_msg_recipients`.`seq`')
            ->where(['user_msg.item_id' => $item_id,
                'user_msg_recipients.recipient_id' => Yii::$app->user->id,
                'user_msg_recipients.status' => UserMsgRecipients::STATUS_UNREAD])
            ->count();
        return $query;
    }

    public static function showUnreadMsg($item_id, $sender_id){
        $query = self::find()
            ->select(['COUNT(*) AS cnt'])
            ->innerJoin('user_msg',
                'user_msg.message_id = user_msg_recipients.message_id 
                AND `user_msg`.`seq` = `user_msg_recipients`.`seq`')
            ->where(['user_msg.item_id' => $item_id,
                'user_msg_recipients.recipient_id' => Yii::$app->user->id,
                'user_msg_recipients.status' => UserMsgRecipients::STATUS_UNREAD,
                'user_msg.sender_id' => $sender_id,
            ])
            ->count();
        return $query;
    }
}
