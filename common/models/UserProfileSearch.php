<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserProfile;

/**
 * UserProfileSearch represents the model behind the search form about `common\models\UserProfile`.
 */
class UserProfileSearch extends UserProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'birthday', 'gender'], 'integer'],
            [['avatar', 'first_name', 'last_name', 'middle_name'], 'safe'],
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
    public function search($params)
    {
        $query = UserProfile::find();

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
            'user_id' => $this->user_id,
            'birthday' => $this->birthday,
            'gender' => $this->gender,
        ]);

        $query->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name]);

        return $dataProvider;
    }
}
