<?php
/**
 * Created by PhpStorm.
 * User: Батареечка
 * Date: 21.03.2018
 * Time: 12:20
 */

namespace app\controllers;
use yii\web\Controller;
use Yii;

class MasterController extends Controller
{
    public function getIngredientsIds()
    {
        $key = ($this->getName(get_called_class()) === 'SiteController' ) ? 'find-dish' : 'create-dish';
        $session = Yii::$app->session;
        $ingredients = [];

        if (!$session->isActive) {
            $session->open();
        }

        if ($session->has($key)) {
            $ingredients = $session[$key];
        }

        if ($addIngredient = Yii::$app->request->post('add-ingredient')) {
            $ingredients[$addIngredient] = $addIngredient;
            $session[$key]      = $ingredients;
        }

        if ($removeIngredient = Yii::$app->request->post('remove-ingredient')) {
            unset($ingredients[$removeIngredient]);
            $session[$key] = $ingredients;
        }

        return $ingredients;
    }

    private function getName($class)
    {
        $path = explode('\\', $class);
        return array_pop($path);
    }
}