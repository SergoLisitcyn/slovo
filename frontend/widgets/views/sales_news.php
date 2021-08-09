<?php
use \yii\helpers\Url;
/* @var $sales common\models\SaleNews */
?>
<ul class="how-its-done news">
    <?php foreach ($sales as $sale) : ?>
        <li>
            <div class="news_date"><?= date('d.m.Y',strtotime($sale->date)) ?></div>
            <?php if($sale->type == 0) : ?>
            <a href="<?= Url::toRoute(['sale-news/news-view', 'url' => $sale->url]) ?>" class="news_title">
            <?php else : ?>
                <a href="<?= Url::toRoute(['sale-news/sales-view', 'url' => $sale->url]) ?>" class="news_title">
            <?php endif; ?>
                <?= $sale->name ?></a>
            <br><br>
            <?= $sale->text_preview ?>
        </li>
    <?php endforeach; ?>
    <li class="filler" style="margin-bottom: 30px;">
        <a href="actions">Все акции</a>
        <a href="news">Все новости</a>
        <a href="press/index.html">СМИ
            о нас
        </a>
    </li>
</ul>
