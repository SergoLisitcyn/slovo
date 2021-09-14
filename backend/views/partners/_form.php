<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Partners */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partners-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($model, 'image_file')->widget(\kartik\file\FileInput::classname(), [
        'options' => [
            'accept' => 'image/*',
            'multiple' => false
        ],
        'pluginOptions' => [
            'showPreview' => false,
            'showRemove' => true,
            'showUpload' => false
        ]
    ]);
    ?>

    <?= $form->field($model, 'advantages')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'srok')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stavka')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'gesv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'best_deal')->textInput() ?>
    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([
        '1' => 'Активен',
        '0' => 'Черновик'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
