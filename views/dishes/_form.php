<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dishes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dish-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php if (!empty($ingredients)): ?>
        <h3>Ingredients list</h3>
        <ul class="list-group">
            <?php foreach ($ingredients as $ingredient): ?>
                <li class="list-group-item">
                    <?= $ingredient->title ?>
                    <button type="button" onclick="removeIngredient(<?= $ingredient->id ?>)" class="btn btn-xs btn-danger" style="position: absolute; right: 10px">Remove</button>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php ActiveForm::begin(['id' => 'remove-ingredient-form']); ?>
<?php ActiveForm::end(); ?>

<script>
    function removeIngredient(ingredientId) {
        var form = document.getElementById('remove-ingredient-form');
        var input = document.createElement("input");
        input.type  = "hidden";
        input.name  = "remove-ingredient";
        input.value = ingredientId;
        form.appendChild(input);
        form.submit();
    }
</script>
