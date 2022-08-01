<?php

namespace app\models\mains\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mains\generals\WupaItems as WupaItemsModel;

/**
 * WupaItems represents the model behind the search form of `app\models\mains\generals\WupaItems`.
 */
class WupaItems extends WupaItemsModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'occupation_id'], 'required'],
            [['id', 'wupa_master_id', 'occupation_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code'], 'safe'],
            [['divided'], 'number'],
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
        $query = WupaItemsModel::find();

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
            'occupation_id' => $this->occupation_id,
            'item_id' => $this->item_id,
            'divided' => $this->divided,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}