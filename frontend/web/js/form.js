var expressions = new Array('день', 'дня', 'дней');

$(document).ready(function() {

	var m1 = $.cookie('m1');
	if (!m1) m1 = summa2;
	if (m1 == 0) m1 = summa2;
	var m2 = $.cookie('m2');
	if (m2 == 0) m2 = period2;
	if (!m2) m2 = period2;

    var promo = $.cookie('promoCode') ? JSON.parse($.cookie('promoCode')) : undefined;

    if(use_promo) {
        SliderState.setPromoElements($('.get-money-form'),$('#money_button'), null, $('.promo-text'));
        SliderState.setPromo(promo.conditions, promo.promoCode);
        var array = SliderState.getBaseSliderPosition(m1, m2);
        m1 = array[0];
        m2 = array[1];
    }

    SliderState.setCurrentPosition({amount:m1, term:m2});
    SliderState.togglePromoStyle();

	$( "ins.amount").text( m1 );
	$( "ins.term").text( m2 );

   $('.get-money-form').each(function() {
   	var this_form = $(this);
   	var months = ['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'];

		$('.slider-amount').slider({
	      min: summa1,
	      max: summa2,
	      step: step,
	      value: m1,
	      slide: function( event, ui ) {
              if (ui.value > summa2*0.8) {
                  $('#need_more_money').show();
              } else {
                  $('#need_more_money').hide();
              }
	      	if (ui.value > summa2) {
	      		event.stopPropagation();
				return false;
			}

			SliderState.setCurrentPosition({
			  'amount': ui.value,
			  'term': $("#slider2").slider("value"),
			});
	      	SliderState.togglePromoStyle();
	      	$( "ins.amount", this_form ).text( ui.value );
			$( "#amount1" ).val(ui.value);
	      	$( "strong.return-amount", this_form ).text(
                SliderState.getSumm()
	      	);
	      	$( "span.return-amount_stripped", this_form ).html('&nbsp;'+
                SliderState.getSumm('stripped')+'&nbsp;'
	      	);
	      	$( "span.return-amount_repeated", this_form ).text( 
				summa_repeated(ui.value, $("#slider2").slider("value"))
	      	);
			$.cookie('m1', ui.value, { expires: 7, path: '/' ,domain: ecopt.domain});
			set_scale_bg();
			
	      },
	      range: "min"
	   }).trigger('slide');

		$('.slider-term').slider({
	      min: period1,
	      max: period2,
	      step: 1,
	      value: m2,
	      slide: function( event, ui ) {
            if (ui.value > period2) {
                event.stopPropagation();
                return false;
            }
			SliderState.setCurrentPosition({
			  'amount': $("#slider1").slider("value"),
			  'term': ui.value,
			});
			SliderState.togglePromoStyle();
	      	$( "ins.term", this_form ).text( ui.value );
			$( "#amount2" ).val(ui.value);
   			var this_date = new Date();
	      	this_date.setDate( this_date.getDate() + parseInt( ui.value ) );
	      	
	      	$( "strong.return-term", this_form ).text( 
	      		this_date.getDate() + " " + months[this_date.getMonth()] + " " + this_date.getFullYear()
	      	);
			$( "strong.return-amount", this_form ).text(
                SliderState.getSumm()
	      	);
			$( "span.return-amount_stripped", this_form ).html('&nbsp;'+
                SliderState.getSumm('stripped')+'&nbsp;'
	      	);
			$( "span.return-amount_repeated", this_form ).text( 
				summa_repeated($("#slider1").slider("value"), ui.value)
	      	);			
			$.cookie('m2', ui.value, { expires: 7, path: '/' ,domain: ecopt.domain});
			
			set_scale_bg();
			
	      },
	      range: "min"
	   }).trigger('slide');
	   
	   
		$( "#amount1" ).val($("#slider1").slider("value"));
		$( "#amount2" ).val($("#slider2").slider("value"));
		var this_date = new Date();
		this_date.setDate( this_date.getDate() + parseInt( $("#slider2").slider("value") ) );
		
		$( "strong.return-term", this_form ).text( 
			this_date.getDate() + " " + months[this_date.getMonth()] + " " + this_date.getFullYear()
		);
		$( "strong.return-amount", this_form ).text(
            SliderState.getSumm()
		);
		$( "span.return-amount_stripped", this_form ).html('&nbsp;' +
            SliderState.getSumm('stripped')+'&nbsp;'
		);
		$( "span.return-amount_repeated", this_form ).text( 
			summa_repeated($("#slider1").slider("value"), $("#slider2").slider("value"))
		);		
				
		set_scale_bg();		
   });

});


// function declension(int){
// 	int = int*1;
// 	count = int % 100;
// 	if (count >= 5 && count <= 20) {
// 		result = expressions[2];
// 	} else {
// 		count = count % 10;
// 		if (count == 1) {
// 			result = expressions[0];
// 		}
// 		else {
// 			if (count >= 2 && count <= 4) {
// 				result = expressions[1];
// 			} else {
// 				result = expressions[2];
// 			}
// 		}
// 	}
// 	return result;
// }

function summa_repeated(d1, d2) {
	return Math.round((percent_repeated*d2 + 1)*d1);
}

function set_scale_bg() {
		slider1_scales_bg1=($("#slider1").slider("option","max") - $("#amount1").val()) / $("#slider1").slider("option","step");
		slider1_scales_bg2=($("#amount1").val() - $("#slider1").slider("option","min")) / $("#slider1").slider("option","step");

		slider2_scales_bg1=($("#slider2").slider("option","max") - $("#amount2").val()) / $("#slider2").slider("option","step");
		slider2_scales_bg2=($("#amount2").val() - $("#slider2").slider("option","min")) / $("#slider2").slider("option","step");		
	   
	    $("#slider1 .bg1").remove(); $("#slider1 .ui-slider-range .bg2").remove();
		$("#slider2 .bg1").remove(); $("#slider2 .ui-slider-range .bg2").remove();

		slider1_one_step=($("#slider1").width() - 7) / ( ($("#slider1").slider("option","max") - $("#slider1").slider("option","min")) / $("#slider1").slider("option","step") ); 
		slider2_one_step=($("#slider2").width() - 7) / ( ($("#slider2").slider("option","max") - $("#slider2").slider("option","min")) / $("#slider2").slider("option","step") ); 

		for (i=0; i <= slider1_scales_bg2; i++) { $("#slider1 .ui-slider-range").append("<div class='bg2' style='left: "+parseInt(slider1_one_step * i)+"px;'></div>"); }		
		for (i=0; i <= slider1_scales_bg1; i++) { $("#slider1").append("<div class='bg1' style='left: "+parseInt(slider1_one_step * (slider1_scales_bg2 + i))+"px;'></div>"); }
		
		for (i=0; i <= slider2_scales_bg2; i++) { $("#slider2 .ui-slider-range").append("<div class='bg2' style='left: "+parseInt(slider2_one_step * i)+"px;'></div>"); }		
		for (i=0; i <= slider2_scales_bg1; i++) { $("#slider2").append("<div class='bg1' style='left: "+parseInt(slider2_one_step * (slider2_scales_bg2 + i))+"px;'></div>"); }	
}	
