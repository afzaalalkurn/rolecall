<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserNotification as UserNotificationModel;

/**
 * UserNotification represents the model behind the search form about `backend\modules\user\models\UserNotification`.
 */
class UserNotification extends UserNotificationModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'job_id', 'seq', 'sender_id', 'time'], 'integer'],
            [['identifier', 'text', 'ip', 'category', 'status', 'created_on'], 'safe'],
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
        $query = UserNotificationModel::find();

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
            'sender_id' => $this->sender_id,
            'time' => $this->time,
            'created_on' => $this->created_on,
            'status' => self::STATUS_READ,
        ]);
        $query->andFilterWhere(['like', 'identifier', $this->identifier])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

    public function searchUnReadNotification($params)
    {
        $query = UserNotificationModel::find();

        $query->select(['user_notification.message_id', 'user_notification.seq', 'user_notification.created_on','user_notification.sender_id', 'user_notification.text','user_notification_recipients.status'])
            ->innerJoin('user_notification_recipients', 'user_notification_recipients.message_id = user_notification.message_id');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        $query->where([
            'user_notification_recipients.status' => self::STATUS_UNREAD,
            'user_notification.seq' => 1,
            'user_notification_recipients.recipient_id' => Yii::$app->user->id]);
        $query->orderBy('user_notification.created_on desc');
        return $dataProvider;
    }

    public function searchDefaultNotification($params)
    {
        $query = UserNotificationModel::find();

        $query->select(['user_notification.message_id', 'user_notification.seq', 'user_notification.created_on','user_notification.sender_id', 'user_notification.text','user_notification_recipients.status'])
            ->innerJoin('user_notification_recipients', 'user_notification_recipients.message_id = user_notification.message_id');
        $query->limit(10);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        $query->where([
            'user_notification_recipients.status' => self::STATUS_READ,
            'user_notification.seq' => 1,
            'user_notification_recipients.recipient_id' => Yii::$app->user->id]);
        $query->orderBy('user_notification.created_on desc');

        return $dataProvider;
    }

    public function searchNotification($params)
    {
        $query = UserNotificationModel::find();

        $query->select(['user_notification.message_id', 'user_notification.seq', 'user_notification.created_on','user_notification.sender_id', 'user_notification.text','user_notification_recipients.status'])
            ->innerJoin('user_notification_recipients', 'user_notification_recipients.message_id = user_notification.message_id and user_notification.seq = user_notification_recipients.seq')
            ->where(['in', 'user_notification_recipients.status', [UserNotificationModel::STATUS_READ, UserNotificationModel::STATUS_UNREAD] ])
            ->where(['user_notification_recipients.seq',  '( select max(rr.seq) from user_notification_recipients rr where rr.message_id = user_notification.mid and rr.status in ('.UserNotificationModel::STATUS_READ.', '.UserNotificationModel::STATUS_READ.') )']);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->where(['user_notification.seq' => 1]);
        $query->where(['user_notification_recipients.recipient_id' => $this->sender_id]);
        $query->orderBy('user_notification.created_on desc');

        return $dataProvider;
    }



    public function searchJob($params){

        $query = UserMsgModel::find();

        $query->select('distinct(job_id) as job_id, identifier, sender_id')
            ->innerJoin('user_notification_recipients', 'user_notification_recipients.message_id = user_notification.message_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        // grid filtering conditions
        $query->andFilterWhere([
            'message_id' => $this->message_id,
            'job_id' => $this->job_id,
            'seq' => $this->seq,
            'sender_id' => $this->sender_id,
            'time' => $this->time,
            'created_on' => $this->created_on,
        ]);

        $query->where([
            'user_notification_recipients.seq'           => $this->seq,
            'user_notification_recipients.recipient_id' => $this->sender_id ]);

        /*
         echo $query->createCommand()->rawSql;
         exit;
        */

        return $dataProvider;

    }

    public function showAllNotifications($params){

        $query = UserNotificationModel::find();

        $query->select(['user_notification.message_id',
            'user_notification.seq',
            'user_notification.created_on',
            'user_notification.sender_id',
            'user_notification.text',
            'user_notification.status',
            'user_notification.job_id',
        ])
            ->innerJoin('user_notification_recipients', 'user_notification_recipients.message_id = user_notification.message_id');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        $query->andFilterWhere([
            'user_notification_recipients.recipient_id' => Yii::$app->user->id,
        ]);
        $query->andFilterWhere(['<>', 'user_notification.sender_id', Yii::$app->user->id]);
        /*$query->orWhere([
            'user_notification_recipients.recipient_id' => Yii::$app->user->id,
            'user_notification_recipients.status' => self::STATUS_UNREAD
        ]);*/
        $query->orderBy('user_notification.created_on desc');
        //pr($query->createCommand()->query());
        return $dataProvider;
    }

    public static function showUnreadRolecall($job_id){
        $query = UserNotificationModel::find()
            ->select(['COUNT(*) AS cnt'])
            ->innerJoin('user_notification_recipients',
                'user_notification_recipients.message_id = user_notification.message_id')
            ->where(['user_notification.job_id' => $job_id,
            'user_notification_recipients.recipient_id' => Yii::$app->user->id,
            'user_notification_recipients.status' => 'UnRead'])
            ->count();
            return $query;
    }

    public static function showUnreadNotifications($job_id,$sender_id){
        $query = UserNotificationModel::find()
            ->select(['COUNT(*) AS cnt'])
            ->innerJoin('user_notification_recipients',
                'user_notification_recipients.message_id = user_notification.message_id')
            ->where(['user_notification.job_id' => $job_id,
                'user_notification_recipients.recipient_id' => Yii::$app->user->id,
                'user_notification_recipients.status' => 'UnRead',
                'user_notification.sender_id' => $sender_id,
            ])
            ->count();
        return $query;
    }
}
