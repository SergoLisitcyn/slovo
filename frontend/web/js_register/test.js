$(document).ready(function(){

  $("input#checkbox__text-1").change(function(){
    if ($(this).prop('checked')) {
      $('#patronymic').fadeOut().show();
    } else {
      $('#patronymic').fadeIn();
    }
  });
  $("input#checkbox__text-2").change(function(){
    if ($(this).prop('checked')) {
      $('#patronymic-desc').fadeOut().show();
    } else {
      $('#patronymic-desc').fadeIn();
    }
  });
  //terms and conditions need
  // jQuery.validator.addMethod("lettersonly", function(value, element) {
  //     return this.optional(element) || /^[a-z а-я]+$/i.test(value);
  // }, "Letters only please");
  jQuery.validator.addMethod("lettersonly", function( value, element ) {
    var regex = new RegExp("[.,\/#!$%\^&\*;:{}=\-_`~()0-9]+$");
    var key = value;

    return !regex.test(key);

  }, "Пожалуйста, используйте только буквенные символы");
  jQuery.validator.addMethod("inn", function( value, element ) {
    return iinCheck(value);

  }, "ИИН не правильный");
  jQuery.validator.addMethod("mins", function( value, element ) {
    var mins = value;
    var i= mins.length-mins.replace(/\d/gm,'').length;
    return (i >= 11);

  }, "Пожалуйста, введите полностью номер");

  jQuery.validator.addMethod("username", (value) => {
    const regexp = new RegExp('^[А-Яа-яё\-ӘәҒғЁёҚқҢңӨөҰұҮүҺһІі]{2,}$');
    return regexp.test(value);
  }, 'Вы ввели некорректное значение')

  const rules = {
    'Register[tin]': {
      required: true,
      minlength: 12,
      maxlength: 12,
      number: true,
      inn: true
    },
    'Register[phone]': {
      required: true,
      mins: true,
    },
    'Register[surname]': {
      required: true,
      lettersonly: true
    },
    'Register[name]': {
      required: true,
      lettersonly: true
    }
  };

  const mobileRules = {
    ...rules,
    'Register[surname]': {
      required: true,
      // username: true
    },
    'Register[name]': {
      required: true,
      // username: true
    },
    'agreement': "required"
  }

  const messages = {
    'Register[tin]': {
      number: "Пожалуйста, введите полностью ИИН",
      required: "Пожалуйста, введите полностью ИИН"
    },
    'Register[phone]': {
      required: "Пожалуйста, введите полностью номер"
    },
    'Register[surname]': {
      required: "Пожалуйста, введите фамилию"
    },
    'Register[name]': {
      required: "Пожалуйста, введите имя",
    },
    'agreement': {
      required: "Для продолжения регистрации необходимо дать согласие на обработку персональных данных"
    }
  };

  const errorPlacement = function (error, element) {
    error.addClass('help-inline');
    if ( element.prop( "type" ) === "checkbox" ) {
      error.css({
        'max-width': '320px',
        'line-height': '16px'
      });
      error.insertAfter(element.siblings('label'));
    } else {
      error.insertAfter( element );
    }
  }

  $('.form').validate({ rules, messages });

  $('#mobile_register').validate({
    rules: mobileRules,
    messages,
    errorElement: 'span',
    errorPlacement,
    focusCleanup: true,
    highlight: function ( element, errorClass, validClass ) {
      $(element).parents(".mobile-control-group").addClass("error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".mobile-control-group").addClass("has-success").removeClass("error");
    }
  })

  $.each($('input#mobile_tin'), function (index, val) {
		$(this).focus(function () {
			$(this).inputmask('999999999999');
    });
  });

  $.each($('input#phone1, input#mobile_phone1'), function (index, val) {
    $(this).focus(function () {
      $(this).inputmask("+7 (799) 999-99-99");
    });
  });
});