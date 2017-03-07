<?php

namespace backend\modules\job\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\job\models\JobCategory as JobCategoryModel;

/**
 * JobCategory represents the model behind the search form about `backend\modules\job\models\JobCategory`.
 */
class JobCategory extends JobCategoryModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['name', 'description', 'modified_date'], 'safe'],
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
        $query = JobCategoryModel::find();

        $_field = 'job_category.category_id, job_category.name, job_category.description, job_category.modified_date, job_category.create_date';

        if(Yii::$app->language == 'fr'){
            $query->join('LEFT JOIN', 'job_category_fr', 'job_category_fr.category_id = job_category.category_id');
            $_field .=',
                IF(`job_category_fr`.`name`         <> "", `job_category_fr`.`name`, `job_category`.`name` ) as name,
                IF(`job_category_fr`.`description`  <> "", `job_category_fr`.`description`, `job_category`.`description` ) as description';

        }

        $query->select($_field);

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
            'category_id' => $this->category_id,
            'modified_date' => $this->modified_date,
        ]);


        if(Yii::$app->language == 'fr'){
            $query->andFilterWhere(['like', 'job_category_fr.name', $this->name])
                ->andFilterWhere(['like', 'job_category_fr.description', $this->description]);
        }else{
            $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description]);
        }



        return $dataProvider;
    }
}
