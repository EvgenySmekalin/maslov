<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DishesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dishes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($data) {

                    $hiddenIngredient = false;
                    $ingredients = $data->ingredients;

                    foreach ($ingredients as $ingredient) {
                        if ($ingredient->hidden) {
                            $hiddenIngredient = true;
                            break;
                        }
                    }

                    return '<span style="' . ($hiddenIngredient ? "text-decoration: line-through;" : "") . '">' . $data->title . '</span>';
                },

                'contentOptions' => [
                    'style' => 'vertical-align: middle;'
                ]
            ],
            [
                'label' => 'Ingredients',
                'format' => 'raw',
                'value' => function($data) {
                    $ingredientsList = '';
                    $ingredients = $data->ingredients;

                    if ($ingredients) {
                        $ingredientsList .= '<ul>';

                        foreach ($ingredients as $ingredient) {
                            $ingredientsList .= '<li>' . Html::a($ingredient->title, ['/ingredients/view', 'id' => $ingredient->id], ['style' => ($ingredient->hidden ? 'text-decoration: line-through;' : '')]) . '</li>';
                        }

                        $ingredientsList .= '</ul>';
                    }
                    return $ingredientsList;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => [
                    'style' => 'vertical-align: middle;'
                ]
            ],
        ],
    ]); ?>
</div>


