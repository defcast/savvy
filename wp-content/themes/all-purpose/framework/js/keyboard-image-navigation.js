
        jQuery( document ).ready(function() {
            $( document ).keydown( function( e ) {
                /* In Galleries you can use LEFT and RIGHT ARROW KEYS to go to the previous/next image */
                var url = false;
                if ( e.which == 37 ) {  // Left arrow key code
                    url = $( '.previous-image' ).parent().attr( 'href' );
                } else if ( e.which == 39 ) {  // Right arrow key code
                    url = $( '.next-image' ).parent().attr( 'href' );
                }
                //console.log("URL: "+url);
                if ( url && ( !$( 'textarea, input' ).is( ':focus' ) ) ) {
                    window.location = url;
                }
            } );            
        });

