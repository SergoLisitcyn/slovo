<?php

use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SaleNews */

$this->title = 'Новости';
?>
<div class="get-money-form text-page">
    <h1>Новости</h1>
    <div style="margin-bottom: 50px">
        <button class="button2 open-sub " style="text-align:left;left: 0;position: absolute;margin-left: 80px;margin-top: -30px;padding: 3px 8px;font-size: 18px;">Подписка на новости</button>
        <a style="text-align:right;right: 0;position: absolute;margin-right: 80px;margin-top: -22px; color: #ff8925" href="../rss/news/index.html">
            <img style="padding-right: 10px" src="../img/rss.png" alt=""> RSS-подписка</a>
    </div>

    <ul class="how-its-done news" style="margin-top: 40px; padding-bottom: 0px; margin-bottom: 0px;">
        <?php foreach ($model as $news) : ?>
            <li style="width: 100%; margin-bottom: 30px;">
                <div class="news_date"><?= date('d.m.Y',strtotime($news->date)) ?></div>
                <a href="<?= Url::toRoute(['sale-news/news-view', 'url' => $news->url]) ?>" class="news_title">
                    <?= $news->name ?></a>
                <br><br>
                <?= $news->text_preview ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
