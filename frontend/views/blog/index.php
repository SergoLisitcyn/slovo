<?php

use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BlogSearch */
/* @var $blogs common\models\Blog */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блог';
?>
<div class="get-money-form text-page">
    <h1>Блог</h1>
    <ul class="how-its-done news" style="margin-top: 40px; padding-bottom: 0; margin-bottom: 0;">
        <?php foreach ($blogs as $blog) : ?>
            <li style="width: 100%; margin-bottom: 30px;">
                <div class="news_date"><?= date('d.m.Y',strtotime($blog->date)) ?></div>
                <a href="<?= Url::toRoute(['blog/view', 'url' => $blog->url]) ?>" class="news_title">
                    <?= $blog->name ?></a>
                <br><br>
                <?= $blog->text_preview ?>
            </li>
        <?php endforeach; ?>
    </ul>

</div>
