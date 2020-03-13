"use strict";
$(document).ready(function() {
    /*----------------------------------------------------
     TESTIMONIAL SLIDER
     ----------------------------------------------------*/

    $('#testimonial_slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        autoplay: true,
        draggable: true,
        fade: true,
        asNavFor: '#testimonial_carousel'
    });

    $('#testimonial_carousel').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '#testimonial_slider',
        dots: false,
        arrows: false,
        centerMode: true,
        autoplay: true,
        focusOnSelect: true,
        centerPadding: '40px',
        responsive: [, {
            breakpoint: 600,
            settings: {
                autoplay: true,
                dots: false,
                slidesToShow: 1,
                centerPadding: '0px',
                centerMode: true
            }
        }, {
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                centerMode: true
            }
        }, {
            breakpoint: 1199,
            settings: {
                centerPadding: '10px'

            }
        }]
    });
});
