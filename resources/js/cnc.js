var cnc = {

  init: function() {

    // Show image instead of background video if on mobile device
    var parser = new UAParser();
   // console.log(parser.getResult());
    var device = parser.getResult().device.type;
    if($('.background-video').length > 0 && ( device === 'mobile' || device === "tablet" )) {
      $('.background-video').addClass('showing-background-image').find('video').remove();
    }

    //Open/close the main menu
    $('.show-menu').click(function(event) {
      $('nav.main').toggleClass('showing-main-menu');
    });
    $('.subnav-header').click(function() {
	    $(".main-menu .showing").removeClass('showing')
      $(this).toggleClass('showing');
    });
    
    $(window).on('scroll.shotover', function() {
      if ($(window).scrollTop() > 30 && !$('nav.main').hasClass('scrolled-down')) {
        $('nav.main').addClass('scrolled-down');
      } else if ($(window).scrollTop() <= 30 && $('nav.main').hasClass('scrolled-down')) {
        $('nav.main').removeClass('scrolled-down');
      }
    });
    resizeVideoIframes();
    resizeBackgroundVideo();
    $(window).on('resize', function() {
      resizeVideoIframes();
      resizeBackgroundVideo();
    });    
    function resizeVideoIframes() {
      if ($('.video-container').length > 0) {  
        $('.video-container iframe').each(function() {
          $(this).attr('height', $(this).width() * .56);
        });
      }
    }
    function resizeBackgroundVideo() {
      if ($('.background-video').length > 0) {
        var vh = $(window).outerHeight();
        $('.background-video').css('height', vh);
      }
    }
    $('.background-video-arrow').click(function() {
      $('body').animate({
        scrollTop: $(window).outerHeight()
      });
    });
  }
}



$(document).ready(function() {
	
	cnc.init();

	$(".crew-item").click(function(){
        
        var ele = $("#details-" + $(this).data('crew-id'));
        
        $("#popup-cont .pop-content .crew-details").remove();
        ele.clone().appendTo("#popup-cont .pop-content");
        
		$("#popup-cont .pop-content .crew-details").removeClass('hide');
		
        $("#popup-cont").popup({
	        autoopen: true,
	        transition: 'all 0.3s',
	        closeelement: '.crew-details_close',
	        beforeopen: function() {
				$("#popup-cont").find("")
			}
        }).removeClass('hide');
	});
  
  
  
});


$(document).ready(function() {
	/*
	var waypointClass = '[class*="animate"]';
	$(waypointClass).css({opacity: '0'});
	
	$(waypointClass).waypoint(function() {
		var animationClass = $(this).attr('class').split('animate-')[1];
		var delayTime = $(this).data('delay');
		$(this).delay(delayTime).queue(function(next){
			$(this).toggleClass('animated');
			$(this).toggleClass(animationClass);
			next();
		});
	},
	{
		offset: '90%',
		triggerOnce: true
	});
	*/
	
	var waypointClass = 'body .animate';
	var animationClass = 'fadeInUp';
	var delayTime;
	$(waypointClass).css({opacity: '0'});
	
	$(waypointClass).waypoint(function() {
		
		delayTime += 100;
		$(this).delay(delayTime).queue(function(next){
			$(this).toggleClass('animated');
			$(this).toggleClass(animationClass);
			delayTime = 0;
			next();
		});
	},
	{
		offset: '90%',
		triggerOnce: true
	});
});







$(document).ready(function() {



	
	//$("#fphone").inputmask("999-999-9999");
	//$("#fzip").inputmask("99999");
	//$("#fdate_driven").inputmask("99/99/9999").DatePicker();
	//$("#fdate_driven").inputmask("99/99/9999");
	//$("#fdate_driven").datepicker({
	//	constrainInput: true,
	//	dateFormat: "mm/dd/yyyy",
//		minDate: new Date(2016, 4, 1),
//		maxDate: new Date(2016, 5, 30)
//	});
	
	

	//window.cct = $("input[name=ci_csrf_token]").val();
			var errContainer = $('div#errors');
	$("#cnc-contact").validate({

		
			onkeyup: false, onblur: true,
			rules: {
					first_name: {
						required: true,
						maxlength:40,
						letterswithbasicpunc: true
					},
					last_name: {
						required: true,
						maxlength:40,
						letterswithbasicpunc: true
					},
					email: {
						checkEmail: true,
						required: true,
						email: true
					}
				},
				messages:{
					first_name: {
						required: "Required Field",
						maxlength:"",
						letterswithbasicpunc: ""
					},
					last_name: {
						required: "Required Field",
						maxlength:"",
						letterswithbasicpunc: ""
					},
					email: {
						required:"Required Field",
						email:""
					}
				}
	});
	

	
})	



