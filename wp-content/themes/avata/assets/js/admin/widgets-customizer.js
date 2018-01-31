jQuery(document).ready(function($) {
    'use strict';
	var api = wp.customize;
	// Hide the section sidebars
		$( 'div[id*=section-]' ).each( function( i, s ) {
			$( s ).parent( '.widgets-holder-wrap' ).hide();
		});
		
		var avata_get_sections = function(){
			
			var sections = new Array(),i = 0;
			$('#sub-accordion-panel-avata_frontpage_sections_panel > li.control-section:visible').each(function(index, element) {
                var id = $(this).attr('id');
				api.section( id.replace('accordion-section-','') ).priority( i+10 );
				id = id.replace('accordion-section-avata_','');	
				id = id.replace(/_/g, '-');
				sections[i] = id;
				i++;
            });
			return sections;
			}
			
			
		$('#sub-accordion-panel-avata_frontpage_sections_panel > li.control-section').each(function(index, element) {
            
			var sectionID = $(this).attr('id');
			sectionID = sectionID.replace('accordion-section-avata_section_','');
			
			$(this).find('.accordion-section-title').append('<i class="left fa fa-arrows">&nbsp;</i>');
			
			if($.inArray(sectionID, avata_params.section_types) !== -1){
					$(this).append('<a href="javascript:;" title="'+avata_params.i18n_04+'" class="avata-section-action avata-copy-section"><i class="right fa fa-files-o">&nbsp;</i></a>');
				}else{
					if(isNaN(sectionID)){
					$(this).append('<a href="javascript:;" title="'+avata_params.i18n_03+'" class="avata-section-action avata-delete-section"><i class="right fa fa-times">&nbsp;</i></a>');
					}
					
					}
			
        });
		
		$(document).on('click', '.avata-copy-section', function(e){
			
				e.preventDefault();
				$('.avata-update-to-pro').remove();
				$(this).after('<p class="avata-update-to-pro">'+avata_params.i18n_04+': '+avata_params.i18n_05+' </p>');
				
		});
		
	
		$('#sub-accordion-panel-avata_frontpage_sections_panel').sortable({items: "> li.control-section",update: function( event, ui ){
			
			var sections = new Array(),i = 0;
			$('#sub-accordion-panel-avata_frontpage_sections_panel > li.control-section:visible').each(function(index, element) {
                var id = $(this).attr('id');
				api.section( id.replace('accordion-section-','') ).priority( i+10 );
				id = id.replace('accordion-section-avata_','');	
				id = id.replace(/_/g, '-');
				sections[i] = id;
				i++;
            });
			
			var data_to_send = JSON.stringify(sections);
			api.instance('avata[section_order]').set(data_to_send)
        	api.instance('avata[section_order]').previewer.refresh();
			
		
			/*$.ajax({
				type: "POST",
				dataType:"html",
				url: avata_params.ajaxurl,
				data: { action: "sortsections",sections:sections }
			  })
				.done(function( msg ) {
				  $('#re-order-saved').remove();
				  $('#sub-accordion-panel-avata_frontpage_sections_panel').append('<li id="re-order-saved" style="padding: 10px;color: green;font-size: 16px;">'+avata_params.i18n_01+'</li>');
				  
				});*/
			
			
			}});
				
			
});