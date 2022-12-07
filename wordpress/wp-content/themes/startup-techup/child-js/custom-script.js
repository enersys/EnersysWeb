/*================================================
              Start Testimonilas
=================================================*/

jQuery(function () {
    'use strict';
    jQuery(".testimonials-content").owlCarousel({
        dots:false,
        nav:true,
        loop: true,
        slideSpeed: 2000,
        autoPlay: true,
        responsiveClass:true,
        navText: [
          '<i class="fa fa-long-arrow-left"></i>',
          '<i class="fa fa-long-arrow-right"></i>'
        ],
        responsive:{
            0:{
                items:1,
                nav:false,
            },
            600:{
                items:1,
                nav:true,
            },
            
            1100:{
                items:2,
            }
        }
    });
});
 
