(function($) {

	'use strict';

	var init = function() {
		initForms();
	}

	var initForms = function() {
		var inputs = $('input[type=text], input[type=password], input[type=email], input[type=url], textarea, select');
		var labels = inputs.parents('.gfield').children('label');
		labels.addClass('material');
		inputs.on('focus', function(){
			$(this).parents('.gfield').children('label').addClass('focus');
		});
		inputs.on('blur', function(){
			console.log($(this).is("input"));
			if($(this).attr('value') == '') {
				$(this).parents('.gfield').children('label').removeClass('focus');
			}else {
				if($(this).is('textarea')) {
					$(this).addClass('content');
				}
			}
		});
	}

	$(document).ready(function() {
		init();
	});

})(jQuery);