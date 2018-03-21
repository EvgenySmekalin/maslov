<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dishes_ingredients".
 *
 * @property int $dishes_id
 * @property int $ingredients_id
 */
class DishesIngredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dishes_ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dishes_id', 'ingredients_id'], 'required'],
            [['dishes_id', 'ingredients_id'], 'integer'],
            [['dishes_id', 'ingredients_id'], 'unique', 'targetAttribute' => ['dishes_id', 'ingredients_id']],
            [['dishes_id', 'ingredients_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dishes_id' => 'Dishes ID',
            'ingredients_id' => 'Ingredients ID',
        ];
    }

    static function createDish($dishId, $ingredientsIds)
    {
        $insertArray = [];
        foreach ($ingredientsIds as $key => $ingredientsId) {
            $insertArray[] = [$dishId, $ingredientsId];
        }
        try {
            Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['dishes_id', 'ingredients_id'], $insertArray)->execute();
        } catch (yii\db\Exception $e) {
            Yii::error('Can not save new dishes_ingredients record: ' . $e->getMessage());
        }

        return true;
    }

    static function addIngredientToDish($dishId, $ingredientId)
    {
        try {
            Yii::$app->db->createCommand()->insert(self::tableName(), ['dishes_id' => $dishId, 'ingredients_id' => $ingredientId])->execute();
        } catch (yii\db\Exception $e) {
            Yii::error('Can not add ingredient to dish: ' . $e->getMessage());
        }

        return true;
    }

    static function removeIngredientFromDish($dishId, $ingredientId)
    {
        try {
            $dishesIngredient = self::findOne(['dishes_id' => $dishId, 'ingredients_id' => $ingredientId]);
            $dishesIngredient->delete();
        } catch (\Exception $e) {
            Yii::error('Can not remove ingredient from dish: ' . $e->getMessage());
        } catch (\Throwable $e) {
            Yii::error('Can not remove ingredient from dish: ' . $e->getMessage());
        }

        return true;
    }

    static function deleteDish($dishId)
    {
        return self::deleteAll(['dishes_id' => $dishId]);
    }

    static function deleteIngredient($ingredientId)
    {
        return self::deleteAll(['dishes_id' => $ingredientId]);
    }
}
