<?php
use \yii\helpers\Url;
/* @var $blogs common\models\Blog */
?>
<ul class="how-its-done news">
    <?php foreach ($blogs as $blog) : ?>
        <li>
            <div class="news_date"><?php if($blog->date) : echo $blog->date;endif;  ?></div>
            <a href="<?= Url::toRoute(['blog/view', 'url' => $blog->url]) ?>" class="news_title">
                <?= $blog->name ?></a>
            <br><br>
            <?= $blog->text_preview ?>
        </li>
    <?php endforeach; ?>
    <li class="filler" style="margin-bottom: 30px;"><a href="blog">Все записи в блоге</a></li>
</ul>
