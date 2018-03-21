<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * DishesSearch represents the model behind the search form of `app\models\Dish`.
 */
class DishesSearch extends Dishes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title'], 'safe'],
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
        $query = Dishes::find();

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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    public function searchPublic($ingredientsIds, $errors)
    {
        if (count($ingredientsIds) < 2) {
            $errors[] = 'Chose at least 2 ingredients';
            return [[], $errors];
        }

        if (count($ingredientsIds) > 5) {
            $errors[] = 'Can not find dish using more than 5 ingredients. Chose no more than 5 ingredients';
            return [[], $errors];
        }

        $dishesData = (new Query())->select("totals.title, totals.id as dishes_id, totals.total, count(*) as counted, (totals.total - count(*)) as diff")
            ->from('(select  dishes.title, dishes.id, count(*) as total from dishes_ingredients as di
	                      inner join dishes on di.dishes_id = dishes.id
	                      GROUP BY dishes.title) as totals')
            ->innerJoin('dishes_ingredients', 'dishes_ingredients.dishes_id = totals.id')
            ->where(['in','dishes_ingredients.ingredients_id', $ingredientsIds])
            ->groupBy('totals.title')
            ->orderBy('counted DESC')
            ->all();

        $fullMatch = [];
        $partMatch = [];
        $keys = [];

        foreach ($dishesData as $dish) {
            if ($dish['counted'] >= 2 && $dish['diff'] === 0) {
                $fullMatch[] = $dish;
                continue;
            }
            if ($dish['counted'] >= 2) {
                $partMatch[] = $dish;
            }
        }

        $result = $fullMatch ? $fullMatch : $partMatch;

        if (empty($result)) {
            $errors[] = 'Nothing found';
        } else {
            foreach ($result as $dish) {
                $keys[] = $dish['dishes_id'];
            }
        }

        $dishes = Dishes::findAll($keys);

        foreach ($dishes as $key => $dish) {
            foreach ($dish->ingredients as $ingredient) {
                if ($ingredient->hidden) {
                    unset($dishes[$key]);
                    continue 2;
                }
            }
        }

        return [$dishes, $errors];
    }
}
