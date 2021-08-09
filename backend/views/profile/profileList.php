<?php

use backend\assets\ProfileAsset;
use yii\widgets\ListView;

ProfileAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'List of Managers';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<!--    <div class="col-lg-12">-->
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_profileCard',
            'summary' => false
        ]);?>
<!--    </div>-->
</div>