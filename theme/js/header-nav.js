(function($) {

	'use strict';

	var init = function() {
		initHeaderNav();
        initMenu();
        initNavStructure();
        
        $( window ).resize(function(){
            initNavResize();
            initFixedMenu();
            
            initSearchForm();
            
            initNavSidebar();
        });
        
        $( window ).resize();
	};

    var initMenu = function(){
        //Burger menu
        $(".burger-menu").on("click", function (e) {
            if($(this).hasClass('active')){
                $('.burger-menu').removeClass("active");
                $('.contain-overflow').attr('style','');
                $('.nav-main-menu').slideUp(100);
            }
            else{
                $(this).addClass("active");
                $('.contain-overflow').css({'overflow':'hidden', 'position':'fixed', 'width':'100%'});
                $('.nav-main-menu').slideDown(200);
            }
        });
        
        //Block all empty link
        $("body").find('a[href="#"]').on('click', function(e){
            e.preventDefault();
        });
    };

	var initHeaderNav = function() {
		$('header button').on('click', function() {
			$(this).toggleClass('open');
			$(this).next('nav').toggleClass('open');
			$(this).parents('header').toggleClass('open');
		});
	};
    
    var initNavResize = function(){
        //Accordeon menu
        $('#main-menu li.menu-item-has-children > span').off('click');
        $('#main-menu li.menu-item-has-children > span').on('click', function(e){
            e.preventDefault();

            if(!window.matchMedia("(min-width: 992px)").matches){
                $('#main-menu li.menu-item-has-children .sub-menu').not($(this).next()).slideUp(200);
                $('#main-menu li.menu-item-has-children > span').not($(this)).removeClass('active');
                $(this).toggleClass('active').next().slideToggle(400);
            }
        });
        $('#main-menu li.menu-item-has-children li.menu-item-has-children > span').off('click');

        if(window.matchMedia("(min-width: 992px)").matches){
            $('.nav-main-menu').attr('style', '');
            $('.burger-menu').removeClass('active');
            $('#main-menu .sub-menu').attr('style', '');
            $('.contain-overflow').attr('style','');
            $('#main-menu li.menu-item-has-children > span').removeClass('active');
        }
        else{
            
        }
    };
    
    var initFixedMenu = function(){
        if (window.matchMedia("(min-width: 992px)").matches) {
            var nav = $('header.main');
            $(window).scroll(function () {
                //If we slide down at least 136px
                if ($(this).scrollTop() > 136) {
                    nav.addClass('fixed');
                    $('.contain-overflow main').addClass('fixedmode');
                } else {
                    nav.removeClass('fixed');
                    $('.contain-overflow main').removeClass('fixedmode');
                }
            });
        }
        else{
            $('header.main').attr('style', '');
            $('.contain-overflow main').attr('style', '');
            $(window).unbind("scroll");
        }
    };
    
    var initSearchForm = function() {
        if (window.matchMedia("(min-width: 992px)").matches) {
            $('.iconSearch div').unbind('click').bind('click', function() {
                $('.search-form').slideToggle(200);
                $('.containS input').focus();
                $('header.main .logo .mask').toggleClass('searchactive');
            });

            $('.search-form .closeBtn').unbind('click').bind('click', function() {
                $('.search-form').slideToggle(200);
                $('header.main .logo .mask').toggleClass('searchactive');
            });
        }
        else{
            $('.iconSearch div').unbind('click');
            $('.search-form .closeBtn').unbind('click');
            $('.search-form').attr('style', '');
        }
        
        $('.search-form .submitBtn').bind('click', function(){
            if($(this).prev().val() != ''){
                $(this).parent().parent().submit();
            }
        });
	};
    
    var initNavSidebar = function(){
        if (window.matchMedia("(max-width: 992px)").matches) {
            $('.aside-page .aside-page__title').unbind('click').bind('click', function() {
                $(this).toggleClass('active');
                $('.aside-page__list-pages').slideToggle(200);
            });
            
            $('.aside-page .onepage__link').removeClass('active');
        }
        else{
            $('.aside-page .aside-page__title').unbind('click').removeClass('active');
            $('.aside-page__list-pages').attr('style', '');
            
            //Submenu aside
            $('.aside-page .onepage__link .arrow').unbind('click').bind('click', function(e) {
                e.preventDefault();
                $(this).parent().toggleClass('active');
                $(this).parent().find('.submenuaside').slideToggle(200);
            });
        }
    };
    
    var initNavStructure = function(){
        if($('body.page-template-default').length === 1 || $('body.event-template-default').length === 1 || $('body.post-template-default').length === 1){
            $('.content__contact').bind('click', function() {
                $(this).toggleClass('active');
                $(this).next().slideToggle(200);
                $(this).parent().next().slideToggle(200);
            });
        }
    };
    
	$(document).ready(function() {
		init();
	});

})(jQuery);
