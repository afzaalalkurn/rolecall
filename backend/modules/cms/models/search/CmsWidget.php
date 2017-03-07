<?php

namespace backend\modules\cms\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\cms\models\CmsWidget as CmsWidgetModel;

/**
 * CmsWidget represents the model behind the search form about `backend\modules\cms\models\CmsWidget`.
 */
class CmsWidget extends CmsWidgetModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_id'], 'integer'],
            [['widget', 'data'], 'safe'],
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
        $query = CmsWidgetModel::find();

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
            'widget_id' => $this->widget_id,
        ]);

        $query->andFilterWhere(['like', 'widget', $this->widget])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
