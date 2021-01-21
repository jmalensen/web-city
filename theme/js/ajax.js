(function($) {

	'use strict';
    
    var scrolled = false;
    var offset_event = 4;
    var offset_directory = 4;
    var offset_news = 6;
    
	var init = function() {
        
        //Scroll infini des événements
        if($('body').hasClass('page-template-archive-event')){
            
            $(window).scroll(function(){
                
                var scrollPosition = $(window).height() + $(window).scrollTop();
                var scrollListBottom = $("#event-list").offset().top + $("#event-list").outerHeight();
                
                if( !scrolled && scrollPosition >= scrollListBottom){
                                        
                    event_ajax();
                    
                    scrolled = true;
                    
                }
                
            });
            
        }
        
        //Scroll infini des entrées d'annuaire
        if($('body').hasClass('page-template-archive-directory')){
            
            $(window).scroll(function(){
                var scrollPosition = $(window).height() + $(window).scrollTop();
                var scrollListBottom = $("#directory-list").offset().top + $("#directory-list").outerHeight();
                
                if( !scrolled && scrollPosition >= scrollListBottom){
                                        
                    directory_ajax();
                    
                    scrolled = true;
                    
                }
                
            });
        }
        
        
        //Scroll infini des entrées d'actualités
        if($('body').hasClass('page-template-archive-news')){
            
            $(window).scroll(function(){
                var scrollPosition = $(window).height() + $(window).scrollTop();
                var scrollListBottom = $(".contain-news").offset().top + $(".contain-news").outerHeight();
                
                if( !scrolled && scrollPosition >= scrollListBottom){
                    news_ajax();
                    
                    scrolled = true;
                }
            });
        }
        
        initNewsPosition();
	};
    
    var event_ajax = function(){
        
        var cat = $('#search-param').data('cat');
        var bdate = $('#search-param').data('bdate');
        var edate = $('#search-param').data('edate');
        var keyword = $('#search-param').data('keyword');
        
        jQuery.post(
            ajaxurl,
            {
                'action': 'infinite_scroll_event',
                'offset': offset_event,
                'cat': cat,
                'bdate': bdate,
                'edate': edate,
                'keyword': keyword
            },
            function(response){
                
                if(response != 'false'){
                    
                    offset_event += 4;
                    $('#event-list').append(response);

                    setTimeout(function() {
                        scrolled = false;
                    }, 100);
                    
                }
                
            }
        );
        
    };
    
    var directory_ajax = function(){
        
        var cat = $('#search-param').data('cat');
        var keyword = $('#search-param').data('keyword');
        
        jQuery.post(
            ajaxurl,
            {
                'action': 'infinite_scroll_directory',
                'offset': offset_directory,
                'cat': cat,
                'keyword': keyword,
            },
            function(response){
                
                if(response != 'false'){
                    
                    offset_directory += 4;
                    $('#directory-list').append(response);

                    setTimeout(function() {
                        scrolled = false;
                    }, 100);
                    
                }
                
            }
        );
        
    };
    
    var initNewsPosition = function(){
        if( $('body.page-template-archive-news').length === 1){
            var $container = $('.contain-news');
            $container.imagesLoaded(function(){
                $container.masonry({
                    itemSelector: '.news__item'
                });
            });
        }
    };
    
    var news_ajax = function(){
        
        var cat = $('#search-param').data('cat');
        var keyword = $('#search-param').data('keyword');
        
        jQuery.post(
            ajaxurl,
            {
                'action': 'infinite_scroll_news',
                'offset': offset_news,
                'cat': cat,
                'keyword': keyword
            },
            function(response){
                
                if(response != 'false'){
                    
                    offset_news += 6;
                    
                    $('.contain-news').append(response);
                    
                    var $container = $('.contain-news');
                    $container.masonry('destroy');
                    $container.imagesLoaded(function(){
                        $container.masonry({
                            itemSelector: '.news__item'
                        });
                    });

                    setTimeout(function() {
                        scrolled = false;
                    }, 100);
                }
            }
        );
        
    };

	$(document).ready(function() {
		init();
	});

})(jQuery);