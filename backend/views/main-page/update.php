<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MainPage */

$this->title = '';
?>
<div class="main-page-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
