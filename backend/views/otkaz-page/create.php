<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OtkazPage */

$this->title = 'Create Otkaz Page';
$this->params['breadcrumbs'][] = ['label' => 'Otkaz Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="otkaz-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
