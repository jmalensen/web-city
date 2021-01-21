(function($) {

	'use strict';

	var init = function() {
        
        $(window).resize(function(){
		  makeSquareBox();
        }).resize();
        
        $('.ci-calendar-shortcode').click(function(){
            makeSquareBox();
        });
        
	};

	var makeSquareBox = function() {
        var newHeight = $('.calendar .ci-calendar-shortcode table td').width();
        $('.calendar .ci-calendar-shortcode table td').height(newHeight);
        $('.calendar .ci-calendar-shortcode table td').css('line-height' ,newHeight+'px');
	};

	$(document).ready(function() {
		init();
	});

})(jQuery);