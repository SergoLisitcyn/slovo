<?php
$this->title = 'Отзывы клиентов';
?>
<div class="response-page text-page">
    <div class="news_date" style="font-size: 12px; margin-left: 70px;"><a href="/">Микрокредиты</a> / Все отзывы </div>
    <h1>Отзывы клиентов о займах</h1>
    <div class="clients-slider" id='reviews-list'>
        <div id="slides">
            <div class="slides_container">
                <div style="margin-bottom: 40px">
                    <?php foreach ($reviews as $review) : ?>
                        <?php if($review->image) $image = $review->image;
                        else $image = 'img/response/default.png';
                        ?>
                        <p>
                            <img src="<?= $image ?>"  alt="" style="height: 174px;width: 174px"/>
                            <strong class="fio-city"><?= $review->name ?>, <?= $review->city ?></strong>
                            <span><span><?= $review->text ?></span></span>
                        </p>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>
