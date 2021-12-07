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
<div id="component-slider">
<!-- desktop version -->
    <div class="width-wrapper">
        <div class="get-money-form desktop-version">
            <div class="form__wrap">
                <form class="form" id="register" action="register" method="post">
                    <h2 class="form__title">МИКРОКРЕДИТЫ В КАЗАХСТАНЕ</h2>
                    <div class="slider_container">
                        <div class="form__item">
                            <div v-if="!isDataLoaded" class="slider_container__spinner" v-bind:style="styleLoader">Loading...</div>
                            <div v-if="isDataLoaded" style="display: none;" v-bind:style="styleObject">
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
        <div class="text desktop-version">
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
        <a href="register" class="scrollbutton desktop-version">Получить деньги онлайн</a>

        <?= $mainPage->text ?>

        <h2 class="lined desktop-version">
            <span>Акции и новости</span>
        </h2>
        <div class="desktop-version" style="height: 20px;">&nbsp;</div>
        <?= SalesNews::widget() ?>

        <h2 class="lined desktop-version">
            <span>Блог</span>
        </h2>
        <div class="desktop-version" style="height: 20px;">&nbsp;</div>
        <?= Blogs::widget() ?>
    </div>
<!-- mobile version -->
    <form class="mobile_form" action="register" method="post">
        <section class="mobile_content" id="mobile_main_form_content">
            <div class="mobile_slider_container">
                <div
                        class="text text--bold text--large text--center text--margin_bottom">
                    Я хочу получить
                </div>
                <template v-if="isDataLoaded" style="display:none;" v-bind:style="styleObject">
                    <pick-slider
                            class="mobile_pickvalue"
                            v-model="newLoan.amount"
                            @sliderposition="$event => sliderChange($event, 'amount')"
                            :sliderposition="amountSliderPosition"
                            :min="1"
                            :max="sliderMax.amount"
                            :step="1">
                        <div class="mobile_pickvalue__minus">
                            <span class="icon icon--minus"></span>
                        </div>
                        <div class="mobile_pickvalue__line"></div>
                        <div class="mobile_pickvalue__valuebox">
                            <div class="mobile_pickvalue__value" :style="{color:promoTextColor}">{{newLoan.amount}}</div>
                            <div class="mobile_pickvalue__currency" :style="{color:promoTextColor}">
                                <span class="icon icon--ruble"></span>
                            </div>
                        </div>
                        <div class="mobile_pickvalue__line"></div>
                        <div class="mobile_pickvalue__plus">
                            <span class="icon icon--plus"></span>
                        </div>
                    </pick-slider>
                </template>
                <div class="text text--dark_color text--light text--center">
                    от
                    <?php  echo ($conditions[0]['amountMin']/1000) ?> до
                    <?php echo ($conditions[0]['amountMax']/1000) ?> тыс. тенге
                </div>
                <div class="text text--margin_bottom_32"></div>
                <div class="text text--bold text--large text--center">На срок</div>
                <template v-if="isDataLoaded" :style="styleObject">
                    <pick-slider
                            class="mobile_pickvalue mobile_pickvalue--dark"
                            v-model="newLoan.term"
                            @sliderposition="$event => sliderChange($event, 'term')"
                            :sliderposition="termSliderPosition"
                            :min="1"
                            :max="sliderMax.term"
                            :step="1"
                    >
                        <div class="mobile_pickvalue__minus">
                            <span class="icon icon--minus_dark"></span>
                        </div>
                        <div class="mobile_pickvalue__line"></div>
                        <div class="mobile_pickvalue__valuebox">
                            <div class="mobile_pickvalue__value">{{newLoan.term}}</div>
                            <div
                                    class="mobile_pickvalue__currency mobile_pickvalue__currency--little"
                            >
                                {{newLoan.term | pluralizeRu("день", "дня", "дней")}}
                            </div>
                        </div>
                        <div class="mobile_pickvalue__line"></div>
                        <div class="mobile_pickvalue__plus">
                            <span class="icon icon--plus_dark"></span>
                        </div>
                    </pick-slider>
                </template>
                <template v-if="isTermSliderStartVisible">
                    <div class="text text--dark_color text--light text--center">
                        от {{newLoan.loanConditions.conditions[0].termMin}} до
                        {{newLoan.loanConditions.conditions[0].termMax}}
                        {{newLoan.loanConditions.conditions[0].termMax |
                        pluralizeRu("день","дня","дней") }}
                    </div>
                </template>
                <div class="text text--margin_bottom_16"></div>
                <div class="text text--center text--margin_bottom">
                    <template>
                        К возврату
                        <template>
                            <span class="text text--bold">{{newLoanReturn.amount}}</span>
                            <br />до
                            <span class="text text--bold">{{newLoanReturn.date | formatDateLocale }} года</span>
                        </template>
                    </template>
                </div>
                <div class="text text--margin_bottom_32"></div>
                <div class="mobile-mobile-button" style="display:flex;padding: 16px 0px 0px;justify-content:center;">
                    <input
                            type="submit"
                            id="mobile-submit"
                            value="Получить деньги онлайн"
                            class="big-button big-button-green"
                            style="width:288px;"
                    />
                </div>
            </div>
        </section>
    </form>
    <div class="mobile__footer-bottom">
        <ul class="mobile__footer-partners">
            <li><img src="/img_register/icon/shield.png" /></li>
            <li><img src="/img_register/icon/visa.png" /></li>
            <li><img src="/img_register/icon/visa2.png" /></li>
            <li><img src="/img_register/icon/mastercard.png" /></li>
            <li><img src="/img_register/icon/mastercard2.png" /></li>
            <li><img src="/img_register/icon/kassa24.png" /></li>
            <li><img src="/img_register/icon/kazfintech-logonew.png" /></li>
        </ul>
    </div>
</div>