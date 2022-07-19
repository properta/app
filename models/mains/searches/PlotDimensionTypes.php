<?php

namespace app\models\mains\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mains\generals\PlotDimensionTypes as PlotDimensionTypesModel;

/**
 * PlotDimensionTypes represents the model behind the search form of `app\models\mains\generals\PlotDimensionTypes`.
 */
class PlotDimensionTypes extends PlotDimensionTypesModel
{
    /**
     * {@inheritdoc}
     */
    public $query;

    public function rules()
    {
        return [
            [['id', 'project_id', 'dimension_unit_code_id', 'plot_type_id', 'total', 'status', 'created_at', 'creatad_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code', 'title', 'desc', 'dimension_unit_code_id_str', 'plot_type_str'], 'safe'],
            [['length', 'width'], 'number'],
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
        $query = PlotDimensionTypesModel::find();

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
            'length' => $this->length,
            'width' => $this->width,
            'dimension_unit_code_id' => $this->dimension_unit_code_id,
            'plot_type_id' => $this->plot_type_id,
            'total' => $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'creatad_by' => $this->creatad_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'dimension_unit_code_id_str', $this->dimension_unit_code_id_str])
            ->andFilterWhere(['like', 'plot_type_str', $this->plot_type_str]);
        
        $query->orFilterWhere(['like', 'code', $this->query])
            ->orFilterWhere(['like', 'title', $this->query])
            ->orFilterWhere(['like', 'desc', $this->query])
            ->orFilterWhere(['like', 'dimension_unit_code_id_str', $this->query])
            ->orFilterWhere(['like', 'plot_type_str', $this->query]);

        return $dataProvider;
    }
}