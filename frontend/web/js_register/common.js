

$(function() {


    // Phone Mask

	$.each($('input#register-mobile'), function (index, val) {
		$(this).focus(function () {
			$(this).inputmask('+7 (999) 999-99-99');
		});
	});

	$.each($('input#tin'), function (index, val) {
		$(this).focus(function () {
			$(this).inputmask('999999999999');
		});
    });


    // Validate Form

    $('.form').validate({
        rules: {
            tin: {
                required: true,
                minlength: 12,
                maxlength: 12,
                number: true
            },
            phone: {
                required: true
            },
            },
        messages: {
            tin: {
                number: "Пожалуйста, введите полностью ИИН",
                required: "Пожалуйста, введите полностью ИИН"
            },
            phone: {
                required: "Пожалуйста, введите полностью номер"
            }
        }
        });

    


    // Top

    $(window).scroll(function() {
		if ($(this).scrollTop() > $(this).height() && $(this).width() < 700) {
			$('.top').addClass('active');
		} else {
			$('.top').removeClass('active');
		}
	});

	$('.top').click(function() {
		$('html, body').stop().animate({scrollTop: 0}, 'slow', 'swing');
    });


    // Slider

    $( "#slider1" ).slider({
        min: 1,
        max: 75,
        step: 1,
        range: "min",
        value: 35,
        slide: function( event, ui ) {
            $( "#form__item-span" ).val(ui.value );
          }
    });
    $( "#slider2" ).slider({
        min: 1,
        max: 6,
        step: 1,
        range: "min",
        value: 6
    });

    $( "#form__item-span" ).val($( "#slider1" ).slider( "value" ) );


    // Read more
    $('.readmore__body').hide();

		$('.main-text__readmore').click(function(){
			$('.readmore__body').slideToggle();
            $(".main-text__readmore").text(function(i, text){
                return text === "Скрыть" ? "Подробнее" : "Скрыть";
            });
        });
    
    

});


