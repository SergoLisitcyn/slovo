<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */

$this->title = $model->name;
if(isset($model->title) and !empty($model->title)) { $this->title = $model->title; }
if(isset($model->keywords) and !empty($model->keywords)) { $this->registerMetaTag(['name' => 'keywords','content' => $model->keywords]); }
if(isset($model->description) and !empty($model->description)) { $this->registerMetaTag(['name' => 'description','content' => $model->description]); }
?>
<div class="get-money-form text-page news">
    <div class="news_date" style="font-size: 12px;">
        <a href="/">Микрокредиты</a> / <a href="/news">Новости</a> / <?= $model->name ?> </div>
        <br><br>
        <h1 style="text-transform: none; text-align: left;"><?= $model->name ?></h1>
        <script type="text/javascript" src="http://yastatic.net/share/share.js" charset="utf-8"></script>
        <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none"
             data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki" style="margin-bottom: 10px;">
        </div>
        <?= $model->content ?>

</div>
