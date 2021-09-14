<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OtkazPage */

$this->title = '';
?>
<div class="otkaz-page-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
