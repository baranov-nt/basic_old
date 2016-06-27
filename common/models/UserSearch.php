<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    public $currency;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'country_id', 'created_at', 'updated_at'], 'integer'],
            [['phone_short', 'phone', 'email', 'password_hash', 'auth_key', 'secret_key', 'item_name', 'currency'], 'safe'],
            [['balance'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
    public function search($params, $pageSize = 10, $theCreator = false)
    {
        $query = User::find()->joinWith('role');

        if ($theCreator === false)
        {
            $query->where(['!=', 'item_name', 'Создатель']);
        }

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
            'balance' => $this->balance,
            'status' => $this->status,
            'country_id' => $this->country_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $dataProvider->sort->attributes['item_name'] = [
            'asc' => ['item_name' => SORT_ASC],
            'desc' => ['item_name' => SORT_DESC],
        ];

        $query->andFilterWhere(['like', 'phone_short', $this->phone_short])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'secret_key', $this->secret_key])
            ->andFilterWhere(['like', 'item_name', $this->item_name]);

        return $dataProvider;
    }
}
