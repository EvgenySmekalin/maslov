<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IngredientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cooking';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-index">

    <h2>Dishes</h2>

        <?php if(!empty($dishesData)): ?>
            <?php foreach($dishesData as $dish): ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><?= $dish->title ?></div>
                    <div class="panel-body">
                        <ul>
                        <?php foreach($dish->ingredients as $ingredient):  ?>
                            <li><?= $ingredient->title ?></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    <?php if(!empty($errors)): ?>
        <div class="panel panel-danger">
            <div class="panel-heading">Errors</div>
            <div class="panel-body">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>



    <?= $this->render('_added_ingredients', [
        'ingredients' => $ingredients,
    ]) ?>


    <h3>Add ingredients</h3>
    <?= $this->render('../dishes/_ingredients', [
        'dataProvider' => $dataProvider,
        'searchModel'  => $searchModel,
    ]) ?>

</div>
