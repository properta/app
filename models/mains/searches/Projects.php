<?php

namespace app\models\mains\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mains\generals\Projects as ProjectsModel;

/**
 * Projects represents the model behind the search form of `app\models\mains\generals\Projects`.
 */
class Projects extends ProjectsModel
{
    /**
     * {@inheritdoc}
     */
    public $query;

    public function rules()
    {
        return [
            [['id', 'region_id', 'pic_id', 'contractor_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code', 'title', 'desc', 'building_permit_number', 'area_code', 'region_str', 'pic_str', 'pic_phone_number'], 'safe'],
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
        $query = ProjectsModel::find();

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
            'region_id' => $this->region_id,
            'pic_id' => $this->pic_id,
            'contractor_id' => $this->contractor_id,
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
            ->andFilterWhere(['like', 'area_code', $this->area_code])
            ->andFilterWhere(['like', 'region_str', $this->region_str])
            ->andFilterWhere(['like', 'pic_str', $this->pic_str])
            ->andFilterWhere(['like', 'pic_phone_number', $this->pic_phone_number]);
        
        $query->orFilterWhere(['like', 'code', $this->query])
            ->orFilterWhere(['like', 'title', $this->query])
            ->orFilterWhere(['like', 'desc', $this->query])
            ->orFilterWhere(['like', 'building_permit_number', $this->query])
            ->orFilterWhere(['like', 'area_code', $this->query])
            ->orFilterWhere(['like', 'region_str', $this->query])
            ->orFilterWhere(['like', 'pic_str', $this->query])
            ->orFilterWhere(['like', 'pic_phone_number', $this->query]);

        return $dataProvider;
    }
}