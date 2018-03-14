(function ($) {
    jQuery(document).ready(function () {  

        if (window.matchMedia('(min-width: 768px)').matches) {
            jQuery(".cwmenu-list li").hover(
                    function () {
                        jQuery(this).children('ul').hide();
                        jQuery(this).children('ul').slideDown('500');
                    },
                    function () {
                        jQuery(this).children('ul').slideUp('slow');
                    });
        }
      jQuery(".down-move").on("click", function () {
            jQuery("html, body").animate({scrollTop: jQuery("#myId").offset().top}, 1e3);
        });
      });   
    jQuery(window).scroll(function () {
        if (jQuery(document).width() > 980) {
            if (jQuery(window).scrollTop()) {
                if (jQuery('body').hasClass('logged-in'))
                    jQuery(".scroll-header").addClass("slideDownScaleReversedIn").removeClass("slideDownScaleReversedOut").css({'position': 'fixed', 'top': '32px'});
                else
                    jQuery(".scroll-header").addClass("slideDownScaleReversedIn").removeClass("slideDownScaleReversedOut").css({'position': 'fixed', 'top': '0'});
            }
            else {
                if (jQuery('body').hasClass('logged-in'))
                    jQuery(".scroll-header").addClass("slideDownScaleReversedOut").removeClass("slideDownScaleReversedIn").css({'position': '', 'top': ''});
                else
                    jQuery(".scroll-header").addClass("slideDownScaleReversedOut").removeClass("slideDownScaleReversedIn").css({'position': 'relative', 'top': '0'});
                if (!(jQuery('body > section > div').hasClass('banner')))
                    jQuery('body > section').css({'margin-top': jQuery('.scroll-header').height()});
            }
        }

    });
})(jQuery);