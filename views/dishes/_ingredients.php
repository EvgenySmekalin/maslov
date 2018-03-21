<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dishes */
/* @var $form yii\widgets\ActiveForm */

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns' => [
        [
            'attribute' => 'title',
            'format'    => 'text'
        ],
        [
            'format' => 'raw',
            'value' => function ($data) {
                return '<button class="btn btn-xs btn-success" type="button" onclick="addIngredient(' . $data->id . ');">Add</button>';
            },
            'contentOptions' => [
                'style' => 'text-align: center;'
            ]
        ]
    ],
]); ?>

<?php ActiveForm::begin(['id' => 'add-ingredient-form']); ?>
<?php ActiveForm::end(); ?>

<script>
    function addIngredient(ingredientId) {
        var form = document.getElementById('add-ingredient-form');
        var input = document.createElement("input");
        input.type  = "hidden";
        input.name  = "add-ingredient";
        input.value = ingredientId;
        form.appendChild(input);
        form.submit();
    }
</script>
