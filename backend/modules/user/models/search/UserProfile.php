<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserProfile as UserProfileModel;

/**
 * UserProfile represents the model behind the search form about `backend\modules\user\models\UserProfile`.
 */
class UserProfile extends UserProfileModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'avatar_id', 'plan_id'], 'integer'],
            [['first_name', 'last_name', 'gender', 'dob', 'joining_date', 'mobile', 'telephone'], 'safe'],
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
        $query = UserProfileModel::find();

        $query->select(['user_school_msg.message_id', 'user_school_msg.seq', 'user_school_msg.school_id', 'user_school_msg.job_id', 'user_school_msg.identifier','user_school_msg.subject', 'user_school_msg.created_on','user_school_msg.sender_id', 'user_school_msg.text','user_school_msg_recipients.status'])
            ->innerJoin('user_school_msg_recipients', 'user_school_msg_recipients.message_id = user_school_msg.message_id and user_school_msg.seq = user_school_msg_recipients.seq')
            ->where(['in', 'user_school_msg_recipients.status', [UserSchoolMsgModel::STATUS_READ, UserSchoolMsgModel::STATUS_UNREAD]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'avatar_id' => $this->avatar_id,
            'dob' => $this->dob,
            'joining_date' => $this->joining_date,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'telephone', $this->telephone]);

        return $dataProvider;
    }
}
