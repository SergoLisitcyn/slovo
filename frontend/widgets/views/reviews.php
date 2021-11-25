<h2 class="lined">
    <span>Отзывы наших клиентов</span>
</h2>
<div class="clients-slider">
    <div id="slides">
        <div class="slides_container">
            <div>
                <?php foreach ($reviews as $review) :?>
                <p>
                    <?php if($review->image) $image = $review->image;
                     else $image = 'img/response/default.png';
                    ?>

                    <img alt="" src="<?= $image ?>" style="height: 174px;width: 174px"/>
                    <strong class="fio-city"><?= $review->name ?>, <?= $review->city ?></strong>
                    <span><span><?= $review->text ?></span></span>
                </p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<ul class='how-its-done news'>
    <li class='filler' style='display: list-item;'>
<!--        <a href='http://4slovo.kz/review-new.html' class='fancybox.ajax window-link2'>Оставить отзыв</a>-->
        <a href='reviews'>Все отзывы</a>
    </li>
</ul>
