<?php
use \frontend\widgets\Blogs;
use \frontend\widgets\SalesNews;
use \frontend\widgets\Review;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="get-money-form">
    <form action="register/index.html#get" method="post" class="register-form">
        <h1>Микрокредиты в Казахстане</h1>
        <div id="component-slider">
            <template v-if="isDataLoaded">
                <div class="calculatorWrapper" v-if="isDesktopSlider">
                    <p class="p ch1" style="text-align: center; font-size: 30px; margin: 10px auto;">Я хочу получить <span>
			<ins style="font-size: 30px;font-weight: bold;color: #32a041;">{{newLoan.amount}}</ins> тенге</span></p>
                    <div class="moneyBlock">
                        <loan-slider
                                id="moneySlider"
                                class="slider vue-slider-amount
						ui-slider
						ui-slider-horizontal
						ui-widget
						ui-widget-content
						ui-corner-all"
                                v-bind:class="{'slider--blue': !!newLoanReturn.amount.annuity}"
                                v-model="newLoan.amount"
                                :slider_type="'slider_amount_value'"
                                @sliderposition="$event => sliderChange($event, 'amount')"
                                :sliderposition="amountSliderPosition"
                                :min="1"
                                :max="sliderMax.amount"
                                :step="1"
                                :last_part="sliderLastPart.amount">
                            <div class="startPart"></div>
                            <div class="loan__parts">
                                <template v-for="(condition, inx) in newLoan.loanConditions.conditions">
                                    <div :key="inx"
                                         v-bind:class="sliderClass(inx)"
                                         v-bind:style="sliderAmountStyle(inx)"></div>
                                </template>
                            </div>
                            <span class="sliderStart">{{ newLoan.loanConditions.conditions[0].amountMin }}</span>
                            <template v-if="newLoan.loanConditions.conditions.length > 1">
                                <span class="sliderEquator">{{maxValueCurrentCondition.amountMax}}</span>
                                <span class="sliderEnd">{{maxConditionValue.amountMax}}</span>
                            </template>
                            <span class="sliderEnd" v-else>{{newLoan.loanConditions.conditions[0].amountMax}}</span>
                            <input type="hidden" name="amount1" v-model="newLoan.amount" id="priceVal">
                            <div class="slider-range">
                                <template v-for="n in sliderMax.amount">
                                    <div class='bg1' v-bind:style="sliderAmountBgStyle(n)"></div>
                                </template>
                            </div>
                        </loan-slider>
                    </div>
                    <div class="daysBlock" style="margin-top: 30px;">
                        <p style="font-size: 18px; text-align: center" id="need_more_money">Сумма cвыше {{maxConditionValue.amountMax}} тенге доступна постоянным клиентам</p>
                        <p class="p" style="text-align: center; font-size: 30px; margin: 10px auto;">На срок <span><ins
                                        style="font-size: 30px;font-weight: bold;color: #32a041;">
				{{newLoan.term}}</ins> <ins>{{newLoan.term | pluralizeRu("день","дня","дней")}}</ins></span></p>
                        <loan-slider
                                id="daysSlider"
                                class="slider vue-slider-term
						ui-slider
						ui-slider-horizontal
						ui-widget
						ui-widget-content
						ui-corner-all"
                                v-bind:class="{'slider--blue': !!newLoanReturn.amount.annuity}"
                                v-model="newLoan.term"
                                :slider_type="'slider_term_value'"
                                @sliderposition="$event => sliderChange($event, 'term')"
                                :sliderposition="termSliderPosition"
                                :min="1"
                                :max="sliderMax.term"
                                :step="1"
                                :last_part="sliderLastPart.term">
                            <div class="startPart"></div>
                            <div class="loan__parts">
                                <template v-for="(condition, inx) in newLoan.loanConditions.conditions">
                                    <div :key="inx"
                                         v-bind:class="sliderClass(inx)"
                                         v-bind:style="sliderTermStyle(inx)"></div>
                                </template>
                            </div>
                            <span v-if="isTermSliderStartVisible" class="sliderStart">{{newLoan.loanConditions.conditions[0].termMin}} {{newLoan.loanConditions.conditions[0].termMin | pluralizeRu("день","дня","дней")}}</span>
                            <template v-if="newLoan.loanConditions.conditions.length > 1">
                                <span class="sliderEquator">{{maxValueCurrentCondition.termMax}} {{maxValueCurrentCondition.termMax | pluralizeRu("день","дня","дней")}}</span>
                                <span class="sliderEnd">{{maxConditionValue.termMax}} {{maxConditionValue.termMax | pluralizeRu("день","дня","дней")}}</span>
                            </template>
                            <span v-else class="sliderEnd">{{newLoan.loanConditions.conditions[0].termMax}} {{newLoan.loanConditions.conditions[0].termMin | pluralizeRu("день","дня","дней")}}</span>
                            <input type="hidden" name="amount2" v-model="newLoan.term" id="daysVal">
                            <div class="slider-range">
                                <template v-for="n in sliderMax.term">
                                    <div class='bg1' v-bind:style="sliderTermBgStyle(n)"></div>
                                </template>
                            </div>
                        </loan-slider>
                    </div>
                    <div class="paybackBlock wave_line" style="padding-top: 10px">
                        <div class="text text--dark_color text--center" v-if="newLoanReturn.amount.annuity"
                             style="font-size: 22px">
                            К возврату
                            <span class="text text--bold">{{newLoanReturn.amount.totalReturnAmount}} ₸</span>
                            до <span
                                    class="text text--bold">{{newLoanReturn.date | formatDateLocale }} года</span><br>
                            Платёж <span class="text text--bold">{{newLoanReturn.amount.annuity}} ₸</span> раз в
                            месяц
                            <input type="hidden" name="returnamount" v-bind:value="newLoanReturn.amount.totalReturnAmount" id="returnamount">
                        </div>
                        <div class="text text--dark_color text--center" v-else style="font-size: 24px">
                            К возврату
                            <template v-if="promoType === 3">
						<span v-if="newLoan.loanConditions.promoString"
                              style="
								color: crimson;
								text-decoration: line-through;
								text-decoration-color: crimson;
								font-weight: 100;
								font-size: large;"
                        >{{newLoanReturn.realAmount}} ₸
						<input type="hidden" name="returnamount" v-bind:value="newLoanReturn.realAmount" id="returnamount">
						</span>
                                <span v-else
                                      class="text text--bold"
                                      style="color: #43B05C;"
                                >{{newLoanReturn.amount}} ₸
						<input type="hidden" name="returnamount" v-bind:value="newLoanReturn.amount" id="returnamount">
						</span>
                                до <span class="text text--bold">{{newLoanReturn.date | formatDateLocale }} года</span>
                            </template>
                            <template v-else>
                                <span class="text text--bold">{{newLoanReturn.amount}} ₸</span>
                                до <span class="text text--bold">{{newLoanReturn.date | formatDateLocale }} года</span>
                                <input type="hidden" name="returnamount" v-bind:value="newLoanReturn.amount" id="returnamount">
                            </template>
                        </div>
                    </div>
                </div>
                <div class="tab__content" v-else>
                    <div class="text text--bold text--large text--center text--margin_bottom">Я хочу получить</div>
                    <pick-slider
                            class="pickvalue"
                            v-model="newLoan.amount"
                            @sliderposition="$event => sliderChange($event, 'amount')"
                            :sliderposition="amountSliderPosition"
                            :min="1"
                            :max="sliderMax.amount"
                            :step="1">
                        <div class="pickvalue__minus">
                            <span class="icon icon--minus"></span>
                        </div>
                        <div class="pickvalue__line"></div>
                        <div class="pickvalue__valuebox">
                            <span class="pickvalue__value" :style="{color:promoTextColor}">{{newLoan.amount}}</span>
                            <span class="pickvalue__currency" :style="{color:promoTextColor}">
										<span class="icon icon--ruble"></span>
								</span>
                        </div>
                        <div class="pickvalue__line"></div>
                        <div class="pickvalue__plus">
                            <span class="icon icon--plus"></span>
                        </div>
                        <input type="hidden" name="amount1" v-model="newLoan.amount" id="priceVal">
                    </pick-slider>
                    <div class="text text--dark_color text--light text--center"	v-if="newLoan.loanConditions.conditions.length > 1">от
                        {{minConditionValue.amountMin / 1000}} до
                        {{maxConditionValue.amountMax / 1000}} тыс. тенге
                    </div>
                    <div class="text text--dark_color text--light text--center" v-else>от
                        {{newLoan.loanConditions.conditions[0].amountMin / 1000}} до
                        {{newLoan.loanConditions.conditions[0].amountMax / 1000}} тыс. тенге
                    </div>

                    <div class="text text--margin_bottom_32"></div>
                    <div class="text text--bold text--large text--center">На срок</div>
                    <pick-slider
                            class="pickvalue pickvalue--dark"
                            v-model="newLoan.term"
                            @sliderposition="$event => sliderChange($event, 'term')"
                            :sliderposition="termSliderPosition"
                            :min="1"
                            :max="sliderMax.term"
                            :step="1">
                        <div class="pickvalue__minus">
                            <span class="icon icon--minus_dark"></span>
                        </div>
                        <div class="pickvalue__line"></div>
                        <div class="pickvalue__valuebox">
                            <div class="pickvalue__value">{{newLoan.term}}</div>
                            <div class="pickvalue__currency pickvalue__currency--little">
                                {{newLoan.term | pluralizeRu("день", "дня", "дней")}}
                            </div>
                        </div>
                        <div class="pickvalue__line"></div>
                        <div class="pickvalue__plus">
                            <span class="icon icon--plus_dark"></span>
                        </div>
                        <input type="hidden" name="amount2" v-model="newLoan.term" id="daysVal">
                    </pick-slider>
                    <template v-if="newLoan.loanConditions.conditions.length > 1">
                        <div class="text text--dark_color text--light text--center">от
                            {{minConditionValue.termMin}} {{minConditionValue.termMin |
                            pluralizeRu("день","дня","дней")}} до
                            {{maxConditionValue.termMax}} {{maxConditionValue.termMax |
                            pluralizeRu("день","дня","дней")}}
                        </div>
                    </template>
                    <template v-else>
                        <template v-if="isTermSliderStartVisible">
                            <div class="text text--dark_color text--light text--center">от
                                {{newLoan.loanConditions.conditions[0].termMin}} до
                                {{newLoan.loanConditions.conditions[0].termMax}} {{newLoan.loanConditions.conditions[0].termMax |
                                pluralizeRu("день","дня","дней") }}
                            </div>
                        </template>
                    </template>
                    <div class="text text--margin_bottom_32"></div>
                    <div class="text text--center text--margin_bottom">
                        <template>
                            К возврату
                            <template v-if="promoType === 3">
						<span v-if="newLoan.loanConditions.promoString"
                              style="
								color: crimson;
								text-decoration: line-through;
								text-decoration-color: crimson;
								font-weight: 100;"
                        >{{newLoanReturn.realAmount}} ₸</span>
                                <span v-else
                                      class="text text--bold"
                                      style="color: #43B05C;font-size: large;"
                                >{{newLoanReturn.amount}} ₸</span>
                                <div class="text text--bold text--margin_top_8 text--margin_bottom_4">
                                    до {{newLoanReturn.date | formatDateLocale }} года
                                </div>
                            </template>
                            <template v-else>
                                <span class="text text--bold">{{newLoanReturn.amount}} ₸</span>
                                <br/>до <span class="text text--bold">{{newLoanReturn.date | formatDateLocale }} года</span>
                            </template>
                        </template>
                    </div>
                </div>
            </template>
        </div>
        <input type="submit" id="money_button" class="button return_button" value="Получить деньги онлайн"/>
    </form>
</div>
<div class="text">
    <h2 class="lined">
        <span>Как это работает</span>
    </h2>
    <ul class="how-its-done">
        <li><img alt="" src="images/big-icon-a.png" /><strong>Оформите заявку</strong> на микрокредит<br />&nbsp;</li>
        <li><img alt="" src="images/big-icon-b.png" /><strong>Заявка рассматривается</strong> всего за пять минут<br />&nbsp;</li>
        <li><img alt="" src="images/big-icon-c.png" /><strong>Моментально</strong> деньги поступают на счёт<br />
            <a href="usloviya/index.html">
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
                <p><strong><a href="microzaym-srochno/index.html">Срочный перевод денег</a></strong></p>
            </div>
            <div class="item">
                <img src="images/i/2.png" alt="">
                <p><strong>Круглосуточная работа онлайн. Без звонков и посещений офиса</strong></p>
            </div>
            <div class="item">
                <img src="images/i/4.png" alt="">
                <p><strong>Перевод на <a href="onlajn-zajm-v-kazahstane-na-bankovskij-schet/index.html">счет</a>
                        или <a href="onlajn-zajmy-v-kazahstane-na-kartu/index.html">карту</a></strong></p>
            </div>
        </div>
        <div class="item-block">
            <div class="item">
                <img src="images/i/5.png" alt="">
                <p><strong><a href="vozvrat-zaima/index.html">Удобные способы погашения микрокредита</a></strong></p>
            </div>
            <div class="item">
                <img src="images/i/8.png" alt="">
                <p><strong><a href="privileges/index.html">Программа лояльности</a></strong></p>
            </div>
            <div class="item">
                <img src="images/i/10.png" alt="">
                <p><strong><a href="actions/index.html">Акции и специальные предложения</a></strong></p>
            </div>
        </div>
    </div>
    <p></p>
</div>
<a href="register/index.html" class="scrollbutton">Получить деньги онлайн</a>

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