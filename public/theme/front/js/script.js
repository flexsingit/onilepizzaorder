"use strict";
$(document).ready(function() {

    var window_load = $(window);

    /*-----------------------------------------------------------
     add class for active menu
     ------------------------------------------------------------*/
    var pgurl = window.location.href.substr(window.location.href
        .lastIndexOf("/") + 1);
    $("#navbar ul li a").each(function() {
        if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
            $(this).addClass("active");
    })

    /*----------------------------------------
     home-cover-height
     ----------------------------------------*/

    function setHeight() {
        var home = $('#home');
        var heightNav = $("#navbar").outerHeight();
        var windowHeight = window_load.innerHeight();
        var BannerHeight = windowHeight - heightNav + 5;
        if (window_load.width() >= 320) {
            home.css('min-height', BannerHeight);
            $('.home-5-slider').css('min-height', BannerHeight);
            $('#home .item').css('min-height', BannerHeight);
        } else {
            home.removeAttr('min-height', BannerHeight);
        }
    }
    setHeight();

    window_load.resize(function() {
        setHeight();
    });
	
	$("#go-next").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 1500, function() {
                window.location.hash = hash;
            });
	}
	});
    /*----------------------------------------
     Blog-owlCarousel
     ----------------------------------------*/
    $(".blog_slider").owlCarousel({
        autoplay: true,
        dots: true,
        //margin:15,
        items: 3,
        lazyLoad: true,
        navigation: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            550: {
                items: 1,
                nav: false
            },
            768: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: false

            }
        }
    });

    /*----------------------------------------
     layout 5 home slider carousel
     ----------------------------------------*/
    $(".home-5-slider").owlCarousel({
        dots: false,
        items: 1,
        lazyLoad: true,
        navigation: false,
        autoplay: true,
        dots: true,
        loop: true,
        autoplayTimeout: 5000,
        responsiveClass: true,
        responsive: {
            0: {
                dots: false
            },
            768: {
                dots: true
            }
        }
    });
    /*----------------------------------------
     layout 6 home slider carousel
     ----------------------------------------*/
    $(".home-6-slider").owlCarousel({
        dots: false,
        items: 1,
        lazyLoad: true,
        navigation: true,
        autoplay: true,
        dots: false,
        nav: true,
        loop: true,
        autoplayTimeout: 5000,
        navText: ['<img src="assets/image/home/layout6/img-nav-prev.png" alt="nav">', '<img src="assets/image/home/layout6/img-nav-next.png" alt="nav">'],
        responsiveClass: true,
        responsive: {
            0: {
                nav: false
            },
            768: {
                nav: true
            }
        }
    });


    /*----------------------------------------
    Team-owlCarousel
    ----------------------------------------*/

    $(".team_slider").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navClass: ['owl-prev', 'owl-next'],
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        autoplayHoverPause: true,
        items: 2,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                loop: true,
                dots: false
            },

            700: {
                items: 1,
                nav: true,
                loop: true,
                dots: false
            },
            1000: {
                items: 2,
                nav: true,
                loop: true,
                dots: false
            }
        }
    });

    /*----------------------------------------
     award-owlCarousel
     ----------------------------------------*/
    $("#award_slider").owlCarousel({

        autoplay: true,
        loop: true,
        dots: false,
        items: 6,
        lazyLoad: true,
        navigation: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 3,
                nav: false
            },
            550: {
                items: 4,
                nav: false
            },
            1000: {
                items: 6,
                nav: false
            }
        }
    });
    /*----------------------------------------------------
     footer slider
     ----------------------------------------------------*/
    $("#footer_slider").owlCarousel({
        autoplay: true,
        autoplayTimeout: 5000,
        loop: true,
        dots: false,
        items: 8,
        lazyLoad: true,
        navigation: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 3,
                nav: false
            },
            550: {
                items: 6,
                nav: false
            },
            1000: {
                items: 10,
                nav: false
            }
        }
    });
    /*----------------------------------------
     Feature-Blog-owlCarousel
     ----------------------------------------*/
    $(".feature_blog_slider").owlCarousel({
        dots: false,
        items: 3,
        lazyLoad: true,
        navigation: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            550: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: false

            }
        }
    });

    /*----------------------------------------------------
    Scroll reveal animation
    ----------------------------------------------------*/
    if (Modernizr.csstransforms3d) {
        window.sr = ScrollReveal();

        sr.reveal('.reveal-0', {
            duration: 800,
            delay: 400,
            reset: true,
            easing: 'linear',
            scale: 1
        });
        sr.reveal('.reveal-left', {
            origin: 'left',
            distance: '0',
            duration: 800,
            delay: 400,
            opacity: 0,
            scale: 0,
            easing: 'linear',
            reset: true
        });
        sr.reveal('.reveal-right', {
            origin: 'right',
            distance: '0',
            duration: 800,
            delay: 400,
            opacity: 0,
            scale: 0,
            easing: 'linear',
            reset: true
        });
    }

    /*--------------------------------------------
     Menu Drop
     --------------------------------------------*/
    window_load.bind('scroll', function() {

        var windowHeight = window_load.innerHeight();
        var logo = document.getElementById("logo");
        var navbar = document.getElementById("navbar");
        if (window_load.scrollTop() > 100) {
            logo.style.top = "-8px";
            navbar.style.padding = "5px 0";

        } else {
            logo.style.top = "10px";
            navbar.style.padding = "25px 0";
        }
    });
    /*--------------------------------------------
    Blog Page Main Slider
    --------------------------------------------*/
    function random(owlSelector) {
        owlSelector.children().sort(function() {
            return Math.round(Math.random()) - 0.5;
        }).each(function() {
            $(this).appendTo(owlSelector);
        });
    }
    $("#blog_header").owlCarousel({
        loop: true,
        autoplayHoverPause: true,
        dots: false,
        navigation: true, // Show next and prev buttons
        nav: true,
        navClass: ['owl-prev', 'owl-next'],
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        slideSpeed: 300,
        paginationSpeed: 400,
        items: 1
    });

    /*------------------------------------------
    Tap to top Button
    ------------------------------------------*/
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 600) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').on('click', function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    /* _____________________________________

     Pre loader
     _____________________________________ */
    $(window).on('load', function() {
        $('.pre_loader').fadeOut('slow');
        $('.pre_loader').remove('slow');
    });
});
/* Contact form */

$("#contact_form").on("click", function(e){
send_form();
return false;
});

function send_form(){
	var first_name = $("input#name").val();
	//Firstname
	if (first_name == "") {
		$("input#name").focus();
		$("input#name").attr("placeholder", "Name is must required..");
		return false;
	}
	//Company
	var company = $("input#company").val();
	if (company == "") {
		$("input#company").focus();
		$("input#company").attr("placeholder", "Company is must required..");
		return false;
	}
	//Email
	var email = $("input#contact_email").val();
		if (email == "") {
		$("input#contact_email").focus();
		$("input#contact_email").attr("placeholder", "Email address is must required");
		return false;
	}
	else
	{
		var atpos = email.indexOf("@");
		var dotpos = email.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
			alert("Not a valid e-mail address");
			$("input#contact_email").focus();
			$("input#contact_email").attr("placeholder", "Please enter valid email address");
	    return false;
		}
	}
	//Phone number
	var phone = $("input#phone").val();
		if (phone == "") {
		$("input#phone").focus();
		$("input#phone").attr("placeholder", "phone number is must required..");
		return false;
	}
	else
	{
		if(isNaN(phone))
		{
			alert('Please enter the phone number in digit');
			$("input#phone").attr("placeholder", "Phone number must in digit");
			return false;
		}
	}
	//Message
	var message = $("#contact_message").val();
		if (message == "") {
		$("#contact_message").focus();
		$("#contact_message").attr("placeholder", "Message field is required");
		return false;
	}
	//Datastring pass to mail.php
	var dataString = '&Name=' + first_name + '&company=' + company + '&phone=' + phone + '&email=' + email + '&message=' + message;
	var form = $(this);
	var str = form.serialize(); 
	$.ajax({
	type: "POST", url: "assets/mail/mail.php",	data: dataString, success: function() {
		alert('Thanks for your contact. Our team contact you soon as possible');
		$(".submit_contact").attr('disabled','true');
		}
	});
}
