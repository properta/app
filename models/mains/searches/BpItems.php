<?php

namespace app\models\mains\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mains\generals\BpItems as BpItemsModel;

/**
 * BpItems represents the model behind the search form of `app\models\mains\generals\BpItems`.
 */
class BpItems extends BpItemsModel
{
    /**
     * {@inheritdoc}
     */
    public $query;

    public function rules()
    {
        return [
            [['id', 'bp_master_id', 'occupation_category_id', 'occupation_item_id', 'volume_unit_code_id', 'price_in_unit', 'price_currency_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code', 'volume_unit_code_str', 'remark'], 'safe'],
            [['volume'], 'number'],
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
        $query = BpItemsModel::find();

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
            'bp_master_id' => $this->bp_master_id,
            'occupation_category_id' => $this->occupation_category_id,
            'occupation_item_id' => $this->occupation_item_id,
            'volume' => $this->volume,
            'volume_unit_code_id' => $this->volume_unit_code_id,
            'price_in_unit' => $this->price_in_unit,
            'price_currency_id' => $this->price_currency_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'volume_unit_code_str', $this->volume_unit_code_str])
            ->andFilterWhere(['like', 'remark', $this->remark]);
        
        $query->orFilterWhere(['like', 'code', $this->query])
            ->orFilterWhere(['like', 'volume_unit_code_str', $this->query])
            ->orFilterWhere(['like', 'remark', $this->query]);

        return $dataProvider;
    }
}