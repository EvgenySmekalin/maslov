<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Dishes */

$this->title = 'Create Dish';
$this->params['breadcrumbs'][] = ['label' => 'Dishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'ingredients' => $ingredients
    ]) ?>

    <br>

    <h2>Add ingredients</h2>
    <?= $this->render('_ingredients', [
        'dataProvider' => $dataProvider,
        'searchModel'  => $searchModel,
    ]) ?>

</div>

