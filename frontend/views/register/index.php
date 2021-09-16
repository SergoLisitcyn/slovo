<?php
use yii\web\View;
use antkaz\vue\VueAsset;
use \frontend\assets\RegisterAsset;

VueAsset::register($this);
/* @var $this yii\web\View */

if(isset($settings->title) and !empty($settings->title)) { $this->title = $settings->title; }
if(isset($settings->keywords) and !empty($settings->keywords)) { $this->registerMetaTag(['name' => 'keywords','content' => $settings->keywords]); }
if(isset($settings->description) and !empty($settings->description)) { $this->registerMetaTag(['name' => 'description','content' => $settings->description]); }

$this->registerJsVar('__conditions', $conditions, $position = View::POS_BEGIN);
$this->registerJsVar('settingsRate', $settingsRate, $position = View::POS_BEGIN);
$this->registerJsFile(Yii::getAlias('@web') . 'js_register/vue.min.js', ['position' => View::POS_END]);
$this->registerJsFile(Yii::getAlias('@web') . 'js_register/slider.js', [
    'position' => View::POS_END,
    'depends' => ['yii\web\JqueryAsset', 'yii\jui\JuiAsset'],
    'type' => 'module'
]);
?>
<div id="media">
    <div id="component-slider">
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
                            <span class="mobile_pickvalue__value" :style="{color:promoTextColor}">{{newLoan.amount}}</span>
                            <span class="mobile_pickvalue__currency" :style="{color:promoTextColor}">
                              <span class="icon icon--ruble"></span>
                          </span>
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
                <div class="text text--margin_bottom_16"></div>
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
            </div>
            <div class="mobile_form_wrapper">
                <form
                        action="register/success"
                        method="post"
                        id="mobile_register"
                        class="mobile_form"
                >
                    <input
                            type="hidden"
                            name="Register[amount]"
                            v-model="newLoan.amount"
                            id="priceVal"
                    />
                    <input
                            type="hidden"
                            name="Register[term]"
                            v-model="newLoan.term"
                            id="daysVal"
                    />
                    <div class="mobile-control-group">
                        <label style="display: none;">ИИН/ЖСН:</label>
                        <div class="mobile-controls">
                            <input
                                    type="text"
                                    class="ym-record-keys label-jump formfield listeners input-mobile"
                                    placeholder="ИИН/ЖСН"
                                    value=""
                                    autocomplete="off"
                                    id="mobile_tin"
                                    name="Register[tin]"
                                    data-regexp-alert="ИИН не правильный"
                                    data-alert="Пожалуйста, укажите ИИН"
                            />
                            <label class="label-mobile"  for="mobile_tin">ИИН/ЖСН</label>
                        </div>
                    </div>
                    <div class="mobile-control-group">
                        <label style="display: none;">Фамилия/Тегі:</label>
                        <div class="mobile-controls">
                            <input
                                    type="text"
                                    class="ym-record-keys label-jump formfield listeners input-mobile"
                                    placeholder="Фамилия/Тегі"
                                    value=""
                                    autocomplete="off"
                                    required
                                    pattern="^[а-яё\-ӘәҒғЁёҚқҢңӨөҰұҮүҺһІі]{2,}$"
                                    id="secondName"
                                    name="Register[surname]"
                                    v-model="surname"
                                    data-regexp-alert="Вы ввели неверное значение в поле Фамилия"
                                    data-alert="Пожалуйста, укажите Вашу фамилию"
                            />
                            <label class="label-mobile"  for="secondName">Фамилия/Тегі:</label>
                        </div>
                    </div>
                    <div class="mobile-control-group">
                        <label style="display: none;">Имя/Аты:</label>
                        <div class="mobile-controls">
                            <input
                                    type="text"
                                    class="ym-record-keys label-jump formfield listeners input-mobile"
                                    placeholder="Имя/Аты"
                                    value=""
                                    autocomplete="off"
                                    required=""
                                    pattern="^[а-яё\-ӘәҒғЁёҚқҢңӨөҰұҮүҺһІі]{2,}$"
                                    id="name"
                                    name="Register[name]"
                                    v-model="name"
                                    data-regexp-alert="Вы ввели неверное значение в поле Имя"
                                    data-alert="Пожалуйста, укажите, как к Вам обращаться"
                            />
                            <label class="label-mobile"  for="name">Имя/Аты:</label>
                        </div>
                    </div>
                    <div class="mobile-control-group" id="patronymic">
                        <label style="display: none;">Отчество/Әкесінің:</label>
                        <div class="mobile-controls">
                            <input
                                    type="text"
                                    class="ym-record-keys label-jump formfield listeners input-mobile"
                                    placeholder="Отчество/Әкесінің"
                                    value=""
                                    autocomplete="off"
                                    pattern="^[а-яё\-ӘәҒғЁёҚқҢңӨөҰұҮүҺһІі]{2,}$"
                                    id="middleName"
                                    name="Register[patronymic]"
                                    v-model="patronymic"
                                    data-regexp-alert="Вы ввели неверное значение в поле Отчество"
                                    data-alert="Пожалуйста, укажите Ваше отчество"
                            />
                            <label class="label-mobile"  for="middleName">Отчество/Әкесінің</label>
                        </div>
                    </div>
                    <div class="mobile-control-group">
                        <div class="mobile-controls">
                            <input type="checkbox" id="checkbox__text-1" value="0" style="width: 30px;height: 30px;">
                            <label for="checkbox__text-1" style="vertical-align: sub;font-weight: 400;"
                            >Нет отчества/Тегі жоқ
                            </label>
                        </div>
                    </div>
                    <div class="mobile-control-group">
                        <label style="display: none;">Мобильный телефон | Ұялы телефон:</label>
                        <div class="mobile-controls">
                            <input
                                    type="text"
                                    id="mobile_phone1"
                                    class="ym-record-keys label-jump formfield listeners input-mobile"
                                    name="Register[phone]"
                                    placeholder="Мобильный телефон"
                                    autocomplete="off"
                                    required
                                    data-regexp-alert="Пожалуйста, введите полностью номер"
                                    data-alert="Пожалуйста, введите полностью номер"
                            />
                            <label class="label-mobile"  for="mobile_phone1">Мобильный телефон:</label>
                        </div>
                        <span style="color: #808080;font-size: 18px;padding: 0 30px;">Ұялы телефон</span>
                    </div>
                    <div class="mobile-control-group">
                        <div class="mobile-controls">
                            <input
                                    type="checkbox"
                                    name="agreement"
                                    id="privateagreement"
                                    class="ym-record-keys formfield listeners"
                                    v-model="privacyChecked"
                                    required
                            />
                            <label for="privateagreement" style="font-weight: normal;">
                                Я согласен с
                                <span
                                        class="modal-link mobile-modal-css"
                                        data-maindomain="true"
                                        data-target="/pravila/"
                                >правилами</span
                                >
                                предоставления микрокредитов и других услуг и даю
                                <span
                                        class="modal-link mobile-modal-css"
                                        data-target="/person_data_agreement/"
                                >согласие</span
                                >
                                на обработку моих персональных данных
                            </label>
                        </div>
                    </div>
                    <div class="mobile-submit-button">
                        <input
                                type="submit"
                                id="mobile-submit"
                                value="Получить деньги"
                                class="big-button big-button-green"
                        />
                    </div>
                </form>
            </div>
        </section>
        <!-- Desktop version content -->
        <div class="width-wrapper" id="main_form_content">
            <section class="content">
                <div class="container">
                    <div class="form__wrap">
                        <form class="form" id="register" action="register/success" method="post">
                            <h2 class="form__title">Оформить заявку на микрокредит</h2>
                            <div class="slider_container">
                                <div class="form__item">
                                    <div class="get-money-form" v-if="isDataLoaded" style="display:none;" v-bind:style="styleObject">
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
                                    <div class="form__registration-item">
                                        <div class="form__registration-item form-group">
                                            <label class="form__registration-label">ИИН/ЖСН</label>
                                            <input
                                                    type="text"
                                                    id="tin"
                                                    class="form__registration-input listeners ym-record-keys"
                                                    name="Register[tin]"
                                                    autocomplete="off"
                                                    placeholder="____________"
                                                    style="letter-spacing: 2px;"
                                                    required
                                            />
                                        </div>
                                        <label class="form__registration-label">Фамилия/Тегі</label>
                                        <input
                                                type="text"
                                                name="Register[surname]"
                                                v-model="surname"
                                                placeholder="Иванов"
                                                class="form__registration-input listeners ym-record-keys"
                                                autocomplete="off"
                                                value=""
                                                required
                                        />
                                    </div>
                                    <div class="form__registration-item">
                                        <label class="form__registration-label">Имя/Аты</label>
                                        <input
                                                type="text"
                                                placeholder="Иван"
                                                name="Register[name]"
                                                v-model="name"
                                                class="form__registration-input listeners ym-record-keys"
                                                autocomplete="off"
                                                value=""
                                                required
                                        />
                                    </div>
                                    <div class="form__registration-item" id="patronymic-desc">
                                        <label class="form__registration-label">Отчество/Әкесінің</label>
                                        <input
                                                type="text"
                                                placeholder="Иванович"
                                                name="Register[patronymic]"
                                                v-model="patronymic"
                                                class="form__registration-input listeners ym-record-keys"
                                                autocomplete="off"
                                                value=""
                                        />
                                    </div>
                                    <div class="form__registration-item accept">
                                        <input type="checkbox" id="checkbox__text-2" value="0">
                                        <label for="checkbox__text-2" style="font-weight: 400;"
                                        >Нет отчества/Тегі жоқ
                                        </label>
                                    </div>
                                    <div class="form__registration-item">
                                        <label class="form__registration-label"
                                        >Мобильный телефон/Ұялы телефон</label
                                        >
                                        <input
                                                type="text"
                                                id="phone1"
                                                class="form__registration-input listeners ym-record-keys"
                                                name="Register[phone]"
                                                placeholder="Введите Ваш контактный телефон"
                                                required
                                        />
                                    </div>
                                    <div class="form__registration-item accept">
                                        <input
                                                type="checkbox"
                                                id="accept__privacy"
                                                name="agreement"
                                                class="listeners ym-record-keys"
                                                v-model="privacyChecked"
                                                required
                                        />
                                        <label for="accept__privacy"
                                        >Я согласен с
                                            <span
                                                    class="modal-link desktop-modal-css"
                                                    data-maindomain="true"
                                                    data-target="/pravila/"
                                            >правилами</span
                                            >
                                            предоставления микрокредитов и других услуг и даю
                                            <span
                                                    class="modal-link desktop-modal-css"
                                                    data-target="/person_data_agreement/"
                                            >согласие</span
                                            >
                                            на обработку моих персональных данных</label
                                        >
                                    </div>
                                    <button
                                            type="submit"
                                            name="submit"
                                            onclick="if(!this.form['agreement'].checked){alert('Для продолжения регистрации необходимо дать согласие на обработку персональных данных');return false}"
                                            class="form__registration-btn"
                                    >
                                        Получить деньги
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="line">
        <div class="container">
            <div class="line__row"></div>
        </div>
    </div>
<!--    <section class="main-text">-->
<!--        <div class="container">-->
<!--            <div class="main-text__text">-->
<!--                --><?php //echo $settings->first_block ?>
<!--            </div>-->
<!---->
<!--            --><?php //echo $settings->content ?>
<!---->
<!--            <div class="main-text__readmore readmore">Подробнее</div>-->
<!--        </div>-->
<!--    </section>-->
    <!-- Согласие на обработку персональных данных -->
    <div id="modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 0; border-bottom: none">
                    <a class="close" data-dismiss="modal" style="width: 20px; height: 20px; float: right;margin-right: 5px">
                        <span aria-hidden="true" style="padding-left: 7px;">×</span>
                    </a>
                    <h3 class="modal-title" id="modalLabel"></h3>
                </div>
                <div class="modal-body" style="padding: 0px 15px 0px 15px;max-height:80vh;"></div>
                <div class="modal-footer">
                    <a class="close-modal" data-dismiss="modal" style="font-family: 'PT Sans', 'Trebuchet MS', 'Helvetica', 'sans-serif'; color: #fff; background: linear-gradient(to bottom, #81c38b 0%, #81c38b 50%, #489952 100%); border-color: #5cb85c; padding: 3px 10px 2px 10px; border-radius: 4px;">Закрыть</a>
                </div>
            </div>
        </div>
    </div>
</div>
