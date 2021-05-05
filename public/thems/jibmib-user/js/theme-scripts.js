/**
 * File theme-scripts.js.
 *
 * Handles Jquery functions
 * @package Pejoohan
 *  
 */

jQuery('document').ready(function($){

    /**
     * 
     * Go Top
     */
    $(document).find('#go_top').click(function(e){
        e.preventDefault();
        $("html, body").animate({scrollTop: 0}, 300);
    });

    /**
     * Drop right menu
     * @location theme directory /header.php
     */
     
     $('.menu-dropright').hover(function(){
      newHeight = $('.primary-nav-container').find('.dropdown-menu').outerHeight();
      newWith = $('.primary-nav-container').find('.dropdown-menu').outerWidth();
      $('.sub-menu').css({'height': newHeight, 'width': newWith, 'right': newWith - 3 })
      $(this).children('.sub-menu').css('display', 'block')},
      function(){
          $(this).children('.sub-menu').css('display', 'none');
      }
  );

      /**
       * Tablet and mobile dropdown
       */
       $('#dropdownMenuButton2').click(function(){
        $('#dropdownMenuButton2-1').slideToggle();
      });

      $('#dropdownMenuButton3').click(function(){
        $('#dropdownMenuButton3-1').slideToggle();
      });


      $(document).on('keydown', function(event) {
        if (event.key == "Escape") {
          var drop = $('.cart-header-menu');
          if(drop.is(":visible")){
            drop.slideUp();
          }
        }
    });

    // function overlay_on(){
    //   $('#page-overlay').css('display', 'block');
    //   $('.spinner').css('display', 'block');
    //   console.log("Hello 1");
    //   // $('#page-overlay').css('display', 'none');
    //   // $('.spinner').css('display', 'none');
    // }

    $('.overlay_on').click(function(){
      $('#page-overlay').css('display', 'block');
      $('.spinner').css('display', 'block');
      console.log("Hello 1");
    });
 

    /**
     * rearrange Category height to slider
     * @param {height of home top slider} h 
     */
    function sideCatFixer(h) {

        if (!h) {
            var newHeight;
            if ($('.slider-container')[0]) {
                newHeight = $('.slider-container').outerHeight();
            } else {
                newHeight = 450;
            }
            h = h | newHeight;
        }
        slider_height = h;
        var sc = $('.home-cat-section .side-cat'),
        li = sc.children(),
        a = li.children('a'),
        q = li.length;
        h = h-20;
        a.height((h / q) - 1).css('line-height', ((h / q) - 1) + 'px');
        var screen_width = $( window ).width();
        if(screen_width > 768){
          $('.home-top-thumb-side').css('height',h/2);
          $('.sp-offer').css('height',slider_height);
        }
        console.log(slider_height);
        
    };

    $(window).on('resize load' ,function() {
        sideCatFixer();
    });

     /**
     * Home line Slider
     */
      $('.line-thumb-slide').slick({
        infinite: true,
        speed: 300,
        centerMode: false,
        slidesToShow: 5,
        responsive: [
          {
            breakpoint: 992,
            settings: {
              arrows: false,
              centerMode: false,
              centerPadding: '40px',
              slidesToShow: 3
            }
          },
          {
            breakpoint: 680,
            settings: {
              arrows: false,
              centerMode: false,
              centerPadding: '40px',
              slidesToShow: 2
            }
          },
          {
            breakpoint: 470,
            settings: {
              arrows: false,
              centerPadding: '40px',
              slidesToShow: 1
            }
          }
        ]
      });

       /**
       * line Slider
       */
      $('.line-slider').each(function(){
        $(this).slick({
          infinite: true,
          rtl:true,
          speed: 300,
          rows: 2,
          centerMode: false,
          slidesToShow: 4,
          responsive: [
            {
              breakpoint: 992,
              settings: {
                rows: 1,
                arrows: false,
                slidesToShow: 3
              }
            },
            {
              breakpoint: 680,
              settings: {
                arrows: false,
                centerMode: false,
                slidesToShow: 2
              }
            },
            {
              breakpoint: 470,
              settings: {
                arrows: false,
                centerPadding: '40px',
                slidesToShow: 1
              }
            }
          ]
        });
      });


    /**
     * Home Bottom Slider
     */

    $('.center').slick({
        infinite: true,
        speed: 300,
        // slidesToScroll: 4,
        // centerMode: true,
        // centerPadding: '60px',
        slidesToShow: 5,
        prevArrow:"<div class=\"slide-arrow arrow-slider-left\"><i class=\"fa-light fa-arrow-left-long\"></div>",
        nextArrow: "<div class=\"slide-arrow  arrow-slider-right\"><i class=\"fa-light fa-arrow-right-long\"></i></div>",
        // rtl: true,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 3
            }
          },
          {
            breakpoint: 480,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 1
            }
          }
        ]
      });

    

    /**
     * Single Product Gallery
     */
    function product_img_fade(ele_id){
        $('.large-img-container').find('img').fadeOut( 300 ).delay( 800 );
        $('#'+ele_id).fadeIn("slow");
    }

    $('.single-img-thumb').click(function(){
        var img_id = $(this).attr('id');
        product_img_fade(img_id);
    });

    /**
     * single thumb Slider
     */
     $('.single-thumb-slider').slick({
      infinite: true,
      rtl: true,
      speed: 300,
      slidesToShow: 4,
    });

    /**
     * Map overlay hidden
     */
    $('.map-overlay').click(function(){
      $(this).css('display', 'none');
    });

    /**
     * Home Bottom Slider
     */
     $('.off-thumb-slider').each(function(){
      $(this).slick({
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        rtl: true,
        responsive: [
          {
            breakpoint: 992,
            settings: {
              arrows: false,
              centerPadding: '40px',
              slidesToShow: 3
            }
          },
          {
            breakpoint: 768,
            settings: {
              arrows: false,
              centerPadding: '40px',
              slidesToShow: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              arrows: false,
              centerPadding: '40px',
              slidesToShow: 1
            }
          }
        ]
      });
    });



});