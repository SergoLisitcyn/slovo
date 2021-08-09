<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <style>
        #buttonUp{
            position: fixed;
            bottom: 1em;
            right: 1em;
            width: 64px;
            height: 64px;
            z-index: 99999;
            cursor: pointer;
            opacity: 0.6;
        }
        #buttonUp .hide{
            display: none;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="css/notification-banner.css" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="page-wrapper">
    <div class="header">
        <div class="width-wrapper">
            <div class="logo">
                <a href="/"><img src="/images/logo.png" alt=""/></a>
            </div>
            <div class="given">
            </div>
            <ul class="menu menu-right">
                <li><a href="usloviya/index.html" class="f">Условия</a></li>
                <li><a href="privileges/index.html">Постоянным клиентам</a></li>
                <li><a href="faq/index.html">FAQ</a></li>
            </ul>
            <ul class="menu menu-left">
                <li><a href="kak-poluchit-zaym/index.html" class="f">Как получить деньги</a></li>
                <li><a href="vozvrat-zaima/index.html">Как погасить микрокредит</a></li>
            </ul>
            <div class="personal">
                <ul>
                    <li class="first">
                        <a href="user.html">Войти</a>
                    </li>
                </ul>
                <div class="icon"></div>
            </div>
            <div class="phones">
                <ul>
                    <li class="first tooltip-anchor">
                        <a href="contact_mfo/index.html">Обратная связь</a>
                    </li>
                </ul>
                <div class="icon"></div>
            </div>
        </div>
    </div>
    <div class="promo-slider">
        <div class="in">
            <div class="slider-scene">
                <div class="slider theme-default">
                    <img src="/img/slider/75.jpg" title="#t75" />
                </div>
                <div id="t75" class="caption">
                    <div class="h1">
                        <span style="color:white">Получите микрокредит онлайн уже сегодня!</span>
                    </div>
                    <div class="h2">
                        <span style="color:black">Переводим на карту или счет</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="slider-shadow"></div>
    </div>
    <div class="content">
        <div class="width-wrapper">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
    <div class="footer footer-height-wrapper">
        <div class="width-wrapper">
            <form method="post" action="https://cp.unisender.com/ru/subscribe?hash=5hrptazc1qa1jyrb5s5yd91hz7za4tp8r5yu63xz7ddtb7ejskc6o" us_mode="embed" target="_blank" class="subscribe">
                <input type="hidden" name="charset" value="UTF-8"/>
                <input type="hidden" name="default_list_id" value="6962694"/>
                <input type="hidden" name="overwrite" value="2" />
                <p style="margin-top: -22px">Подпишитесь на рассылку и первыми<br />
                    узнавайте о специальных предложениях.</p>
                <input type="text" name="email" placeholder="Ваш e-mail" class="us_input field" /><input type="submit" value="" class="button us_submit" />
            </form>


            <div class="phones">
                <strong><a href="contact/open.php.html">Клиентская поддержка:</a></strong>
                <div>+7 (727) 3393404</div>
                <a href="mailto:mfo@4slovo.kz">mfo@4slovo.kz</a>
            </div>

            <ul class="menu">
                <li><a href="about/index.html">О компании</a></li>
                <li><a href="blog/index.html">Блог</a></li>
                <li><a href="actions/index.html">Акции</a></li>
                <li><a href="news/index.html">Новости</a></li>
                <li><a href="press/index.html">СМИ о нас</a></li>
                <li><a href="usloviya/index.html">Условия</a></li>
                <li><a href="kak-poluchit-zaym/index.html">Как получить деньги</a></li>
                <li><a href="vozvrat-zaima/index.html">Как погасить микрокредит</a></li>
                <li><a href="faq/index.html">Вопросы и ответы</a></li>
                <li><a href="privileges/index.html">Постоянным клиентам</a></li>
                <li><a href="partners/index.html">Партнерам</a></li>
                <li><a href="friends/index.html">Приглашайте друзей</a></li>
            </ul>

            <div class="social">Мы в социальных сетях —
                <a href="https://vk.com/4slovo_kz" target="_blank"><img src="/images/vk.png" alt="вконтакте" width="30" height="30" /></a>
                <a href="https://www.facebook.com/4slovo.kz/" target="_blank"><img src="/images/fb.png" alt="facebook" width="30" height="30" /></a>
                <a href="https://www.instagram.com/4slovo_kz/?utm_source=4slovo_main" target="_blank"><img src="/images/in.png" alt="instagram" width="30" height="30" /></a>
            </div>

            <div class="copy">

                &copy; 2021 4slovo.kz - ТОО «МФО «Akshabar» с товарным знаком «Честное слово». Все права защищены.<br />
                Лицензия № 02.21.0020.М от 12.03.2021г., <br />
                выданная Агентством Республики Казахстан по регулированию и развитию финансового рынка. <br />
                Адрес: 050059, Казахстан, г. Алматы, пр. Аль-Фараби, д.19, н.п. 29а <br />
            </div>

        </div>
    </div>

    <div class="width-wrapper">
        <ul class="how-its-done2">
            <li><a href="protection-of-consumer-rights/index.html"><img alt="" src="images/shield.png" /></a></li>
            <li><img alt="" src="/images/visa.png" /></li>
            <li><img alt="" src="/images/visa2.png" /></li>
            <li><img alt="" src="/images/mastercard.png" /></li>
            <li><img alt="" src="/images/mastercard2.png" /></li>
            <li><img alt="" src="/images/kassa24.png" /></li>
            <li><img alt="" src="/images/kazfintech-logonew.png" /></li>
        </ul>
    </div>
</div>
<script src="http://cdn.krible.com/loader?code=b2fd05e4f8c2222fc274f7e9313a3019" async></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
