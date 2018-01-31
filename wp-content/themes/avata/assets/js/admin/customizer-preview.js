( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-name' ).text( to );
		} );
	} );

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-tagline' ).text( to );
		} );
	} );
	
	/* Header text color. */
	wp.customize( 'header_textcolor', function( value ) {

		value.bind( function( to ) {
	
			if ( 'blank' === to ) {
				$( '.site-name, .site-tagline' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'display': 'none'
				} );
			} else {
				$( '.site-name, .site-tagline' ).css( {
					'clip': 'auto',
					'color': to,
					'display': 'block'
				} );
			}
		} );
	} );
	

} )( jQuery );

var avata_customizer_section_scroll = function ( $ ) {
    'use strict';
    $( function () {
        var customize = wp.customize;

        customize.preview.bind( 'clicked-customizer-section', function( data ) {
            
             var sectionId = 'section.avata-section-' + data;
          
            if ( $(sectionId).length > 0) {
               /* $('html, body').animate({
                    scrollTop: $(sectionId).offset().top - 100
                }, 1000);*/
            }
        } );
    } );
};

avata_customizer_section_scroll( jQuery );
