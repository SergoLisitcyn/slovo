<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SaleNews */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Акции и Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-news-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
