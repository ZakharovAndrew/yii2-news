<?php

namespace ZakharovAndrew\news\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use ZakharovAndrew\news\models\NewsReaction;

/**
 * NewsReactionSearch represents the model behind the search form of `ZakharovAndrew\news\models\NewsReaction`.
 */
class NewsReactionSearch extends NewsReaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'news_id', 'user_id', 'reaction_id'], 'integer'],
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
        $query = NewsReaction::find();

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
            'news_id' => $this->news_id,
            'user_id' => $this->user_id,
            'reaction_id' => $this->reaction_id,
        ]);

        return $dataProvider;
    }
}
