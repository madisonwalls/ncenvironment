jQuery(document).ready(function($) {
	var avata_customize_scroller = function ( $ ) {
    'use strict';

    $( function () {
        var customize = wp.customize;

        $('ul[id*="avata_frontpage_sections_panel"] .accordion-section').not('.panel-meta').each( function () {
            $( this ).on( 'click', function() {
                var section = $( this ).attr('aria-owns').replace('sub-accordion-section-avata_section_','');
				section = section.replace(/_/g, '-');
                customize.previewer.send('clicked-customizer-section', section);
            });
        });
    } );
};

avata_customize_scroller( jQuery );

});