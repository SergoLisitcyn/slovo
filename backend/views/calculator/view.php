<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Calculator */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Calculators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="calculator-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'amount',
            'min_amount',
            'term',
            'min_term',
            'rule_violation_percent',
            'rate',
            'amount_step',
            'term_step',
        ],
    ]) ?>

</div>
