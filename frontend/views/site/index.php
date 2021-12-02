<?php
use \frontend\widgets\Blogs;
use \frontend\widgets\SalesNews;
use \frontend\widgets\Review;
use yii\web\View;
use antkaz\vue\VueAsset;
/* @var $this yii\web\View */
VueAsset::register($this);
if(isset($mainPage->title) and !empty($mainPage->title)) { $this->title = $mainPage->title; }
if(isset($mainPage->keywords) and !empty($mainPage->keywords)) { $this->registerMetaTag(['name' => 'keywords','content' => $mainPage->keywords]); }
if(isset($mainPage->description) and !empty($mainPage->description)) { $this->registerMetaTag(['name' => 'description','content' => $mainPage->description]); }
$this->registerJsVar('__conditions', $conditions, $position = View::POS_BEGIN);
$this->registerJsVar('settingsRate', $settingsRate, $position = View::POS_BEGIN);
$this->registerJsFile(Yii::getAlias('@web') . 'js_register/slider.js', [
    'position' => View::POS_END,
    'depends' => ['yii\web\JqueryAsset', 'yii\jui\JuiAsset'],
    'type' => 'module'
]);
?>
<div class="get-money-form">
    <div id="component-slider">
    <div class="form__wrap">
        <form class="form" id="register" action="register" method="post">
            <h2 class="form__title">МИКРОКРЕДИТЫ В КАЗАХСТАНЕ</h2>
            <div class="slider_container">
                <div class="form__item">
                    <div v-if="isDataLoaded" v-bind:style="styleObject">
                        <div class="calculatorWrapper">
                            <p
                                    class="p ch1"
                                    style="
                          text-align: center;
                          font-size: 30px;
                          margin: 10px auto;
                        "
                            >
                                Я хочу получить
                                <span>
                          <ins
                                  style="
                              font-size: 30px;
                              font-weight: bold;
                              color: #32a041;
                            "
                          >{{newLoan.amount}}</ins
                          >
                          тенге</span
                                >
                            </p>
                            <div class="moneyBlock">
                                <loan-slider
                                        id="moneySlider"
                                        class="slider vue-slider-amount ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                        :class="{'slider--blue': !!newLoanReturn.amount.annuity}"
                                        v-model="newLoan.amount"
                                        :slider_type="'slider_amount_value'"
                                        @sliderposition="$event => sliderChange($event, 'amount')"
                                        :sliderposition="amountSliderPosition"
                                        :min="1"
                                        :max="sliderMax.amount"
                                        :step="1"
                                        :last_part="sliderLastPart.amount"
                                >
                                    <div class="startPart"></div>
                                    <div class="loan__parts">
                                        <template
                                                v-for="(condition, inx) in newLoan.loanConditions.conditions"
                                        >
                                            <div
                                                    :key="inx"
                                                    :class="sliderClass(inx)"
                                                    :style="sliderAmountStyle(inx)"
                                            ></div>
                                        </template>
                                    </div>
                                    <span class="sliderStart"
                                    >{{ newLoan.loanConditions.conditions[0].amountMin
                            }}</span
                                    >
                                    <span class="sliderEnd"
                                    >{{newLoan.loanConditions.conditions[0].amountMax}}</span
                                    >
                                    <input
                                            type="hidden"
                                            name="Register[amount]"
                                            v-model="newLoan.amount"
                                            id="priceVal"
                                    />
                                    <div class="slider-range">
                                        <template v-for="n in sliderMax.amount">
                                            <div
                                                    class="bg1"
                                                    :style="sliderAmountBgStyle(n)"
                                            ></div>
                                        </template>
                                    </div>
                                </loan-slider>
                            </div>
                            <div class="daysBlock" style="margin-top: 30px;">
                                <p style="font-size: 18px; text-align: center" id="need_more_money">Сумма cвыше {{maxConditionValue.amountMax}} тенге доступна постоянным клиентам</p>
                                <p
                                        class="p"
                                        style="
                            text-align: center;
                            font-size: 30px;
                            margin: 10px auto;
                          "
                                >
                                    На срок
                                    <span
                                    ><ins
                                                style="
                                font-size: 30px;
                                font-weight: bold;
                                color: #32a041;
                              "
                                        >
                              {{newLoan.term}}</ins
                                        >
                            <ins
                            >{{newLoan.term |
                              pluralizeRu("день","дня","дней")}}</ins
                            ></span
                                    >
                                </p>
                                <loan-slider
                                        id="daysSlider"
                                        class="slider vue-slider-term ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                        :class="{'slider--blue': !!newLoanReturn.amount.annuity}"
                                        v-model="newLoan.term"
                                        :slider_type="'slider_term_value'"
                                        @sliderposition="$event => sliderChange($event, 'term')"
                                        :sliderposition="termSliderPosition"
                                        :min="1"
                                        :max="sliderMax.term"
                                        :step="1"
                                        :last_part="sliderLastPart.term"
                                >
                                    <div class="startPart"></div>
                                    <div class="loan__parts">
                                        <template
                                                v-for="(condition, inx) in newLoan.loanConditions.conditions"
                                        >
                                            <div
                                                    :key="inx"
                                                    :class="sliderClass(inx)"
                                                    :style="sliderTermStyle(inx)"
                                            ></div>
                                        </template>
                                    </div>
                                    <span
                                            v-if="isTermSliderStartVisible"
                                            class="sliderStart"
                                    >{{newLoan.loanConditions.conditions[0].termMin}}
                            {{newLoan.loanConditions.conditions[0].termMin |
                            pluralizeRu("день","дня","дней")}}</span
                                    >
                                    <span class="sliderEnd"
                                    >{{newLoan.loanConditions.conditions[0].termMax}}
                            {{newLoan.loanConditions.conditions[0].termMin |
                            pluralizeRu("день","дня","дней")}}</span
                                    >
                                    <input
                                            type="hidden"
                                            name="Register[term]"
                                            v-model="newLoan.term"
                                            id="daysVal"
                                    />
                                    <div class="slider-range">
                                        <template v-for="n in sliderMax.term">
                                            <div
                                                    class="bg1"
                                                    :style="sliderTermBgStyle(n)"
                                            ></div>
                                        </template>
                                    </div>
                                </loan-slider>
                            </div>
                            <div
                                    class="paybackBlock wave_line"
                                    style="padding-top: 10px;"
                            >
                                <div
                                        class="text text--dark_color text--center"
                                        style="font-size: 24px;"
                                >
                                    К возврату
                                    <template>
                            <span class="text text--bold"
                            >{{newLoanReturn.amount}}</span
                            >
                                        до
                                        <span class="text text--bold"
                                        >{{newLoanReturn.date | formatDateLocale }}
                              года</span
                                        >
                                        <input
                                                type="hidden"
                                                name="returnamount"
                                                :value="newLoanReturn.amount"
                                                id="returnamount"
                                        />
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__line"></div>
            <div class="form__registration">
                <div class="form__registration-row">
                    <input type="submit" id="money_button" class="button return_button" value="Получить деньги онлайн">
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
<div class="text">
    <h2 class="lined">
        <span>Как это работает</span>
    </h2>
    <ul class="how-its-done">
        <li><img alt="" src="images/big-icon-a.png" /><strong>Оформите заявку</strong> на микрокредит<br />&nbsp;</li>
        <li><img alt="" src="images/big-icon-b.png" /><strong>Заявка рассматривается</strong> всего за пять минут<br />&nbsp;</li>
        <li><img alt="" src="images/big-icon-c.png" /><strong>Моментально</strong> деньги поступают на счёт<br />
            <a href="/page/usloviya">
                Узнать подробнее об условиях
            </a>
        </li>
        <li class="filler"></li>
    </ul>
    <?= Review::widget() ?>
    <h2 class="lined">
        <span>Наши преимущества</span>
    </h2>
    <div class="advantage">
        <div class="item-block">
            <div class="item">
                <img src="images/i/1.png" alt="">
                <p><strong><a href="/page/microzaym-srochno">Срочный перевод денег</a></strong></p>
            </div>
            <div class="item">
                <img src="images/i/2.png" alt="">
                <p><strong>Круглосуточная работа онлайн. Без звонков и посещений офиса</strong></p>
            </div>
            <div class="item">
                <img src="images/i/4.png" alt="">
                <p><strong>Перевод на <a href="/page/onlajn-zajm-v-kazahstane-na-bankovskij-schet">счет</a>
                        или <a href="/page/onlajn-zajmy-v-kazahstane-na-kartu">карту</a></strong></p>
            </div>
        </div>
        <div class="item-block">
            <div class="item">
                <img src="images/i/5.png" alt="">
                <p><strong><a href="/page/vozvrat-zaima">Удобные способы погашения микрокредита</a></strong></p>
            </div>
            <div class="item">
                <img src="images/i/8.png" alt="">
                <p><strong><a href="/page/privileges">Программа лояльности</a></strong></p>
            </div>
            <div class="item">
                <img src="images/i/10.png" alt="">
                <p><strong><a href="actions">Акции и специальные предложения</a></strong></p>
            </div>
        </div>
    </div>
    <p></p>
</div>
<a href="register" class="scrollbutton">Получить деньги онлайн</a>

<?= $mainPage->text ?>

<h2 class="lined">
    <span>Акции и новости</span>
</h2>
<div style="height: 20px;">&nbsp;</div>
<?= SalesNews::widget() ?>

<h2 class="lined">
    <span>Блог</span>
</h2>
<div style="height: 20px;">&nbsp;</div>
<?= Blogs::widget() ?>