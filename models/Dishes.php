<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dishes".
 *
 * @property int $id
 * @property string $title
 */
class Dishes extends \yii\db\ActiveRecord
{
    public $ingredientsIds;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dishes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            ['ingredientsIds', 'required', 'isEmpty' => function ($value) {
                if (empty($value)) {
                    $this->addError('title','Chose at least 2 ingredients');
                } elseif (count($value) < 2) {
                    $this->addError('title','Chose more than 1 ingredient');
                }
            }],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    public function getIngredients()
    {
        return $this->hasMany(Ingredients::className(), ['id' => 'ingredients_id'])
            ->viaTable('dishes_ingredients', ['dishes_id' => 'id']);
    }

    public function getIngredientsIds()
    {
        $ids = [];
        foreach ($this->ingredients as $ingredient) {
            $ids[] = $ingredient->id;
        }
        return $ids;
    }

    public function beforeDelete()
    {
        DishesIngredients::deleteDish($this->id);
        return parent::beforeDelete();
    }

    public function addIngredient($ingredientId)
    {
        return DishesIngredients::addIngredientToDish($this->id, $ingredientId);
    }

    public function removeIngredient($ingredientId)
    {
        return DishesIngredients::removeIngredientFromDish($this->id, $ingredientId);
    }
}
