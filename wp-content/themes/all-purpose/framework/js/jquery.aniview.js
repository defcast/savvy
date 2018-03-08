        jQuery(document).ready(function(){
            jQuery('.aniview').AniView();
        });
		
		(function(jQuery) {

    //custom scroll replacement to allow for interval-based 'polling'
    //rather than checking on every pixel.
    var uniqueCntr = 0;
    jQuery.fn.scrolled = function(waitTime, fn) {
        if (typeof waitTime === 'function') {
            fn = waitTime;
            waitTime = 0;
        }
        var tag = 'scrollTimer' + uniqueCntr++;
        this.scroll(function() {
            var self = jQuery(this);
            clearTimeout(self.data(tag));
            self.data(tag, setTimeout(function() {
                self.removeData(tag);
                fn.call(self[0]);
            }, waitTime));
        });
    };

    jQuery.fn.AniView = function(options) {

        //some default settings. animateThreshold controls the trigger point
        //for animation and is subtracted from the bottom of the viewport.
        var settings = jQuery.extend({
            animateThreshold: 0,
            scrollPollInterval: 20
        }, options);

        //keep the matched elements in a variable for easy reference
        var collection = this;

        //cycle through each matched element and wrap it in a block/div
        //and then proceed to fade out the inner contents of each matched element
        jQuery(collection).each(function(index, element) {
            jQuery(element).wrap('<div class="av-container"></div>');
            jQuery(element).css('opacity', 0);
        });

        /**
         * returns boolean representing whether element's top is coming into bottom of viewport
         *
         * @param HTMLDOMElement element the current element to check
         */
        function EnteringViewport(element) {
            var elementTop = jQuery(element).offset().top;
            var viewportBottom = jQuery(window).scrollTop() + jQuery(window).height();
            return (elementTop < (viewportBottom - settings.animateThreshold)) ? true : false;
        }

        /**
         * cycle through each element in the collection to make sure that any
         * elements which should be animated into view, are...
         *
         * @param collection of elements to check
         */
        function RenderElementsCurrentlyInViewport(collection) {
            jQuery(collection).each(function(index, element) {
                var elementParentContainer = jQuery(element).parent('.av-container');
                if (jQuery(element).is('[data-av-animation]') && !jQuery(elementParentContainer).hasClass('av-visible') && EnteringViewport(elementParentContainer)) {
                    jQuery(element).css('opacity', 1);
                    jQuery(elementParentContainer).addClass('av-visible');
                    jQuery(element).addClass('animated ' + jQuery(element).attr('data-av-animation'));
                }
            });
        }

        //on page load, render any elements that are currently/already in view
        RenderElementsCurrentlyInViewport(collection);

        //enable the scrolled event timer to watch for elements coming into the viewport
        //from the bottom. default polling time is 20 ms. This can be changed using
        //'scrollPollInterval' from the user visible options
        jQuery(window).scrolled(settings.scrollPollInterval, function() {
            RenderElementsCurrentlyInViewport(collection);
        });
    };
})(jQuery);
