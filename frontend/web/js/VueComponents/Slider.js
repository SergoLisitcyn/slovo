function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}


var promoReferal = window.location.search && getUrlParameter('promostring');

function update_global_values () {
    if (typeof update_values === 'function') {
        update_values();
    }
}

var Pickvalue = (function () {
    function Pickvalue(args) {
        var _this = this;
        this.min = 1;
        this.max = 10;
        this.step = 1;
        this.value = 1;
        this.el = null;
        if (!args) {
            return;
        }
        this.setValueIfDefined("min", args.min);
        this.setValueIfDefined("max", args.max);
        this.setValueIfDefined("step", args.step);
        this.setValueIfDefined("value", args.value);
        this.setValueIfDefined("watcher", args.watcher);
        this.setValueIfDefined("el", args.element);

        if (args.element) {
            var down = args.element.getElementsByClassName("pickvalue__minus")[0];
            var up = args.element.getElementsByClassName("pickvalue__plus")[0];
            if ('ontouchstart' in window) {
                var clearInterval = function (e) {
                    clearTimeout(intervalID);
                    intervalID = false;
                    return true;
                }
                var intervalID;
                down.addEventListener("touchstart", function (e) {
                    e.preventDefault();
                    _this.down();
                    !intervalID ? intervalID = setInterval(_this.down.bind(_this), 300) : clearInterval(intervalID);
                });
                down.addEventListener('touchend', clearInterval)
                down.addEventListener('touchcancel', clearInterval)
                down.addEventListener('touchmove', function (e) {
                    e.targetTouches && e.targetTouches.length === 0 && clearTimeout(intervalID);
                })
                up.addEventListener("touchstart", function (e) {
                    e.preventDefault();

                    _this.up();
                    !intervalID ? intervalID = setInterval(_this.up.bind(_this), 300) : clearInterval(intervalID);
                });
                up.addEventListener('touchend', clearInterval)
                up.addEventListener('touchcancel', clearInterval)
                up.addEventListener('touchmove', function (e) {
                    e.targetTouches && e.targetTouches.length === 0 && clearTimeout(intervalID);
                })
            } else {
                down && down.addEventListener('click', function () {
                    _this.down();
                });
                up && up.addEventListener('click', function () {
                    _this.up();
                });
            }

        }
    }

    Pickvalue.prototype.up = function () {
        this.value += this.step;
        if (this.value > this.max) {
            this.value = this.max;
            return;
        }
        this.watch('valueChanged');
    };
    Pickvalue.prototype.down = function () {
        this.value -= this.step;
        if (this.value < this.min) {
            this.value = this.min;
            return;
        }
        this.watch('valueChanged');
    };
    Pickvalue.prototype.watch = function (msg) {
        if (this.watcher) {
            this.watcher(this.value)
        }
    };
    Pickvalue.prototype.setMin = function (value) {
        this.setValueIfDefined("min", value);
        if (this.value < this.min) {
            this.value = this.min;
            this.watch();
        }
    };
    Pickvalue.prototype.setMax = function (value) {
        this.setValueIfDefined("max", value);
        if (this.value > this.max) {
            this.value = this.max;
            this.watch();
        }
    };
    Pickvalue.prototype.setStep = function (value) {
        this.setValueIfDefined("step", value);
    };
    Pickvalue.prototype.setValue = function (value) {
        if (this.value != value) {
            this.setValueIfDefined("value", value);
            this.watch();
        }
    };
    Pickvalue.prototype.setValueIfDefined = function (name, value) {
        if (value) {
            this[name] = value;
        }
    };
    Pickvalue.prototype.destroy = function () {
    };
    return Pickvalue;
})();


Vue.filter('pluralizeRu', Util.pluralizeRu);

Vue.filter('sliderSteps', function (val, conditionsDiff, part) {
    return conditionsDiff[part + 'Total'].indexOf(val) + 1;
})

Vue.filter('formatDateLocale', function (date) {
    var months = ['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'];
    date = new SimpleDate(date);
    return date.day.leftPad() + ' ' + months[date.month - 1] + ' ' + date.year;
})

Vue.component('LoanSlider', {
    template: `<div
        ref="slider"
        v-bind:value="value">
        <slot></slot>
    </div>`,
    props: {
        value: [Number, String],
        min: Number,
        max: Number,
        step: Number,
        last_part: [String, Number],
        sliderposition: [Number, String],
        slider_type: String
    },
    data: function () {
        return {
            slider: null
        }
    },
    methods: {
        updateSlider: function (value) {
            this.slider.slider('value', value);
        },
        sliderOptions: function (context) {
            let sliderOpt = {
                min: this.min,
                max: this.max,
                step: this.step,
                value: this.max,
                slide: function (event, ui) {
                    context.$emit('sliderposition', ui.value);
                    context.updateSlider(ui.value);
                }.bind(this),
                range: "min"
            }
            if (this.min === this.max) {
                sliderOpt = Object.assign({}, sliderOpt, {
                    min: 0,
                    max: this.max,
                    start: ( event, ui ) => {
                        // запрещаем прокрутку слайдера
                        return false
                    }
                 })
            }
            return sliderOpt
        },
        initSlider: function () {
            const context = this
            this.slider = $(this.$refs.slider).slider(this.sliderOptions(context));
            this.slider.slider("value", this.sliderposition)
    
            var lastPart = this.$refs.slider.getElementsByClassName("lastPart")[0];
            var sliderEquator = this.$refs.slider.getElementsByClassName("sliderEquator")[0];
            if (lastPart) {
                lastPart.style.width = this.last_part + "%";
                lastPart.style["margin-left"] = (100 - this.last_part) + "%";
            }
    
            if (sliderEquator) {
                if (this.last_part > 90 || this.last_part < 10) {
                    sliderEquator.style["visibility"] = 'hidden';
                } else {
                    sliderEquator.style["visibility"] = 'visible';
                    sliderEquator.style["left"] = (100 - this.last_part) + "%";
                }
            }
        }
    },
    mounted: function () {
        this.initSlider()
    },
    watch: {
        min: function (newVal) {
            this.slider.slider('option', 'min', newVal);
        },
        max: function (newVal) {
            this.slider.slider('option', 'max', newVal);
        },
        step: function (newVal) {
            this.slider.slider('option', 'step', newVal);
        },
        last_part: function (newVal) {
            const lastPart = this.$refs.slider.getElementsByClassName("lastPart")[0];
            const sliderEquator = this.$refs.slider.getElementsByClassName("sliderEquator")[0];
      
            if (lastPart) {
                lastPart.style.width = this.params.last_part + "%";
                lastPart.style["margin-left"] = (100 - this.params.last_part) + "%";
            }
  
            if (sliderEquator) {
                if (newVal > 90 || newVal < 10) {
                    sliderEquator.style["visibility"] = 'hidden';
                } else {
                    sliderEquator.style["visibility"] = 'visible';
                    sliderEquator.style["left"] = (100 - newVal) + "%";
                }
            }
        }
    },
    updated: function () {
        this.slider.slider("value", this.sliderposition)
    },
    beforeDestroy: function () {
        this.slider.slider('destroy')
    }
})

Vue.component('PickSlider', {
    template: `<div
        ref="pickvalue"
        v-bind:value="value">
        <slot></slot>
        </div>`,
    props: {
        value: [Number, String],
        min: Number,
        max: Number,
        step: Number,
        sliderposition: [Number, String]
    },
    data: function () {
        return {
            pickvalue: null
        }
    },
    methods: {
        updateSlider: function (value) {
            this.pickvalue.setValue(value)
        },
        initSlider: function () {
            const context = this
            this.pickvalue = new Pickvalue({
                element: this.$refs.pickvalue,
                min: this.min,
                max: this.max,
                step: this.step,
                value: this.max,
                watcher: function () {
                    context.$emit('sliderposition', this.pickvalue.value)
                    context.updateSlider(this.pickvalue.value)
                }.bind(this)
            })
            this.pickvalue.setValue(this.sliderposition)
        }
    },
    mounted: function () {
        this.initSlider()
    },
    watch: {
        min: function (newVal) {
            this.pickvalue.setMin(newVal);
        },
        max: function (newVal) {
            this.pickvalue.setMax(newVal);
        },
        step: function (newVal) {
            this.pickvalue.setStep(newVal);
        }
    },
    updated: function () {
        this.pickvalue.setValue(this.sliderposition)
    },
    beforeDestroy: function () {
        this.pickvalue.destroy()
    }
})


new Vue({
    el: '#component-slider',
    data: {
        isDataLoaded: false,
        isDesktopSlider: ISDESKTOPSLIDER,
        seen: true,
        isHaveCreditTypes: false,
        creditType: 'MicroCredit',
        immutableConditions: [],
        currentConditionIndex: 0,
        loanData: {},
        newLoan: {
            account: {},
            amount: 0,
            amountMax: 0,
            term: 0,
            termMax: 0,
            userPromo: ($.cookie().promoCode && $.cookie().promoCode.length > 10 ? JSON.parse($.cookie().promoCode).promoCode : $.cookie().promoCode),
            promoChecking: false,
            userPhone: '',
            loanConditions: {},
            initialConditions: {},
            promoConditions: {},
            billStop: {},
            creditStop: {},
            personBlocked: {},  // attension! create element necessery
            oldRate: 0.04,
            havePromo: false,
            agreed: false,
            confirm: false,
            nbkiConfirm: false,
            agreementModal: false,
            consumerCreditNotification: false,
            confirmText: {
                header: "",
                content: ""
            },
            personFullName: "",
            documentNeeded: false,
            documentAuth: {
                loading: false,
                passportErrors: [],
                passportBackErrors: [],
                passport: null,
                passportBack: null
            }
        },
        use_promo_lk: 0
    },
    updated: function () {
        update_global_values();
    },
    created: function () {
        if (_LOANCONDITIONS.promoString && !this.newLoan.userPromo) {
            this.newLoan.userPromo = _LOANCONDITIONS.promoString;
        }

        this.newLoan.loanConditions = _LOANCONDITIONS
        this.immutableConditions = _LOANCONDITIONS.conditions

        // let cookieCreditType = $.cookie('creditType');

        const uniqueId = {
            values: [...new Set(_LOANCONDITIONS.conditions
                .map(condition => condition.product))],
            length: [...new Set(_LOANCONDITIONS.conditions
                .map(condition => condition.product))].length
        }

        if (uniqueId.length > 1) this.isHaveCreditTypes = true
        if (uniqueId.length === 1) {
            if (uniqueId.values[0] === 1) this.creditType = 'MicroCredit'
            if (uniqueId.values[0] === 2) this.creditType = 'ConsumerCredit'
            // this.saveValueInCookie('creditType', this.creditType)
        } else {
            // весь код связанный с creditType разкомментировать когда backend сумеет сохранять разные типы
            // this.creditType = cookieCreditType
        }

        this.recalcConditions(this.creditType)
        this.restoreData()
        this.setBaseRestrictions();

        /*
        * Автоматичемское применение промокода
        * */
        if (promoReferal && promoReferal.length > 0) {
            this.newLoan.userPromo.length === 0 && this.$set('newLoan.userPromo', promoReferal);
            this.use_promo_lk = 1
        }
        if (this.use_promo_lk) {
            this.newLoan.havePromo = true;
            var that = this;
            this.$set('loading', false);
            this.applyPromo()
                .then(function () {
                    that.usePromo()
                })
                .catch(function (error) {
                    that.$set('loading', false);
                });
        }
        this.isDataLoaded = true
    },
    methods: {
        restoreData: function() {
            let amount = Number($.cookie('slider_amount_value'));
            let term = Number($.cookie('slider_term_value'));

            // восстановление суммы и срока по данным полученных от бэка
            // let amount = 0
            // let term = 0
            // if (typeof amount1 === 'undefined') amount = this.newLoan.loanConditions.conditions[0].amountMax;
            // else amount = amount1
            // if (typeof amount2 === 'undefined') term = this.newLoan.loanConditions.conditions[0].termMax;           
            // else term = amount2

            if (!amount) amount = this.newLoan.loanConditions.conditions[0].amountMax;
            if (amount === 0) amount = this.newLoan.loanConditions.conditions[0].amountMax;
            if (term === 0) term = this.newLoan.loanConditions.conditions[0].termMax;
            if (!term) term = this.newLoan.loanConditions.conditions[0].termMax;
        
            // проверка conditions после восстановления
            // необходимо найти индекс loanCondition которму может соответствовать сумма и срок займа
            const candidateConditionIndex = this.calcConditionIndexNew(amount, term)
            if (candidateConditionIndex >= 0) {
                this.currentConditionIndex = candidateConditionIndex
                this.newLoan.amount = amount
                this.newLoan.term = term
            } else {
                this.currentConditionIndex = 0
                this.newLoan.amount = this.newLoan.loanConditions.conditions[0].amountMax
                this.newLoan.term = this.newLoan.loanConditions.conditions[0].termMax
                this.saveValueInCookie('slider_amount_value', this.newLoan.loanConditions.conditions[0].amountMax)
                this.saveValueInCookie('slider_term_value', this.newLoan.loanConditions.conditions[0].termMax)
                this.saveValueInCookie('m1', this.newLoan.loanConditions.conditions[0].amountMax)
                this.saveValueInCookie('m2', this.newLoan.loanConditions.conditions[0].termMax)
            }
        },
        sliderValueToStep: function (val, part) {
            return this.conditionsDiff[part + 'Total'].indexOf(val) + 1;
        },
        sliderStepToValue: function (val, oldVal, part) {
            var result = this.conditionsDiff[part + 'Total'][val - 1];
            if (part === 'term' && this.newLoan.loanConditions.periodFree) {
                if (result > (this.maxConditionValue.termMax - this.newLoan.loanConditions.periodFree)) {
                    (val > oldVal)
                        ? (result = this.maxConditionValue.termMax)
                        : (result = this.maxConditionValue.termMax - this.newLoan.loanConditions.periodFree);
                }
            }
            return result;
        },
        saveValueInCookie: function (key, value) {
            $.cookie(`${key}`, value, { expires: 7, path: '/' , domain: ecopt.domain});
        },
        sliderChange: function (value, part) {
            const prevTerm = this.newLoan.term
            const prevAmount = this.newLoan.amount
            if (part === 'term') {
                const term  = this.sliderStepToValue(value, prevTerm, part)
                this.saveValueInCookie('slider_term_value', term)
                this.saveValueInCookie('m2', term)
                this.newLoan.term = term
            }
            if (part === 'amount') {
                const amount = this.sliderStepToValue(value, prevAmount, part)
                this.saveValueInCookie('slider_amount_value', amount)
                this.saveValueInCookie('m1', amount)
                this.newLoan.amount = amount
            }
        },
        sliderTermBgStyle: function (n) {
            const points = this.sliderMax.term - 1
            const dif = 100 / points
            const left = dif*(n-1)
            return {
                left: `${left}%`,
                'z-index': 2
            }
        },
        sliderAmountBgStyle: function (n) {
            const points = this.sliderMax.amount
            const dif = 100 / points
            const left = dif*(n-1)
            return {
                left: `${left}%`,
                'z-index': 2
            }
        },
        sliderClass: function (inx) {
            return `loan__parts-item loan__parts-item_${inx}`
        },
        sliderAmountStyle: function (inx) {
            return {
                width: this.sliderParts[inx].amount + '%',
                'margin-left': 100 - this.sliderParts[inx].amount +'%',
                'z-index': this.newLoan.loanConditions.conditions.length - inx
            }
        },
        sliderTermStyle: function (inx) {
            return {
                width: this.sliderParts[inx].term.width + '%',
                'margin-left': this.sliderParts[inx].term.marginLeft +'%',
                'z-index': 2
            }
        },
        setBaseRestrictions: function () {
            this.promoRestrictions = {
                minAmount: this.newLoan.loanConditions.conditions[0].amountMin,
                maxAmount: this.newLoan.loanConditions.conditions[0].amountMax,
                minPeriod: this.newLoan.loanConditions.conditions[0].termMin,
                maxPeriod: this.newLoan.loanConditions.conditions[0].termMax
            };
        },
        getConditions: function () {
            return this.conditions
        },
        recalcConditions:  function (creditType) {
            switch (creditType) {
                case 'MicroCredit':
                    this.currentConditionIndex = 0
                    this.newLoan.loanConditions.conditions = this.immutableConditions.filter(condition => condition.product === 1)
                    break;
                case 'ConsumerCredit':
                    this.currentConditionIndex = 0
                    this.newLoan.loanConditions.conditions = this.immutableConditions.filter(condition => condition.product === 2)
                    break;
                default: 
                    break;
            }
        },
        prevTermConditions: function (inx) {
            const prevTermConditions = this.conditionsDiff.termArrays.filter((term, termInx) => termInx <= inx)
            .reduce((acc, val) => acc.concat(val), [])
            return prevTermConditions
        },
        setSliderToMaximum: function () {
            this.$set('currentConditionIndex', this.newLoan.loanConditions.conditions.length - 1);
            this.$set('newLoan.term', this.maxConditionValue.termMax);
        },
        conditionIndex (element, val) {
            const { amountMax } = element
            if (+val > +amountMax) return false
            return +amountMax >= +val
        },
        calcConditionIndex: function (val) {
            return this.newLoan.loanConditions.conditions.map(condition => {
                const { amountMax, amountMin, termMax, termMin } = condition
                return {
                    amountMax,
                    amountMin,
                    termMax,
                    termMin
                }
            }).findIndex((element) => this.conditionIndex(element, val))
        },
        calcConditionIndexNew: function (amount, term) {
            // правило работает при условии непересечения conditions
            const currentConditionId = this.newLoan.loanConditions.conditions.filter(condition => {
                const { amountMax, amountMin } = condition
                return amount >= amountMin && amount <= amountMax
            }).filter(condition => {
                const { termMax, termMin } = condition
                return term >= termMin && term <= termMax
            }).map(condition => condition.id)[0]

            return this.newLoan.loanConditions.conditions.map(condition => condition.id).indexOf(currentConditionId)
        }
    },
    computed: {
        isTermSliderStartVisible: function () {
            if (this.minConditionValue.termMin === this.maxConditionValue.termMax) return false
            return true
        },
        termSliderPosition: function () {
            return this.sliderValueToStep(this.newLoan.term, 'term')
        },
        amountSliderPosition: function () {
            return this.sliderValueToStep(this.newLoan.amount, 'amount')
        },
        isMicroCredit: function () {
            return this.creditType === 'MicroCredit'
        },
        maxValueCurrentCondition: function () {
            return  {
                amountMax: this.realConditions.amountMax,
                termMax: this.realConditions.termMax,
            }
        },
        sliderParts: function () {
            if (!this.conditionsDiff) return false;

            const totalLength = {
                amount: this.conditionsDiff.amountTotal.length,
                term: this.conditionsDiff.termTotal.length
            };

            const sliderParts = []

            let marginLeft = 0

            this.newLoan.loanConditions.conditions.forEach((item, inx) => {
                const currentLength = {
                    amount: this.conditionsDiff.amountArrays[inx].length,
                    term: this.conditionsDiff.termArrays[inx].length
                }; // текущее положение, к какому condition мы относимся

                const result = {
                    amount: totalLength.amount === currentLength.amount
                        ?  0
                        : (100 * (totalLength.amount - currentLength.amount) / totalLength.amount),
                    term:  {
                        width: totalLength.term === currentLength.term
                        ?  0
                        : (100 * (currentLength.term) / totalLength.term),
                        marginLeft
                    }
                };
                sliderParts.push(result)
                marginLeft += (100 * (currentLength.term) / totalLength.term)
            })
            return sliderParts
        },
        sliderLastPart: function () {
            if (!this.conditionsDiff) return false;

            var totalLength = {
                amount: this.conditionsDiff.amountTotal.length,
                term: this.conditionsDiff.termTotal.length
            };

            var currentLength = {
                amount: this.conditionsDiff.amountArrays[this.currentConditionIndex].length,
                term: this.conditionsDiff.termArrays[this.currentConditionIndex].length
            }; // текущее положение, к какому condition мы относимся

            var firstPartLength = {
                amount: this.conditionsDiff.amountArrays[0].length,
                term: this.conditionsDiff.termArrays[0].length
            };

            if (this.newLoan.loanConditions.conditions.length === 1) {
                return {
                    amount: 0,
                    term: 0
                };
            }

            const prevTermConditions = this.prevTermConditions(this.currentConditionIndex).length

            const result = {
                amount: totalLength.amount === currentLength.amount
                    ?  100
                    : (100 * (totalLength.amount - currentLength.amount) / totalLength.amount),
                term:  totalLength.term === prevTermConditions.term
                    ?  100
                    : (100 * (1 - prevTermConditions / totalLength.term)),
            };

            return result
        },
        checkDocumentAuthReady: function () {
            if (this.newLoan.documentAuth.passport &&
                this.newLoan.documentAuth.passportBack) {
                return typeof this.newLoan.documentAuth.passport.name === 'string' &&
                    typeof this.newLoan.documentAuth.passportBack.name === 'string' &&
                    this.newLoan.documentAuth.passportErrors.length === 0 &&
                    this.newLoan.documentAuth.passportBackErrors.length === 0;
            }
        },
        documentAuthButtonClass: function () {
            return {
                'button': true,
                'button_disabled': !this.checkDocumentAuthReady,
                'button_loading': this.newLoan.documentAuth.loading
            }
        },
        readyForNew: function () {
            return typeof this.loanData.loans === "undefined" && Object.keys(this.newLoan.loanConditions).length > 0
        },
        promoType: function () {
            return this.newLoan.loanConditions.tid
                ? this.newLoan.loanConditions.tid
                : 0;
        },

        promoClass: function () {
            return 'promo-tag promo-tag_' + this.promoType;
        },

        promoTextColor: function () {
            return this.promoType === 3 ? '#DA1B23' : '#43B05C';
        },

        maxConditionValue: function () {
            if (Object.keys(this.newLoan.initialConditions).length) return {
                amountMax: Math.max.apply(Math, this.newLoan.initialConditions.conditions.map(function (o) { return o.amountMax; })),
                termMax: Math.max.apply(Math, this.newLoan.initialConditions.conditions.map(function (o) { return o.termMax; }))
            }
        },

        promoTagText: function () {
            switch (this.promoType) {
                case 3:
                    return '0%';
                default:
                    return '';
            }
        },

        promoState: function () {
            return this.isValueInRange(this.newLoan.amount, [this.promoRestrictions.minAmount, this.promoRestrictions.maxAmount])
                && this.isValueInRange(this.newLoan.term, [this.promoRestrictions.minPeriod, this.promoRestrictions.maxPeriod]);
        },

        buttonText: function () {
            switch (this.promoType) {
                case 3:
                    return 'Получить деньги без перелат';
                case 11:
                    return 'Получить деньги с выгодой!';
                default:
                    return 'Получить деньги онлайн';
            }
        },

        mainLoan: function () {
            if (!this.loanData.loans) {
                return undefined;
            }

            var filter = Vue.options.filters["loan.needRepay"];

            for (var i = 0; i < this.loanData.loans.length; i++) {
                if (filter(this.loanData.loans[i])) {
                    return this.loanData.loans[i];
                }
            }

            return undefined;
        },

        mainLoans: function () {
            if (!this.loanData.loans) {
                return undefined;
            }

            var filter = Vue.options.filters["loan.needRepay"];

            return this.loanData.loans.filter(filter);
        },

        loanConfirmable: function () {
            if (!this.loanData.loans) {
                return undefined;
            }

            var i;
            var loan;

            for (i = 0; i < this.loanData.loans.length; i++) {
                if (this.loanData.loans[i].available_confirm_credit) {
                    loan = this.loanData.loans[i];
                }
            }

            if (!loan) {
                return;
            }

            loan.parts.sort(function (a, b) {
                return a.id > b.id;
            });

            var parts = loan.parts;
            var completed = 0;

            for (i = 0; i < parts.length; i++) {
                if (parts[i].status != -1) {
                    completed++;
                }

            }

            for (i = 0; i < completed && i < parts.length; i++) {
                parts[i].complete = true;
                parts[i].active = false;
            }

            if (parts.length > completed) {
                parts[completed].active = true;
            }


            return loan;
        },

        loanInProgress: function () {
            if (!this.loanData.loans) {
                return undefined;
            }

            for (var i = 0; i < this.loanData.loans.length; i++) {
                if (this.loanData.loans[i].status == 0) {
                    return this.loanData.loans[i];
                }
            }

            return undefined;
        },
        loanDenied: function () {
            if (!this.loanData.loans) {
                return undefined;
            }

            if (!this.newLoan) {
                return undefined;
            }

            if (!this.newLoan.creditStop.stop) {
                return undefined;
            }

            for (var i = 0; i < this.loanData.loans.length; i++) {
                if (this.loanData.loans[i].status == 100) {
                    return this.loanData.loans[i];
                }
            }

            return undefined;
        },
        loanHistory: function () {
            if (!this.loanData.loans) {
                return undefined;
            }

            var mainStatuses = [-1, 0, 2, 4, 5, 6, 7, 77, 90, 91, 92, 93, 200];
            var history = [];

            for (var i = 0; i < this.loanData.loans.length; i++) {
                if (mainStatuses.indexOf(this.loanData.loans[i].status) == -1) {
                    history.push(this.loanData.loans[i]);
                }
            }

            return history;
        },
        loanYears: function () {
            if (!this.loanData.loans) {
                return [];
            }

            return this.loanData.loans.reduce(function (yearlist, loan) {
                var year = new Date(loan.create_ts).getFullYear();
                if (yearlist.indexOf(year) === -1) {
                    yearlist.push(year);
                }
                return yearlist;
            }, []).sort().reverse();
        },
        newLoanReturn: function () {
            if (!this.realConditions) {
                return undefined;
            }
            var d = new Date();
            d.setDate(d.getDate() + parseInt(this.newLoan.term));
            const amount = {
                amount: Util.getReturnAmount(this.newLoan.amount, this.newLoan.term, this.newLoan.loanConditions, this.realConditions, this.creditType),
                realAmount: Util.getRealAmount(this.newLoan.amount, this.newLoan.term, this.realConditions),
                amountStrikeout: Math.round(this.newLoan.amount * (1 + this.newLoan.term * this.newLoan.oldRate)),
                date: d
            }
            return amount
        },
        isTextPage: function () {
            return (Object.keys(router.urls).indexOf(this.url) == -1);
        },
        // code from Russian lk
        realConditions: function () {
            if (!this.newLoan.loanConditions.conditions) return undefined;
            var condition = this.newLoan.loanConditions.conditions[this.currentConditionIndex]
                || this.newLoan.loanConditions.conditions[0];
            var resultCondition = Object.assign({}, condition, { percent: condition.rate * 100 })
            return resultCondition;
        },
        sliderMax: function () {
            if (this.newLoan.loanConditions) {
                return {
                    amount: this.conditionsDiff.amountTotal.length,
                    term: this.conditionsDiff.termTotal.length
                }
            }
        },
        conditionsDiff: function () {
            if (!this.newLoan.loanConditions.conditions) return false;
            var conditions = this.newLoan.loanConditions.conditions;
            var ranges = Util.takeSliderRangesFromConditions(this.newLoan.loanConditions.conditions);
            
            var amountArrays = [];
            var termArrays = [];
            var aStep = 0;
            var tStep = 0;

            const amountSteps = []
            const termSteps = []

            let inx = 0

            const concatTermArrays = []

            conditions.forEach(function (c, i) {
                if (inx !== i) {
                    const arrayFromRange = Util.createArrayFromRange(ranges.termRanges[i], c.termStep)
                    const lastTermArrayIndex = termArrays.length - 1
                    const intermediate = [termArrays[lastTermArrayIndex].slice(-1)[0], arrayFromRange.slice(0, 1)[0]]
                    concatTermArrays.push(intermediate)
                    inx = i
                }
                amountArrays.push(Util.createArrayFromRange(ranges.amountRanges[i], c.amountStep));
                termArrays.push(Util.createArrayFromRange(ranges.termRanges[i], c.termStep));
                concatTermArrays.push(Util.createArrayFromRange(ranges.termRanges[i], c.termStep));
                aStep = c.amountStep;
                tStep = c.termStep;
                amountSteps.push(c.amountStep);
                termSteps.push(c.termStep);
            });

            const termTotal = [...new Set(concatTermArrays.reduce((acc, val) => acc.concat(val), []))]

            // Учтено, что step может меняться
            const result = {
                amountDiff: Util.intersection(amountArrays), // пересечения условий по сумме
                termDiff: Util.intersection(termArrays), // пересечения условий по дням
                amountTotal: Util.createArrayFromRange([this.minConditionValue.amountMin, this.maxConditionValue.amountMax], aStep),
                termTotal,
                amountRanges: ranges.amountRanges,
                termRanges: ranges.termRanges,
                amountArrays: amountArrays,
                termArrays: termArrays,
                amountStep: aStep,
                termStep: tStep,
                amountSteps,
                termSteps
            }

            return result
        },
        maxConditionValue: function () {
            var conditions = this.newLoan.loanConditions.conditions;
            if (conditions && conditions.length > 0) return {
                amountMax: Math.max.apply(Math, conditions.map(function(o) { return o.amountMax; })),
                termMax: Math.max.apply(Math, conditions.map(function(o) { return o.termMax; }))
            }
        },
        minConditionValue: function () {
            var conditions = this.newLoan.loanConditions.conditions;
            if (conditions && conditions.length > 0) return {
                amountMin: Math.min.apply(Math, conditions.map(function(o) { return o.amountMin; })),
                termMin: Math.min.apply(Math, conditions.map(function(o) { return o.termMin; }))
            }
        }
    },
    watch: {
        /*
        'creditType': function (val, oldVal) {
            switch (val) {
                case 'MicroCredit':
                    this.currentConditionIndex = 0
                    this.newLoan.loanConditions.conditions = this.immutableConditions.filter(condition => condition.product === 1)
                    this.newLoan.amount = this.newLoan.loanConditions.conditions[0].amountMax;
                    this.newLoan.term = this.newLoan.loanConditions.conditions[0].termMax;
                    this.setBaseRestrictions();
                    break;
                case 'ConsumerCredit':
                    this.currentConditionIndex = 0
                    this.newLoan.loanConditions.conditions = this.immutableConditions.filter(condition => condition.product === 2)
                    this.newLoan.amount = this.newLoan.loanConditions.conditions[0].amountMax;
                    this.newLoan.term = this.newLoan.loanConditions.conditions[0].termMax;
                    this.setBaseRestrictions();
                    break;
                default: 
                    break;
            }
            this.saveValueInCookie('creditType', val)
        },*/
        'newLoan.amount': function (val, oldVal) {
            var percent;
            var term = this.newLoan.term;
            // если текущее значение суммы подпадает под текущий дипазон loanConditions
            if (val >= this.realConditions.amountMin && val <= this.realConditions.amountMax) {
                if (term < this.realConditions.termMin || term > this.realConditions.termMax) {
                    oldVal > val ? this.currentConditionIndex-- : this.currentConditionIndex++;
                    if (term < this.realConditions.termMin || term > this.realConditions.termMax) {
                        this.newLoan.term = this.realConditions.termMax
                        this.saveValueInCookie('slider_term_value', this.realConditions.termMax)
                        this.saveValueInCookie('m2', this.realConditions.termMax)
                    } else {
                        this.newLoan.term = term
                        this.saveValueInCookie('slider_term_value', term)
                        this.saveValueInCookie('m2', term)
                    }
                }
            } else {
                // если текущее значение стало больше, чем предыдущее
                if (val > oldVal) {
                    // необходимо найти индекс loanCondition к которму может соответствовать сумма и срок займа
                    const candidateConditionIndex = this.calcConditionIndex(val)
                    if (candidateConditionIndex >= 0) {
                        this.currentConditionIndex = candidateConditionIndex
                        let lterm = (term >= this.realConditions.termMin && term <= this.realConditions.termMax)
                        ? this.newLoan.term
                        : this.realConditions.termMax;

                        this.newLoan.term = lterm
                        this.saveValueInCookie('slider_term_value', lterm)
                        this.saveValueInCookie('m2', lterm)
                    } else {
                        // если нет подходящих условий (такого в принципе не должно произойти), то устанавливаем предыдущее значение
                        this.newLoan.amount = oldVal
                        this.saveValueInCookie('slider_amount_value', oldVal)
                        this.saveValueInCookie('m1', oldVal)
                    }
                } else {
                    // необходимо найти индекс loanCondition к которму может соответствовать сумма и срок займа
                    const candidateConditionIndex = this.calcConditionIndex(val)
                    if (candidateConditionIndex >= 0) {
                        this.currentConditionIndex = candidateConditionIndex
                        this.newLoan.term = this.realConditions.termMax;
                        this.saveValueInCookie('slider_term_value', this.realConditions.termMax)
                        this.saveValueInCookie('m2', this.realConditions.termMax)
                    } else {
                        // если нет подходящих условий (такого в принципе не должно произойти), то устанавливаем предыдущее значение
                        this.newLoan.amount = oldVal
                        this.saveValueInCookie('slider_amount_value', oldVal)
                        this.saveValueInCookie('m1', oldVal)
                    }
                }
            }
        },
        'newLoan.term': function (val, oldVal) {
            var amount = this.newLoan.amount;
            var percent;
            var periodFree = this.newLoan.loanConditions.periodFree;
            // если указан беспроцентный период, то определяем не является ли положение слайдера граничащим, для отображения
            if (periodFree && val !== oldVal) {
                if (val > (this.maxConditionValue.termMax - periodFree)) {
                    $("#daysSlider").slider('value', this.conditionsDiff.termTotal.length);
                    this.newLoan.loanConditions.tid = 'freePeriod';
                    this.additionalPromoStyle('freePeriod');
                } else if (oldVal > (this.maxConditionValue.termMax - periodFree)) {
                    $("#daysSlider").slider('value', this.conditionsDiff.termTotal.length - periodFree - 1);
                    this.newLoan.loanConditions.tid = this.newLoan.promoConditions.tid;
                    this.additionalPromoStyle();
                    this.newLoan.term = this.maxConditionValue.termMax - periodFree;
                    this.saveValueInCookie('slider_term_value', this.maxConditionValue.termMax - periodFree)
                    this.saveValueInCookie('m2', this.maxConditionValue.termMax - periodFree)
                }
            }
            // если текущее значение кол-ва дней подпадает под текущий дипазон loanConditions
            if (val >= this.realConditions.termMin && val <= this.realConditions.termMax) {
                if (amount < this.realConditions.amountMin || amount > this.realConditions.amountMax) {
                    oldVal > val ? this.currentConditionIndex-- : this.currentConditionIndex++;
                    let lamount = (val === this.realConditions.termMin) ? this.realConditions.amountMin : this.realConditions.amountMax;
                    this.newLoan.amount = lamount
                    this.saveValueInCookie('slider_amount_value', lamount)
                    this.saveValueInCookie('m1', lamount)
                }
            } else {
                // если предыдущее значение было больше, слайдер идёт на уменьшение
                if (oldVal > val) {
                    this.currentConditionIndex--;
                } else {
                    // слайдер идёт на увеличение
                    this.currentConditionIndex++;
                }
                let lamount = (amount >= this.realConditions.amountMin && amount <= this.realConditions.amountMax)
                    ? this.newLoan.amount
                    : this.realConditions.amountMax;
                this.newLoan.amount = lamount
                this.saveValueInCookie('slider_amount_value', lamount)
                this.saveValueInCookie('m1', lamount)
            }
        }            
    }
  })
