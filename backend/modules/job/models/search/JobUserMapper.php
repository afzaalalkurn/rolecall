<?php

namespace backend\modules\job\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\job\models\JobUserMapper as JobUserMapperModel;

/**
 * JobUserMapper represents the model behind the search form about `backend\modules\job\models\JobUserMapper`.
 */
class JobUserMapper extends JobUserMapperModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id', 'user_id'], 'integer'],
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
        $query = JobUserMapperModel::find();

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
            'job_id' => $this->job_id,
            'user_id' => $this->user_id,
        ]);


        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

    public function searchPass($params)
    {
        $query = JobUserMapperModel::find();

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
            'job_id' => $this->job_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'status', "Passed"]);

        return $dataProvider;
    }

    public function searchDecline($params)
    {
        $query = JobUserMapperModel::find();

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
            'job_id' => $this->job_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'status', "Declined"]);

        return $dataProvider;
    }

    public function searchUser($params)
    {
        $query = JobUserMapperModel::find();
        $query->groupBy('job_id');

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
            'job_id' => $this->job_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

    public function searchJobUser($params)
    {
        $query = JobUserMapperModel::find();
        $query->join('INNER JOIN', 'job_item', 'job_user_mapper.job_id = job_item.job_id');
        /*$query->groupBy('job_id');*/

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

        $query->andFilterWhere(['job_item.user_id' => Yii::$app->user->id,]);

        // grid filtering conditions
        $query->andFilterWhere([
            'job_user_mapper.job_id' => $this->job_id,
            'job_user_mapper.user_id' => $this->user_id,
        ]);

            $query->andFilterWhere(['like', 'job_user_mapper.status', $this->status]);

        //pr($query->createCommand()->getRawSql());
        return $dataProvider;
    }

    public function searchJobUserPass($params)
    {
        $query = JobUserMapperModel::find();
        $query->join('INNER JOIN', 'job_item', 'job_user_mapper.job_id = job_item.job_id');
        /*$query->groupBy('job_id');*/

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

        $query->andFilterWhere(['job_item.user_id' => Yii::$app->user->id,]);

        // grid filtering conditions
        $query->andFilterWhere([
            'job_user_mapper.job_id' => $this->job_id,
            'job_user_mapper.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'job_user_mapper.status', 'Passed']);

        //pr($query->createCommand()->getRawSql());
        return $dataProvider;
    }

    public function searchJobUserDecline($params)
    {
        $query = JobUserMapperModel::find();
        $query->join('INNER JOIN', 'job_item', 'job_user_mapper.job_id = job_item.job_id');
        /*$query->groupBy('job_id');*/

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

        $query->andFilterWhere(['job_item.user_id' => Yii::$app->user->id,]);

        // grid filtering conditions
        $query->andFilterWhere([
            'job_user_mapper.job_id' => $this->job_id,
            'job_user_mapper.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'job_user_mapper.status', 'Declined']);

        //pr($query->createCommand()->getRawSql());
        return $dataProvider;
    }

    public function getRolecallCount($status,$user_id){
        $query = JobUserMapperModel::find()
            ->select(['COUNT(*) AS cnt'])
            ->where(['status'=>$status,'user_id'=>$user_id])
            ->groupBy(['job_id'])
            ->count();

        return $query;
    }

    public function getRolecallPassCount($user_id){
        /*$query = JobUserMapperModel::find()
            ->select(['COUNT(*) AS cnt'])
            ->where(['or',
                ['like', 'status', 'Passed'],
                ['like', 'status', 'Declined'],
                'user_id'=>$user_id])
            ->groupBy(['job_id'])
            ->count();
        return $query;*/

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
    SELECT COUNT(*) AS cnt from job_user_mapper where (`status` LIKE 'Passed' OR `status` LIKE 'Declined') AND user_id = '".$user_id."' GROUP BY job_id");
        $query = $command->queryAll();
        return count($query);
    }

    public function getTalentCount($status,$job_id){
        $query = JobUserMapperModel::find()
            ->select(['COUNT(*) AS cnt'])
            ->where(['status'=>$status,'job_id'=>$job_id])
            ->groupBy(['user_id'])
            ->count();

        return $query;
    }

    public function getTalentPassCount($job_id){
        /*$query = JobUserMapperModel::find()
            ->select(['COUNT(*) AS cnt'])
            ->where([
                'or',
                ['like', 'status', 'Passed'],
                ['like', 'status', 'Declined'],
                'job_id'=>$job_id])
            ->groupBy(['user_id'])
            ->count();
        pr($query->sql);*/

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
    SELECT COUNT(*) AS cnt from job_user_mapper where (`status` LIKE 'Passed' OR `status` LIKE 'Declined') AND job_id = '".$job_id."' GROUP BY user_id");
        $query = $command->queryAll();
        return count($query);
    }

    public static function getBookedTalentCount($status,$user_id){
        $query = JobUserMapperModel::find()
            ->select(['COUNT(*) AS cnt'])
            ->where(['status'=>$status,'user_id'=>$user_id])
            ->count();
        return $query;
    }

    public static function getBookedRolecallCount($status,$user_id){
        $query = JobUserMapperModel::find()
            ->join('INNER JOIN', 'job_item', 'job_user_mapper.job_id = job_item.job_id')
            ->select(['COUNT(*) AS cnt'])
            ->where(['job_user_mapper.status'=>$status,'job_item.user_id'=>$user_id])
            ->count();
        return $query;
    }

    public static function showMessage($job_id,$user_id){
        $query = JobUserMapperModel::find()
            ->select(['COUNT(*) AS cnt'])
            ->where(['user_id'=>$user_id,'job_id'=>$job_id])
            ->andWhere(['!=', 'status', 'Pending'])
            ->count();
        return $query;
    }

    public static function userJobStatus($user_id, $job_id){

        $query = JobUserMapperModel::find()
            ->where(['user_id'=>$user_id,'job_id'=>$job_id])
            ->andWhere(['!=', 'status', 'Pending'])->one();
        return $query;

    }


}
