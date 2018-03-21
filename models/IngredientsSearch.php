<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ingredients;

/**
 * IngredientsSearch represents the model behind the search form of `app\models\Ingredients`.
 */
class IngredientsSearch extends Ingredients
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'hidden'], 'safe'],
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
    public function search($params, $ingredientsIds = [])
    {
        $query = Ingredients::find();

        $addedIds = [];
        if ($ingredientsIds) {
            foreach ($ingredientsIds as $ingredientsId) {
                $addedIds[] = (int)$ingredientsId;
            }
        }

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

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'hidden', $this->hidden])
            ->andFilterWhere(['not in', 'id', $addedIds])
            ->orderBy('title');

        return $dataProvider;
    }
}
