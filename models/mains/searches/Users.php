<?php

namespace app\models\mains\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\identities\Users as UsersModel;

/**
 * Users represents the model behind the search form of `app\models\identities\Users`.
 */
class Users extends UsersModel
{
    public $query;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['username', 'full_name', 'auth_key', 'password_hash', 'register_token', 'password_reset_token', 'email', 'phone', 'role', 'image'], 'safe'],
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
        $query = UsersModel::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'register_token', $this->register_token])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'image', $this->image]);
        
        $query->orFilterWhere(['like', 'username', $this->query])
            ->orFilterWhere(['like', 'full_name', $this->query])
            ->orFilterWhere(['like', 'auth_key', $this->query])
            ->orFilterWhere(['like', 'password_hash', $this->query])
            ->orFilterWhere(['like', 'register_token', $this->query])
            ->orFilterWhere(['like', 'password_reset_token', $this->query])
            ->orFilterWhere(['like', 'email', $this->query])
            ->orFilterWhere(['like', 'phone', $this->query])
            ->orFilterWhere(['like', 'role', $this->query])
            ->orFilterWhere(['like', 'image', $this->query]);

        return $dataProvider;
    }
}