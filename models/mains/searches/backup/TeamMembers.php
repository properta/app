<?php

namespace app\models\mains\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mains\generals\TeamMembers as TeamMembersModel;

/**
 * TeamMembers represents the model behind the search form of `app\models\mains\generals\TeamMembers`.
 */
class TeamMembers extends TeamMembersModel
{
    /**
     * {@inheritdoc}
     */
    public $query;
    public function rules()
    {
        return [
            [['id', 'team_id', 'user_id', 'role_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
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
        $query = TeamMembersModel::find();

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
            'team_id' => $this->team_id,
            'user_id' => $this->user_id,
            'role_id' => $this->role_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        return $dataProvider;
    }
}