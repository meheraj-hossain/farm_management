/*!
<----------------------------------------
  Theme Name: Gowala
  Theme URI: http://codexcoder.com/
  Author: codexcoder.com
  Author URI: http://codexcoder.com/
  Description: Gowala is a Creative Dairy Farm & Eco Product HTML5 Template.
  Version: 1.0.0
  Tags: agriculture, cattle farm, eco, eco farm, eco products, eco shop, farming, food, healthy food, natural, organic, retail, shop, store, woocommerce
---------------------------------------->
*/

(function($){
    "use strict";

    // lightcase 
    $('a[data-rel^=lightcase]').lightcase();

    // use of fontawesome
    window.FontAwesomeConfig = {
        searchPseudoElements: true
    }

    // search & cart option
    $(document).on('click','.search-cart .search i, .search-close',function(){
        $(".search-area").toggleClass("open");
    });
    
    // scroll up start here
    $(function() {
        //Check to see if the window is top if not then display button
        $(window).scroll(function(){
            if ($(this).scrollTop() > 300) {
                $('.scrollToTop').css({'bottom':'2%', 'opacity':'1','transition':'all .5s ease'});
            } else {
                $('.scrollToTop').css({'bottom':'-30%', 'opacity':'0','transition':'all .5s ease'})
            }
        });
        //Click event to scroll to top
        $('.scrollToTop').on('click',function(){
            $('html, body').animate({scrollTop : 0},500);
            return false;
        });
    });

    //menu top fixed start
    var fixed_top = $(".header-bottom");
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 130) {
            fixed_top.addClass("menu-fixed animated fadeInDown");
            fixed_top.removeClass("slideInUp");
            $('body').addClass("body-padding");
        } else {
            fixed_top.removeClass("menu-fixed fadeInDown");
            fixed_top.addClass("slideInUp"); 
            $('body').removeClass("body-padding");
        }
    });

    // menu icon releted
    $(".main-menu>li>.submenu").parent("li").children("a").addClass("dd-icon-down");
    $(".m-menu>li>.m-submenu").parent("li").children("a").addClass("dd-icon-down");
    $(".main-menu>li>.submenu .submenu").parent("li").children("a").addClass("dd-icon-right");
    $(".m-menu>li>.m-submenu .m-submenu").parent("li").children("a").addClass("dd-icon-down");
    $(".shop-menu>li .shop-submenu").parent("li").children("a").addClass("dd-icon-down");

    // mobile menu responsive
    $(document).on('click','.header-bar',function(){
        $(".header-bar").toggleClass("close");
        $(".menu").toggleClass("open");
    });

    //mobile drodown menu display
    $('.mobile-menu-area .m-menu li a').on('click', function(e) {
        var element = $(this).parent('li');
        if (element.hasClass('open')) {
            element.removeClass('open');
            element.find('li').removeClass('open');
            element.find('ul').slideUp(1000,"swing");
        }
        else {
            element.addClass('open');
            element.children('ul').slideDown(1000,"swing");
            element.siblings('li').children('ul').slideUp(1000,"swing");
            element.siblings('li').removeClass('open');
            element.siblings('li').find('li').removeClass('open');
            element.siblings('li').find('ul').slideUp(1000,"swing");
        }
    }); 

    // drop down menu width overflow problem fix
    $('ul').parent().hover(function() {
        var menu = $(this).find("ul");
        var menupos = $(menu).offset();

        if (menupos.left + menu.width() > $(window).width()) {
            var newpos = -$(menu).width();
            menu.css({ left: newpos });    
        }
    });


    // sticky-widget
    $(document).on('ready',function() {
        $('.sticky-widget').theiaStickySidebar();
    });

    // masonary portfolio
    jQuery(window).on('load',function() {
        var $grid = $('.portfolio .portfolio-wrapper').isotope({
            itemSelector: '.post-thumb',
            masonry: {
            columnWidth: 0,
            horizontalOrder: false,
            }
        });
    });

    // product slider
    var swiper = new Swiper('.product-slider', {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
            el: '.product-pagination',
            clickable: true,
        },
        speed: 1200,
        autoplay: {
            delay: 3200,
            disableOnInteraction: false,
        },
        loop: true
    });

    // sponsor slider
    var swiper = new Swiper('.sponsor-slider', {
        slidesPerView: 5,
        spaceBetween: 20,
        speed: 1200,
        autoplay: {
            delay: 3200,
            disableOnInteraction: false,
        },
        breakpoints: {
            992: {
                slidesPerView: 3,
            },
            576: {
                slidesPerView: 2,
            },
            375: {
                slidesPerView: 1,
            }
        },
        loop: true
    });

    // testimonial section start here
    var swiper = new Swiper('.testimonial-slider', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3200,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.testimonial-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.testimonial-button-next',
            prevEl: '.testimonial-button-prev',
        },
        breakpoints: {
            576: {
                spaceBetween: 0,
            }
        },
    });


    // histori section start here
    var swiper = new Swiper('.histori-slider', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3200,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.histori-button-next',
            prevEl: '.histori-button-prev',
        },
        breakpoints: {
            576: {
                spaceBetween: 0,
            }
        },
    });

    // counter up start
    $('.counter').counterUp({
        delay: 10,
        time: 2000
    });

    //shop-widget drodown menu display
    $('.shop-widget .shop-menu li a').on('click', function(e) {
        var element = $(this).parent('li');
        if (element.hasClass('open')) {
            element.removeClass('open');
            element.find('li').removeClass('open');
            element.find('ul').slideUp(1000,"swing");
        }
        else {
            element.addClass('open');
            element.children('ul').slideDown(1000,"swing");
            element.siblings('li').children('ul').slideUp(1000,"swing");
            element.siblings('li').removeClass('open');
            element.siblings('li').find('li').removeClass('open');
            element.siblings('li').find('ul').slideUp(1000,"swing");
        }
    });

    // shop cart + - start here
    var CartPlusMinus = $('.cart-plus-minus');
    CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
    CartPlusMinus.append('<div class="inc qtybutton">+</div>');
    $(".qtybutton").on("click", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() === "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find("input").val(newVal);
    });

    // product view mode change js
    $('.product-view-mode').on('click', 'a', function (e) {
        e.preventDefault();
        var shopProductWrap = $('.shop-product-wrap');
        var viewMode = $(this).data('target');
        $('.product-view-mode a').removeClass('active');
        $(this).addClass('active');
        shopProductWrap.removeClass('grid list').addClass(viewMode);
    });

    // model option start here
    $('.view-modal').on('click', function () {
        $('.modal').addClass('show');
    });

    $('.close').on('click', function () {
        $('.modal').removeClass('show');
    });

    //Slick Slider
    $('.slider-for').slick({
       slidesToShow: 1,
       slidesToScroll: 1,
       arrows: true,
       fade: false,
       asNavFor: '.slider-nav',
       autoplay: 5000,
    });
    $('.slider-nav').slick({
       slidesToShow: 5,
       slidesToScroll: 1,
       asNavFor: '.slider-for',
       dots: false,
       centerMode: false,
       focusOnSelect: true,
    });

    //Review Tabs
    $('ul.review-nav').on('click', 'li', function (e) {
        e.preventDefault();
        var reviewContent = $('.review-content');
        var viewRev = $(this).data('target');
        $('ul.review-nav li').removeClass('active');
        $(this).addClass('active');
        reviewContent.removeClass('review-content-show description-show').addClass(viewRev);
    });
    
    // wow animation
    new WOW().init();
    if ($(window).width() <= 991){ 
        $(".wow").removeClass("wow");
    }
    $(function() {
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 3,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            breakpoints: {
                575: {
                    slidesPerView: 1,
                }
            }
        });
        var galleryTop = new Swiper('.gallery-top', {
            spaceBetween: 30,
            navigation: {
                nextEl: '.testimonial-button-next',
                prevEl: '.testimonial-button-prev',
            },
            loop: true,
            autoplay: {
                delay: 3200,
                disableOnInteraction: false,
            },
            thumbs: {
                swiper: galleryThumbs
            }
        });
    });
}(jQuery));
