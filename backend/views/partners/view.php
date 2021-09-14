<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Partners */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Partners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="x-model">


    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'srok',
            'stavka',
            'summa',
            'link',
            'sort',
            [
                'label' => 'Статус',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->status == 1){
                        $result = 'Активен';
                    } else {
                        $result = 'Неактивен';
                    }
                    return $result;
                }
            ]
        ],
    ]) ?>

</div>
