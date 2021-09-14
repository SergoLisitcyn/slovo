<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calculators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calculator-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Calculator', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'amount',
            'min_amount',
            'term',
            'min_term',
            //'rule_violation_percent',
            //'rate',
            //'amount_step',
            //'term_step',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
