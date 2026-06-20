! function(e) {
	"use strict";

	function t() {
		c.hide()
	}

	function n() {
		c.show()
	}
	e(document).ready(function() {
		e(document).on("click", ".navbar-area .navbar-nav li.menu-item-has-children>a", function(e) {
			e.preventDefault()
		}), e(document).on("click", ".toggle-btn", function(t) {
			t.preventDefault(), e(this).toggleClass("active"), document.getElementById("sidebar").classList.toggle("active")
		}), e(document).on("click", ".show-cart", function(t) {
			t.preventDefault(), e(this).toggleClass("active"), document.getElementById("menu-cart-open").classList.toggle("active")
		}), e("#offcanvas-menu").length > 0 && e("#offcanvas-menu").meanmenu({
			meanMenuContainer: ".mobile-menu",
			meanScreenWidth: "25000"
		}), e(document).on("click", ".back-to-top", function() {
			e("html,body").animate({
				scrollTop: 0
			}, 2e3)
		}), e(".custom-select-box select").length > 0 && e(".custom-select-box select").niceSelect(), e(".arrow-down-wrap .arrow-down").on("click", function(t) {
			t.preventDefault(), e("html, body").animate({
				scrollTop: e(e(this).attr("href")).offset().top
			}, 500, "linear")
			
		})
	});

	/*-----------------------------------------
            Related Slider
        -------------------------------------------*/
        var $ACourTeamSlider = $('.h2-our-team-slider-active');
        if($ACourTeamSlider.length > 0){
            $ACourTeamSlider.slick({
                dots: false,
                infinite: true,
                speed: 1000,
                slidesToShow: 4,
                slidesToScroll: 2,
                autoplay: true,
                arrows: true,
                appendArrows: $('.team-slider-arrow'),
                prevArrow: '<div class="slick-prev"> <i class="flaticon-left-arrow-1"></i> </div>',
                nextArrow: '<div class="slick-next"> <i class="flaticon-arrow-pointing-to-right"></i> </div>',  
                responsive: [
                    {
                      breakpoint: 1651,
                      settings: {
                        slidesToShow: 4,
                        slidesToScroll: 2,
                      }
                    },
                    {
                      breakpoint: 1201,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 2
                      }
                    },
                    {
                      breakpoint: 991,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                      }
                    },   
                    {
                        breakpoint: 601,
                        settings: {
                          slidesToShow: 2,
                          slidesToScroll: 1
                        }
                    }     
                  ]  
            });      
        }
        /*-----------------------------------------
            Related Slider end
        -------------------------------------------*/

       /*-----------------------------------------
            Product Mobile Slider
        -------------------------------------------*/
        var $ACvehicleSlider = $('.mobile_slider');
        if($ACvehicleSlider.length > 0){
            $ACvehicleSlider.slick({
                dots: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                centerMode: false,
                arrows: false,
                prevArrow: '<div class="slick-prev"> <i class="flaticon-left-arrow-1"></i> </div>',
                nextArrow: '<div class="slick-next"> <i class="flaticon-arrow-pointing-to-right"></i> </div>',    
                responsive: [
                    {
                      breakpoint: 1450,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                      }
                    }      
                  ] 
            });      
        }


   /*-----------------------------------------
            Product Mobile Slider end
        -------------------------------------------*/



	var o = "",
		c = e("#service_info_item");
	e(window).on("scroll", function() {
		var a = e(".back-to-top");
		e(window).scrollTop() > 1e3 ? a.fadeIn(1e3) : a.fadeOut(1e3);
		var i = e(this).scrollTop(),
			l = e(".navbar-area");
		e(window).scrollTop() > 1e3 ? i > o ? l.removeClass("nav-fixed") : l.addClass("nav-fixed") : l.removeClass("nav-fixed "), e(window).width() < 992 ? i > o ? n() : t() : c.css({
			display: "inline-block"
		}), o = i
	}), e(window).on("load", function() {
		var o = e(".back-to-top");
		o.fadeOut();
		var c = e("#preloader");
		c.fadeOut(0), e(document).on("click", ".cancel-preloader a", function(t) {
			t.preventDefault(), e("#preloader").fadeOut(2e3)
		}), e(window).width() < 992 ? t() : n()
	}), e(window).on("resize", function(o) {
		o.preventDefault(), e(window).width() < 768 ? t() : n()
	})
}(jQuery);