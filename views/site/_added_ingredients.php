<?php
use yii\widgets\ActiveForm;
?>

<?php ActiveForm::begin(['id' => 'remove-ingredient-form']); ?>
<?php if (!empty($ingredients)): ?>
    <h3>Ingredients list</h3>
    <ul class="list-group">
        <?php foreach ($ingredients as $ingredient): ?>
            <li class="list-group-item">
                <?= $ingredient->title ?>
                <button type="submit" name="remove-ingredient" value="<?= $ingredient->id ?>" class="btn btn-xs btn-danger" style="position: absolute; right: 10px">Remove</button>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php ActiveForm::end(); ?>
