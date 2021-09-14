<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страница отказа';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Логотип',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->image){
                        return Html::img($model->image,['style' => 'height: 50px;']);
                    } else {
                        return '';
                    }

                },
            ],
            'advantages',
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'best_deal',
                'hAlign' => 'center',
                'filter' => false,
                'editableOptions' =>  function ($model, $key, $index) {
                    return [
                        'header' => 'Лучшее предложение',
                        'inputType' => 'dropDownList',
                        'data' => [1 =>'да',0 =>'нет'],
                    ];
                },
                'value' => function($model){
                    if($model->best_deal == 1){
                        $value = 'да';
                    } else {
                        $value = 'нет';
                    }
                    return $value;

                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'status',
                'hAlign' => 'center',
                'filter' => false,
                'editableOptions' =>  function ($model, $key, $index) {
                    return [
                        'header' => 'статус',
                        'inputType' => 'dropDownList',
                        'data' => [1 =>'Опубликовано',0 =>'Черновик'],
                    ];
                },
                'value' => function($model){
                    if($model->status == 0){
                        $value = 'Черновик';
                    } else {
                        $value = 'Опубликовано';
                    }
                    return $value;

                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'sort',
                'hAlign' => 'center',
                'filter' => false,
                'value' => function($model){ return $model->sort; },
            ],
            //'summa',
            //'link',
            //'sort',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
