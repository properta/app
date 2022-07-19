<?php

namespace app\models\mains\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mains\generals\PlotOfLands as PlotOfLandsModel;

/**
 * PlotOfLands represents the model behind the search form of `app\models\mains\generals\PlotOfLands`.
 */
class PlotOfLands extends PlotOfLandsModel
{
    /**
     * {@inheritdoc}
     */
    public $query;

    public function rules()
    {
        return [
            [['id', 'dimension_id', 'excess_desc_id', 'marker_area_id', 'wind_direction_id', 'excess_unit_code_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code', 'title', 'desc', 'building_permit_number', 'images', 'excess_desc_str', 'marker_area_str', 'wind_direction_str', 'excess_unit_code_str'], 'safe'],
            [['excess_str', 'latitude', 'longitude'], 'number'],
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
        $query = PlotOfLandsModel::find();

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
            'dimension_id' => $this->dimension_id,
            'excess_str' => $this->excess_str,
            'excess_desc_id' => $this->excess_desc_id,
            'marker_area_id' => $this->marker_area_id,
            'wind_direction_id' => $this->wind_direction_id,
            'excess_unit_code_id' => $this->excess_unit_code_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
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
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'building_permit_number', $this->building_permit_number])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'excess_desc_str', $this->excess_desc_str])
            ->andFilterWhere(['like', 'marker_area_str', $this->marker_area_str])
            ->andFilterWhere(['like', 'wind_direction_str', $this->wind_direction_str])
            ->andFilterWhere(['like', 'excess_unit_code_str', $this->excess_unit_code_str]);
        
        $query->orFilterWhere(['like', 'code', $this->query])
            ->orFilterWhere(['like', 'title', $this->query])
            ->orFilterWhere(['like', 'desc', $this->query])
            ->orFilterWhere(['like', 'building_permit_number', $this->query])
            ->orFilterWhere(['like', 'images', $this->query])
            ->orFilterWhere(['like', 'excess_desc_str', $this->query])
            ->orFilterWhere(['like', 'marker_area_str', $this->query])
            ->orFilterWhere(['like', 'wind_direction_str', $this->query])
            ->orFilterWhere(['like', 'excess_unit_code_str', $this->query]);

        return $dataProvider;
    }
}