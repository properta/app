<?php

namespace app\models\mains\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mains\generals\BpCategories as BpCategoriesModel;

/**
 * BpCategories represents the model behind the search form of `app\models\mains\generals\BpCategories`.
 */
class BpCategories extends BpCategoriesModel
{
    /**
     * {@inheritdoc}
     */
    public $query;

    public function rules()
    {
        return [
            [['id', 'project_id', 'building_type_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code', 'title', 'desc'], 'safe'],
            ['query', 'safe']

        ];
    }

    /**
     * {@inheritdoc}
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
        $query = BpCategoriesModel::find();

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
            'id' => $this->id,
            'project_id' => $this->project_id,
            'building_type_id' => $this->building_type_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desc', $this->desc]);
        
        $query->orFilterWhere(['like', 'code', $this->query])
            ->orFilterWhere(['like', 'title', $this->query])
            ->orFilterWhere(['like', 'desc', $this->query]);

        return $dataProvider;
    }
}