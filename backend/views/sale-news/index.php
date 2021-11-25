<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SaleNewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Акции и Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'options' => ['width' => '10'],
            ],
            'name',
            [
                'label' => 'Ссылка',
                'format' => 'raw',
                'hAlign' => 'center',
                'value' => function ($model) {
                    if($model->url){
                        if($model->type == 0){
                            $value = 'news';
                        } else {
                            $value = 'actions';
                        }
                        return Html::tag('a', $model->url, ['href' => (Yii::$app->params['siteUrl'].$value.'/'.$model->url)]);
                    } else {
                        return '';
                    }

                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'type',
                'hAlign' => 'center',
                'filter' => false,
                'editableOptions' =>  function ($model, $key, $index) {
                    return [
                        'header' => 'Тип',
                        'inputType' => 'dropDownList',
                        'data' => [0 =>'Новость',1 =>'Акция'],
                    ];
                },
                'value' => function($model){
                    if($model->type == 0){
                        $value = 'Новость';
                    } else {
                        $value = 'Акция';
                    }
                    return $value;
                },
            ],
            [
                'label' => 'Статус',
                'value' => function ($model) {
                    $result = '';
                    if($model->status == 1){
                        $result .= 'Активен';
                    } else {
                        $result .= 'Неактивен';
                    }

                    return $result;
                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'sort',
                'hAlign' => 'center',
                'filter' => false,
                'value' => function($model){ return $model->sort; },
            ],

            [
                'label' => 'Действия',
                'format' => 'raw',
                'options' => ['width' => '200'],
                'value' => function ($model, $index, $jobList) {
                    return Html::tag('a', 'Редактировать', ['href' => \yii\helpers\Url::toRoute(['sale-news/update', 'id' => $index]), 'class' => 'btn btn-success', 'style' => 'font-weight: 100;margin-right:10px'])
                        .Html::tag('a', 'Удалить', ['href' => \yii\helpers\Url::toRoute(['sale-news/delete', 'id' => $index]), 'data-method' => 'post', 'data-confirm' => 'Вы точно хотите удалить?', 'class' => 'btn btn-order btn-danger', 'style' => 'font-weight: 100']);
                },
            ],
        ],
    ]); ?>


</div>
