<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ingredients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ingredient-form">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-sm-8"><?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => "Title"])->label(false) ?></div>

        <?php if ($update): ?>
            <div class="col-sm-2"><?= $form->field($model, 'hidden')->checkbox() ?></div>
        <?php endif; ?>

        <div class="col-sm-2"><?= Html::submitButton('Save', ['class' => 'btn btn-success btn-xs']) ?></div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
