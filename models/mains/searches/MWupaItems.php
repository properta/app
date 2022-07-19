<?php

namespace app\models\mains\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mains\generals\MWupaItems as MWupaItemsModel;

/**
 * MWupaItems represents the model behind the search form of `app\models\mains\generals\MWupaItems`.
 */
class MWupaItems extends MWupaItemsModel
{
    /**
     * {@inheritdoc}
     */
    public $query;

    public function rules()
    {
        return [
            [['id', 'default_unit_code_id', 'level', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code', 'title', 'desc', 'default_unit_code_str'], 'safe'],
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
        $query = MWupaItemsModel::find();

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
            'default_unit_code_id' => $this->default_unit_code_id,
            'level' => $this->level,
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
            ->andFilterWhere(['like', 'default_unit_code_str', $this->default_unit_code_str]);
        
        $query->orFilterWhere(['like', 'code', $this->query])
            ->orFilterWhere(['like', 'title', $this->query])
            ->orFilterWhere(['like', 'desc', $this->query])
            ->orFilterWhere(['like', 'default_unit_code_str', $this->query]);

        return $dataProvider;
    }
}