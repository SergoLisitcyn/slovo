import { VueMediaQueryMixin } from './media.mixin.js'
var Util = {
    getReturnAmount: function (amount, term, rate) {
      const periodFree = 0;
      const finalTerm = periodFree > term ? 0 : term - periodFree;
      const total = Math.round((rate * finalTerm + 1) * amount);
      return `${total} ₸`;
    },
    pluralizeRu: function (number, formOne, formTwo, formFive) {
      number = (number * 1) % 100;
      if (number >= 5 && number <= 20) {
        return formFive;
      }
  
      number = number % 10;
      return number == 1
        ? formOne
        : number == 0 || number > 4
        ? formFive
        : formTwo;
    },
    /** Функция для создания массива из диапазона и шага.
    @param {Array} range - диапазон [start, end]
    @param {Number} step - шаг диапазона
    */
    createArrayFromRange: function (range, step) {
      const result = [];
      const [start, end] = range;
  
      for (let i = start; i <= end; i += Number(step)) {
        result.push(i);
      }
      return result;
    },
    /** Функция для возвращает массив диапазонов значений для слайдера
     *  @param {array} conditions - массив словий для создания диапазонов
     *  @return {object} объект состоящий из массивов с диапазонами значений по каждому усовию
     */
    takeSliderRangesFromConditions: function (conditions) {
      var amountRanges = [];
      var termRanges = [];
      for (var i = 0; i < conditions.length; i++) {
        amountRanges.push([conditions[i].amountMin, conditions[i].amountMax]);
        termRanges.push([conditions[i].termMin, conditions[i].termMax]);
      }
  
      return {
        amountRanges: amountRanges,
        termRanges: termRanges
      };
    },
    /** Функция для возвращает массив пересечений массивов
     *  @param {array} arrays - массив массивов для поиска пересечений
     */
    intersection: function (arrays) {
      return arrays[0].filter(function (x) {
        var result = true;
        for (var i = 1; i < arrays.length; i++) {
          result = result && arrays[i].includes(x);
        }
        return result;
      });
    }
  };

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
            var down = args.element.getElementsByClassName("mobile_pickvalue__minus")[0];
            var up = args.element.getElementsByClassName("mobile_pickvalue__plus")[0];
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
    };

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

/**
 * @param date Y-m-d H:i:s OR Y-m-dTH:i:s OR with timezone
 * @constructor
 */
    const SimpleDateInstance = function(date) {
    if (date instanceof Date) {
        return {
            year: date.getFullYear(),
            month: date.getMonth() + 1,
            day: date.getDate(),
            hour: date.getHours(),
            minute: date.getMinutes(),
            second: date.getSeconds()
        }
    }
    if (!date) {
        return {year: 0, month: 0, day: 0, hour: 0, minute: 0, second: 0};
    }
    if (typeof date.substr != 'function') {
        return {year: 0, month: 0, day: 0, hour: 0, minute: 0, second: 0};
    }
    this.year = parseInt(date.substr(0, 4));
    this.month = parseInt(date.substr(5, 2));
    this.day = parseInt(date.substr(8, 2));
    this.hour = parseInt(date.substr(11, 2));
    this.minute = parseInt(date.substr(14, 2));
    this.second = parseInt(date.substr(17, 2));
};

    /**
     *
     * @param {int} [len=2]
     * @param {string} [ch='0']
     * @returns {string}
     */
     Number.prototype.customleftPad = function (len, ch) {
        // convert `str` to `string`
        var str = this + '';
        len = len || 2;
        ch = ch || '0';
    
        // doesn't need to pad
        len = len - str.length;
        if (len <= 0) return str;
    
        // convert `ch` to `string`
        if (!ch && ch !== 0) ch = ' ';
        ch = ch + '';
        var pad = '';
        while (true) {
            if (len & 1) pad += ch;
            len >>= 1;
            if (len) ch += ch;
            else break;
        }
        return pad + str;
    };

Vue.filter('pluralizeRu', Util.pluralizeRu);

Vue.filter('sliderSteps', function (val, conditionsDiff, part) {
    return conditionsDiff[part + 'Total'].indexOf(val) + 1;
})

Vue.filter('formatDateLocale', function (date) {
    var months = ['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'];
    date = new SimpleDateInstance(date);
    return date.day.customleftPad() + ' ' + months[date.month - 1] + ' ' + date.year;
});

Vue.component("LoanSlider", {
    template: `<div
        ref="slider"
        v-bind:value="value">
        <slot></slot>
    </div>`,
    props: {
      value: [Number, String],
      min: {
        type: Number,
        default: 1
      },
      max: {
        type: Number,
        default: 1
      },
      step: {
        type: Number,
        default: 1
      },
      last_part: [String, Number],
      sliderposition: {
        type: [Number, String],
        default: 1
      },
      slider_type: String
    },
    data: function () {
      return {
        slider: null
      };
    },
    methods: {
        updateSlider: function (value) {
          this.slider.slider("value", value);
        },
        sliderOptions: function (context) {
          let sliderOpt = {
            min: Number(this.min),
            max: Number(this.max),
            step: Number(this.step),
            value: Number(this.max),
            slide: function (event, ui) {
              context.$emit("sliderposition", ui.value);
              context.updateSlider(ui.value);
            }.bind(this),
            range: "min"
          };
          if (this.min === this.max) {
            sliderOpt = Object.assign({}, sliderOpt, {
              min: 0,
              max: this.max,
              start: (event, ui) => {
                // запрещаем прокрутку слайдера
                return false;
              }
            });
          }
          return sliderOpt;
        },
        initSlider: function () {
          const context = this;
          this.slider = $(this.$refs.slider).slider(this.sliderOptions(context));
          this.slider.slider("value", Number(this.sliderposition));
  
          var lastPart = this.$refs.slider.getElementsByClassName("lastPart")[0];
          var sliderEquator = this.$refs.slider.getElementsByClassName(
            "sliderEquator"
          )[0];
          if (lastPart) {
            lastPart.style.width = this.last_part + "%";
            lastPart.style["margin-left"] = 100 - this.last_part + "%";
          }
  
          if (sliderEquator) {
            if (this.last_part > 90 || this.last_part < 10) {
              sliderEquator.style["visibility"] = "hidden";
            } else {
              sliderEquator.style["visibility"] = "visible";
              sliderEquator.style["left"] = 100 - this.last_part + "%";
            }
          }
        }
    },
    mounted: function () {
      this.initSlider();
    },
    watch: {
        min: function (newVal) {
          this.slider.slider("option", "min", newVal);
        },
        max: function (newVal) {
          this.slider.slider("option", "max", newVal);
        },
        step: function (newVal) {
          this.slider.slider("option", "step", newVal);
        },
        last_part: function (newVal) {
          const lastPart = this.$refs.slider.getElementsByClassName(
            "lastPart"
          )[0];
          const sliderEquator = this.$refs.slider.getElementsByClassName(
            "sliderEquator"
          )[0];
  
          if (lastPart) {
            lastPart.style.width = this.params.last_part + "%";
            lastPart.style["margin-left"] = 100 - this.params.last_part + "%";
          }
  
          if (sliderEquator) {
            if (newVal > 90 || newVal < 10) {
              sliderEquator.style["visibility"] = "hidden";
            } else {
              sliderEquator.style["visibility"] = "visible";
              sliderEquator.style["left"] = 100 - newVal + "%";
            }
          }
        }
    },
    updated: function () {
      this.slider.slider("value", Number(this.sliderposition));
    },
    beforeDestroy: function () {
      this.slider.slider("destroy");
    }
  });
  
  Vue.component("PickSlider", {
    template: `<div
        ref="pickvalue"
        v-bind:value="value">
        <slot></slot>
        </div>`,
    props: {
      value: [Number, String],
      min: {
        type: Number,
        default: 1
      },
      max: {
        type: Number,
        default: 1
      },
      step: {
        type: Number,
        default: 1
      },
      sliderposition: {
        type: [Number, String],
        default: 1
      }
    },
    data: function () {
      return {
        pickvalue: null
      };
    },
    methods: {
        updateSlider: function (value) {
          this.pickvalue.setValue(value);
        },
        initSlider: function () {
          const context = this;
          this.pickvalue = new Pickvalue({
            element: this.$refs.pickvalue,
            min: Number(this.min),
            max: Number(this.max),
            step: Number(this.step),
            value: Number(this.max),
            watcher: function () {
              context.$emit("sliderposition", this.pickvalue.value);
              context.updateSlider(this.pickvalue.value);
            }.bind(this)
          });
          this.pickvalue.setValue(Number(this.sliderposition));
        }
    },
    mounted: function () {
      this.initSlider();
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
      this.pickvalue.setValue(this.sliderposition);
    },
    beforeDestroy: function () {
      this.pickvalue.destroy();
    }
  });

/** Initialize instance **/
Vue.use(VueMediaQueryMixin, {framework:'vuetify'});
window.vm = new Vue({
    el: '#component-slider',
    data: {
        privacyChecked: true,
        isDataLoaded: false,
        seen: true,
        isHaveCreditTypes: false,
        immutableConditions: [],
        currentConditionIndex: 0,
        loanData: {},
        newLoan: {
            amount: 0,
            amountMax: 0,
            term: 0,
            termMax: 0,
            rate: 0.01,
            loanConditions: {},
            initialConditions: {},
            promoConditions: {},
            billStop: {},
            creditStop: {}
        },
        surname: '',
        name: '',
        patronymic: '',
        tin: '',
        phone: '',
        email: '',
        timerid: null
    },
    created: function () {
        const condition = [{
            id: 1,
            ruleViolationPercent: 2.81,
            amountMin: 5000,
            amountMax: 65000,
            termMin: 5,
            termMax: 30,
            rate: 0.019,
            amountStep: 1000,
            termStep: 1,
            product: 1
        }];
        const loanConditions = {
            conditions: __conditions ? __conditions : condition,
            periodFree: 0,
            periodFreeBegin: 0,
            periodFreeEnd: 0,
            fix: 0,
            currentDate: new Date(),
            promoString: "",
            promoInfo: ""
        }
        this.newLoan.loanConditions = loanConditions
        this.newLoan.amount = loanConditions.conditions[0].amountMax
        this.newLoan.term = loanConditions.conditions[0].termMax
        this.newLoan.rate = loanConditions.conditions[0].rate
        this.isDataLoaded = true
    },
    mounted: function() {
        // clearTimeout(this.timerid)
        // this.timerid = setTimeout(() => this.isDataLoaded = true, 10)
    },
    beforeDestroy: function() {
        // clearTimeout(this.timerid)
    },
    computed: {
        fakeAmountSliderPosition: function () {
            return 20
        },
        fakeComputedProps: function () {
            return {
                amount: 5,
                term: 1
            }
        },
        promoTextColor: function () {
            return '#43B05C';
        },
        isTermSliderStartVisible: function () {
            if (this.minConditionValue.termMin === this.maxConditionValue.termMax) return false
            return true
        },
        styleObject: function() {
            if (this.isDataLoaded) return {
                display:  'block'
            }
            return {
                display: 'none'
            }
        },
        styleLoader: function() {
          if (this.isDataLoaded) return {
              display: 'none'
          }
          return {
              display:  'block'
          }
      },
        termSliderPosition: function () {
            return this.sliderValueToStep(this.newLoan.term, 'term')
        },
        amountSliderPosition: function () {
            return this.sliderValueToStep(this.newLoan.amount, 'amount')
        },
        newLoanReturn: function () {
            var d = new Date();
            d.setDate(d.getDate() + parseInt(this.newLoan.term));
            const amount = {
                amount: Util.getReturnAmount(this.newLoan.amount, this.newLoan.term, this.newLoan.rate),
                date: d
            }
            return amount
        },
        sliderMax: function () {
            if (this.newLoan.loanConditions) {
                return {
                    amount: this.conditionsDiff.amountTotal.length,
                    term: this.conditionsDiff.termTotal.length
                }
            }
            return {
                amount: 1,
                term: 1
            }
        },
        conditionsDiff: function () {
            if (!this.newLoan.loanConditions.conditions) return false;
            const conditions = this.newLoan.loanConditions.conditions;
            const ranges = Util.takeSliderRangesFromConditions(this.newLoan.loanConditions.conditions);

            let amountArrays = [];
            let termArrays = [];
            let aStep = 0;
            let tStep = 0;

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
        minConditionValue: function () {
            var conditions = this.newLoan.loanConditions.conditions;
            if (conditions && conditions.length > 0) return {
                amountMin: Math.min.apply(Math, conditions.map(function(o) { return o.amountMin; })),
                termMin: Math.min.apply(Math, conditions.map(function(o) { return o.termMin; }))
            }
        },
        maxConditionValue: function () {
            var conditions = this.newLoan.loanConditions.conditions;
            if (conditions && conditions.length > 0) return {
                amountMax: Math.max.apply(Math, conditions.map(function(o) { return o.amountMax; })),
                termMax: Math.max.apply(Math, conditions.map(function(o) { return o.termMax; }))
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
        }
    },
    methods: {
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
        sliderChange: function (value, part) {
            const prevTerm = this.newLoan.term
            const prevAmount = this.newLoan.amount
            if (part === 'term') {
                const term  = this.sliderStepToValue(value, prevTerm, part)
                this.newLoan.term = term
            }
            if (part === 'amount') {
                const amount = this.sliderStepToValue(value, prevAmount, part)
                this.newLoan.amount = amount
            }
        }
    }
  });