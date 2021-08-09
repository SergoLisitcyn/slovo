<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SaleNews */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Акции и Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="sale-news-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
