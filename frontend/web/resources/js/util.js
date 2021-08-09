Util = {
    formatPhone: function(phone, noSeven) {
        if (!phone) {
            return '';
        }

        var matched = phone.replace(/\D/g, '');
        var good = matched.replace(/^[78]?7/, '7');
        if (good.length == 0)
            return '';

        var beginning = noSeven ? '(' : '+7 (';

        if (good.length < 3)
            return beginning + good;

        if (good.length < 6)
            return beginning + good.slice(0, 3) + ') ' + good.slice(3);

        if (good.length < 8)
            return beginning + good.slice(0, 3) + ') ' + good.slice(3, 6) + '-' + good.slice(6);

        if (good.length < 10)
            return beginning + good.slice(0, 3) + ') ' + good.slice(3, 6) + '-' + good.slice(6, 8) + '-' + good.slice(8);

        return beginning + good.slice(0, 3) + ') ' + good.slice(3, 6) + '-' + good.slice(6, 8) + '-' + good.slice(8, 10);
    },
    formatCard: function(card) {
        var digits = card.replace(/\D/g, '');
        if (digits.match(/^\d{0,4}$/))
            return digits;
        if (digits.match(/^\d{5,8}$/))
            return digits.replace(/^(\d{4})(\d+)$/, '$1 $2');
        if (digits.match(/^\d{9,12}$/))
            return digits.replace(/^(\d{4})(\d{4})(\d+)$/, '$1 $2 $3');
        else
            return digits.replace(/^(\d{4})(\d{4})(\d{4})(\d{1,4}).*$/, '$1 $2 $3 $4');
    },
    formatCardDate: function(carddate) {
        return carddate.replace(/(\d\d)\/(\d\d)?(\d\d)/, '$1/$3');
    },

    formatTotalIncome: function(totalIncome, defaultValue) {
        if (totalIncome === undefined) {
            return this.totalIncomeValueImmutable;
        }

        totalIncome = totalIncome.toString().replace(/\D/g, '');

        if (totalIncome.length < 6) {
            totalIncome = defaultValue;
        }

        return totalIncome;
    },

    getRealAmount: function (amount, term, loanConditions) {
        if (loanConditions.termStep === 1) {
            return Math.round((loanConditions.rate * term ) * amount) + amount;
        }
    },

    getReturnAmount: function(amount, term, conditions, loanConditions, creditType) {
        var periodFree = conditions.periodFree;

        if (conditions.periodFreeBegin && conditions.periodFreeEnd) {
            var pfBegin = new Date(conditions.periodFreeBegin);
            var pfEnd = new Date(conditions.periodFreeEnd);
            var date_server = new Date(conditions.currentDate);
            var dateReturn = new Date();
            dateReturn.setDate(date_server.getDate() + parseInt(term));

            if (dateReturn.getTime() >= pfBegin.getTime()) {
                var realFree = Math.min(dateReturn.getTime(), pfEnd.getTime()) - pfBegin.getTime();
                if (realFree > 0) {
                    periodFree = Math.ceil(realFree / 1000 / 3600 / 24);
                }
            }

        }

        if (!creditType) {
            if (loanConditions.termStep === 1) {
                if (conditions.fix || conditions.tid === 5){
                    return amount + conditions.fix;
                }
                var finalTerm = periodFree > term ? 0 : term - periodFree;
    
                return Math.round((loanConditions.rate * finalTerm + 1) * amount);
            } else {
                var payments = Util.calcAnnuityPayments(amount, term, loanConditions.rate, loanConditions.termStep);
                return {
                    totalReturnAmount: payments.reduce(
                        function(sum, el) {
                            return sum + el.sum;
                        }, 0),
                    annuity: payments[0].sum,
                    payments: payments
                };
            }
        } else {
            if (creditType === 'MicroCredit') {
                if (conditions.fix || conditions.tid === 5){
                    return amount + conditions.fix;
                }
                var finalTerm = periodFree > term ? 0 : term - periodFree;
    
                return Math.round((loanConditions.rate * finalTerm + 1) * amount);
            }
            if (creditType === 'ConsumerCredit') {
                var payments = Util.calcAnnuityPayments(amount, term, loanConditions.rate, loanConditions.termStep);

                return {
                    totalReturnAmount: payments.reduce(
                        function(sum, el) {
                            return sum + el.sum;
                        }, 0),
                    annuity: payments[0].sum,
                    payments: payments
                };
            }
        }
    },
    /**
     * Вычисляет, допустимы ли подобные условия с фиксированной платой за займ
     *
     * @param {int} amount
     * @param {int} term
     * @param {object} conditions
     * @returns {boolean}
     */
    isAllowedRate: function(amount, term, conditions) {
        if (!conditions.fix) {
            return true;
        }

        return amount * term * 8.57 > conditions.fix * 365;
    },
    pluralizeRu: function(number, formOne, formTwo, formFive) {
        number = (number * 1) % 100;
        if (number >= 5 && number <= 20) {
            return formFive;
        }

        number = number % 10;
        return (number == 1) ? formOne : (number == 0 || number > 4 ? formFive : formTwo);
    },
    /** Функция для создания массива из диапазона и шага.
    @param {Array} range - диапазон [start, end]
    @param {Number} step - шаг диапазона
    */
    createArrayFromRange: function (range, step) {
        const result = []
        const [start, end] = range

        for (let i = start; i <= end; i += Number(step)) {
            result.push(i);
        }
        return result;
    },
    /**
     * Функция клонирует объект без определенного ключа
     * @param {object} obj - исходный объект
     * @param {array} keys - массив игнорируемых ключей
     * */
    objectWithoutProperties: function (obj, keys) {
        var target = {};
        for (var i in obj) {
            if (keys.indexOf(i) >= 0) continue;
            if (!Object.prototype.hasOwnProperty.call(obj, i)) continue;
            target[i] = obj[i];
        }
        return target;
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
        }
    },
    calcAnnuityPayments: function(amount, term, rate, period) {
        var periodCount = Math.round(term / period),
            ratePeriod = rate * period,
            m = Math.pow(1 + ratePeriod, periodCount),
            annual = amount * ratePeriod * m / (m - 1);

        var debtBody = amount;
        var result = [];
        while (debtBody > 1e-2) {
            var realBodyDecrease = annual - debtBody * ratePeriod;
            var roundedBody = Math.round(debtBody);
            var roundedBodyDecrease = roundedBody - Math.round(debtBody - realBodyDecrease);
            var roundedPayment = Math.round(annual);

            debtBody -= realBodyDecrease;
            result.push({
                returnOd: roundedBodyDecrease,
                returnPct: roundedPayment - roundedBodyDecrease,
                sum: roundedPayment,
                balance: roundedBody
            });
        }
        return result;
    },
    /** Функция для возвращает массив пересечений массивов
     *  @param {array} arrays - массив массивов для поиска пересечений
     */
    intersection: function (arrays) {
        return arrays[0].filter(function (x) {
            var result = true;
            for (var i = 1; i < arrays.length; i++) {
                result = result && arrays[i].includes(x)
            }
            return result;
        });
    }
};

/**
 * @param date Y-m-d H:i:s OR Y-m-dTH:i:s OR with timezone
 * @constructor
 */
SimpleDate = function(date) {
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
Number.prototype.leftPad = function (len, ch) {
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
