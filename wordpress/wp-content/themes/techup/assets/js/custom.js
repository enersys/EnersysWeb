/*--------------------------------------------------
 

    JS INDEX
    ================================================
    * preloader js
    * scroll to top js
    * sticky menu js
    * toggle search
    * navigation mobile menu
    * programs-slider-one
    * blog one slider
    * Isotop And Masonry
    * magnific popup
    * counter
    * Team Slider-two
    * testimonial slider js
    * partner slider js
    * service 3 slider js
    * service 4 slider js
    * class slider js
    * social sharing
    * box mouse-enter hover
    * Google map
    ================================================*/

(function ($) {
  "use strict";

  var $main_window = $(window);

  /*====================================
  preloader js
  ======================================*/
  $main_window.on("load", function () {
    $(".preloader").fadeOut("slow");
  });

  /*====================================
  scroll to top js
  ======================================*/
  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 250) {
      $("#c-scroll").fadeIn(200);
    } else {
      $("#c-scroll").fadeOut(200);
    }
  });
  $("#c-scroll").on("click", function () {
    $("html, body").animate({
        scrollTop: 0
      },
      "slow"
    );
    return false;
  });

  /*====================================
     sticky menu js
  ======================================*/

  $main_window.on('scroll', function () {
    var scroll = $(window).scrollTop();
    if (scroll >= 200) {
      $(".affix").addClass("sticky-menu");
    } else {
      $(".affix").removeClass("sticky-menu");
    }
  });
  
  
//   $('.jarallax').jarallax({
//    speed: 0.2
// });



  /*====================================
  toggle search
  ======================================*/
  $('.menu-search a').on("click", function () {
    $('.menu-search-form').toggleClass('s-active');
  });


  /*====================================
      navigation mobile menu
  ======================================*/

  function mainmenu() {
    $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
      if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
      }
      var $subMenu = $(this).next(".dropdown-menu");
      $subMenu.toggleClass('show');

      return false;
    });
  }
  mainmenu();



  /*====================================
    programs-slider-one
  ======================================*/
  if ($(".programs-slider-one").length > 0) {
    var swiper = new Swiper('.programs-slider-one', {
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      slidesPerView: 5,
      paginationClickable: true,
      spaceBetween: 0,
      loop: true,
      centeredSlides: true,
      slideToClickedSlide: true,
      parallax: true,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      }, 
      autoplayDisableOnInteraction: false,
      effect: 'coverflow',
      coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 20,
        modifier: 1,
        slideShadows: false,
      },
      breakpoints: {
        992: {
          slidesPerView: 3,
        },
        576: {
          slidesPerView: 1,
        }
      }
    });
  }

   /*------------------------
    Testimonial Slider
    ----------------------- */
    $(".testimonial-slider").owlCarousel({
        items: 1,
        dots: false,
        autoplay: true,
        loop: true,
        smartSpeed: 1200,
        nav: true,
        navText: ["<i class='arrow_left'></i>", "<i class='arrow_right'></i>"]
    });

    // Testimonials carousel (uses the Owl Carousel library)
  $(".testimonials-carousel").owlCarousel({
    autoplay: true,
    dots: true,
    loop: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 1
      },
      900: {
        items: 2
      },
      1400: {
        items: 3
      }
    }
  });


  /*====================================
    blog one slider
  ======================================*/
  var teamslider = $(".blog-slider");
  teamslider.owlCarousel({
    margin: 30,
    autoplay: true,
    autoplayHoverPause: true,
    nav: false,
    smartSpeed: 1000,
    dots: true,
    loop: true,
    navText: [
      '<i class="fa fa-arrow-left"></i>',
      '<i class="fa fa-arrow-right"></i>'
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 2,
      },
      1199: {
        items: 3,
      }
    }
  });


  /*====================================
    Isotop And Masonry
  ======================================*/
  if ($(".masonary-wrap").length > 0) {
    $main_window.on('load', function () {
      var $grid = $('.masonary-wrap').isotope({
        itemSelector: '.mas-item',
        percentPosition: true,
        masonry: {
          columnWidth: '.mas-item'
        }
      });
      $('.sorting').on('click', '.filter-btn', function () {
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({
          filter: filterValue
        });
      });
      $('.sorting li').on('click', function (event) {
        $(".filter-btn").removeClass('active');
        $(this).addClass('active');
        event.preventDefault();
      });
    });
  }

  /*====================================
     magnific popup
   ======================================*/
  if ($('.project').length > 0) {
    $('.project').magnificPopup({
      delegate: '.pop-btn',
      type: 'image',
      gallery: {
        enabled: true
      },
      removalDelay: 300,
      mainClass: 'mfp-fade'
    });
  }

  /*=======================================
     counter
  ======================================= */

  if ($('#counters').length > 0) {
    var a = 0;
    $main_window.scroll(function () {
      var oTop = $('#counters').offset().top - window.innerHeight;
      if (a === 0 && $main_window.scrollTop() > oTop) {
        $('.count').each(function () {
          var $this = $(this),
            countTo = $this.attr('data-count');
          $({
            countNum: $this.text()
          }).animate({
            countNum: countTo
          }, {
            duration: 3000,
            easing: 'swing',
            step: function () {
              $this.text(Math.floor(this.countNum));
            },
            complete: function () {
              $this.text(this.countNum);
              //alert('finished');
            }
          });
        });
        a = 1;
      }

    });
  }

  /*====================================
	 team-slider-two
	======================================*/

  var team2slider = $(".team-slider-two");
  team2slider.owlCarousel({
    autoplay: true,
    autoplayHoverPause: true,
    nav: true,
    smartSpeed: 1000,
    dots: false,
    loop: true,
    margin: 30,
    navText: [
      '<i class="fa fa-angle-left"></i>',
      '<i class="fa fa-angle-right"></i>'
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      575: {
        items: 1,
      },
      991: {
        items: 2,
      }
    }
  });

function accessgymnas() {
$( document ).on( 'keydown', function( e ) {
    if ( $( window ).width() > 992 ) {
        return;
    }
    var activeElement = document.activeElement;
    var menuItems = $( '#nav-content .menu-item > a' );
    var firstEl = $( '.menu-toggle' );
    var lastEl = menuItems[ menuItems.length - 1 ];
    var tabKey = event.keyCode === 9;
    var shiftKey = event.shiftKey;
    if ( ! shiftKey && tabKey && lastEl === activeElement ) {
        event.preventDefault();
        firstEl.focus();
    }
} );
}
accessgymnas();
  /*====================================
	  testimonial slider js
	======================================*/
  
  var owl_testi1 = jQuery(".testi-one-slider");
  owl_testi1.owlCarousel({
    loop: true,
    margin: 0,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    responsiveClass: true,
    items: 1,
    autoplay: true,
    autoplayHoverPause: false,
    nav: true,
    navText: [
      '<i class="fa fa-angle-left"></i>',
      '<i class="fa fa-angle-right"></i>'
    ],
    dotsContainer: '#testi-custom-thumb',
  });

  /*====================================
    blog one slider
  ======================================*/
  var teamslider = $(".blog-slider");
  teamslider.owlCarousel({
    margin: 30,
    autoplay: true,
    autoplayHoverPause: true,
    nav: false,
    smartSpeed: 1000,
    dots: true,
    loop: true,
    navText: [
      '<i class="fa fa-arrow-left"></i>',
      '<i class="fa fa-arrow-right"></i>'
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 2,
      },
      1199: {
        items: 3,
      }
    }
  });

  // Testimonials carousel (uses the Owl Carousel library)
  $(".testimonials-carousel").owlCarousel({
    autoplay: true,
    dots: true,
    loop: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 1
      },
      900: {
        items: 2
      },
      1400: {
        items: 3
      }
    }
  });


  /*====================================
		partner slider js
	======================================*/

  var partnerslider = $(".partner-slider");
  partnerslider.owlCarousel({
    autoplay: true,
    nav: false,
    autoplayHoverPause: true,
    smartSpeed: 350,
    dots: false,
    margin: 30,
    loop: true,
    navText: [
      '<i class="fa fa-arrow-left"></i>',
      '<i class="fa fa-arrow-right"></i>'
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      575: {
        items: 2,
      },
      991: {
        items: 4,
      },
      1199: {
        items: 5,
      }
    }
  });


  /*====================================
		service 3 slider js
	======================================*/

  var service3slider = $(".service-3slider");
  service3slider.owlCarousel({
    autoplay: true,
    nav: false,
    autoplayHoverPause: false,
    smartSpeed:1500,
    dots: false,
    margin:0,
    loop: true,
    navText: [
      '<i class="fa fa-arrow-left"></i>',
      '<i class="fa fa-arrow-right"></i>'
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      575: {
        items: 2,
      },
      991: {
        items: 4,
      },
      1199: {
        items: 5,
      }
    }
  });


  /*====================================
		service 4 slider js
	======================================*/

  var service4slider = $(".service-4slider");
  service4slider.owlCarousel({
    autoplay: true,
    nav: false,
    autoplayHoverPause: true,
    smartSpeed: 1500,
    dots: false,
    margin:30,
    loop: true,
    navText: [
      '<i class="fa fa-arrow-left"></i>',
      '<i class="fa fa-arrow-right"></i>'
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      575: {
        items: 2,
      },
      991: {
        items:2,
      }
    }
  });


  /*====================================
		class slider js
	======================================*/

  var class3slider = $(".class-3slider");
  class3slider.owlCarousel({
    autoplay: true,
    nav:true,
    autoplayHoverPause: true,
    smartSpeed: 500,
    dots: false,
    margin:30,
    loop: true,
    navText: [
      '<i class="fa fa-angle-left"></i>',
      '<i class="fa fa-angle-right"></i>'
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      575: {
        items: 2,
      },
      768: {
        items: 3,
      },
      991: {
        items: 4,
      }
    }
  });

  /*====================================
	  social sharing
	======================================*/
  if ($(".share").length > 0) {
    $(".share").jsSocials({
      showLabel: false,
      showCount: false,
      shareIn: "blank",
      shares: [{
          share: "twitter",
          logo: "fa fa-twitter-square",
        },
        {
          share: "facebook",
          logo: "fa fa-facebook-square"
        },
        {
          share: "googleplus",
          logo: "fa fa-google-plus-square"
        },
        {
          share: "linkedin",
          logo: "fa fa-linkedin-square"
        },
        {
          share: "pinterest",
          logo: "fa fa-pinterest-square"
        }
      ]
    });
  }


  /*======================================
    box mouse-enter hover
   ====================================== */
  var BoxHover = function () {
    jQuery('.box-hover').on('mouseenter', function () {
      jQuery(this).closest('.row').find('.box-hover').removeClass('active');
      jQuery(this).addClass('active');
    });
  };
  BoxHover();

})(jQuery);


/*======================================
  Google map
====================================== */
if (document.getElementById("theme-map")) {
  var myCenter = new google.maps.LatLng(-37.813628, 144.963058);

  function initialize() {
    var mapProp = {
      center: myCenter,
      scrollwheel: false,
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("theme-map"), mapProp);
    var marker = new google.maps.Marker({
      position: myCenter,
      animation: google.maps.Animation.BOUNCE,
      icon: 'assets/img/mapi.png',
      map: map,
    });
    marker.setMap(map);
  }
  google.maps.event.addDomListener(window, 'load', initialize);
}
// map initialization code  ends