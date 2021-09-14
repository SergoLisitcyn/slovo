<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Otkaz Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="otkaz-page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Otkaz Page', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'text_top:ntext',
            'text_bottom:ntext',
            'title_seo',
            //'description',
            //'keywords',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
