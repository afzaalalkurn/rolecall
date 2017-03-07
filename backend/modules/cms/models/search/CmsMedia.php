<?php

namespace backend\modules\cms\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\cms\models\CmsMedia as CmsMediaModel;

/**
 * CmsMedia represents the model behind the search form about `backend\modules\cms\models\CmsMedia`.
 */
class CmsMedia extends CmsMediaModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['media_id', 'cms_id'], 'integer'],
            [['file', 'type'], 'safe'],
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
        $query = CmsMediaModel::find();

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
            'media_id' => $this->media_id,
            'cms_id' => $this->cms_id,
        ]);

        $query->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
