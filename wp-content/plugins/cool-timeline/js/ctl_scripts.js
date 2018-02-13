jQuery('document').ready(function($){
	$(".cooltimeline_cont").each(function(index ){
		
		var animations=$(this).attr("data-animations");
				if(animations!="none") {
					var addtocls = 'ctlvisible animated ' + animations;
					$(this).find('.timeline-content').addClass("ctlhidden").viewportChecker({
						classToAdd: addtocls,
						classToRemove: 'ctlhidden', // Class to remove before adding 'classToAdd' to the elements
						removeClassAfterAnimation: false, // Remove added classes after animation has finished
						offset: 100
					});
				}
	});
	
	 $(".cool_timeline").find("a[class^='ctl_prettyPhoto']").prettyPhoto({
	 social_tools: false,
	 show_title:false,
	});



});
