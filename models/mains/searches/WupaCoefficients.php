<?php

namespace app\models\mains\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mains\generals\WupaCoefficients as WupaCoefficientsModel;

/**
 * WupaCoefficients represents the model behind the search form of `app\models\mains\generals\WupaCoefficients`.
 */
class WupaCoefficients extends WupaCoefficientsModel
{
    /**
     * {@inheritdoc}
     */
    public $query;

    public function rules()
    {
        return [
            [['id', 'wupa_master_id', 'item_id', 'category_item_id', 'item_id', 'unit_code_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code', 'unit_code_str'], 'safe'],
            [['coefficient'], 'number'],
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
        $query = WupaCoefficientsModel::find();

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
            'wupa_master_id' => $this->wupa_master_id,
            'item_id' => $this->item_id,
            'category_item_id' => $this->category_item_id,
            'item_id' => $this->item_id,
            'unit_code_id' => $this->unit_code_id,
            'coefficient' => $this->coefficient,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'unit_code_str', $this->unit_code_str]);

        $query->orFilterWhere(['like', 'code', $this->query])
            ->orFilterWhere(['like', 'unit_code_str', $this->query]);

        return $dataProvider;
    }
}
