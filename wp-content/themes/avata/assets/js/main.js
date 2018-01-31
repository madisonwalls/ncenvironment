jQuery(document).ready(function($) {
	
var adminbarHeight = function(){
var stickyTop;
if ($("body.admin-bar").length) {
	if ($(window).width() < 765) {
		stickyTop = 46;
	} else {
		stickyTop = 32;
	}
} else {
	stickyTop = 0;
}
	return stickyTop;	
}

if ($(window).width() < 919 ) {
	$('.avata-home-sections .section').addClass('fp-auto-height-responsive');		  
}

var h = 0;
var stickyTop = adminbarHeight();
if($('#main-header').length)
	h += $('#main-header').outerHeight();
if($('.page-title-bar').length)
	h += $('.page-title-bar').outerHeight();
if($('footer').length) 
	h += $('footer').outerHeight();
$('.site-content,.page-wrap,.post-wrap').css({'min-height':$(window).height()-h});
	
/* side nav dotstyle */
	
if( $('#sub_nav').length ){
	var sub_nav = $('#sub_nav .sub_nav');
	sub_nav.css({'margin-top':'-'+(sub_nav.height()/2)+'px'});
}
$('#avata-nav').css({'margin-top':'-'+($('#avata-nav').height()/2)+'px'});
$('.page-template-template-frontpage.admin-bar #main-header').css({'top':stickyTop});

$('#dotstyle-nav ul li').click(function(){
	var hash = $(this).find('a').attr('href');
	Anchor = hash.replace('#','');
	var index = $("[data-anchor='"+Anchor+"']").index();
	$.fn.fullpage.moveTo(Anchor);
										
});

// Page Scroll

var sections = $('section'),
	nav = $('nav[role="navigation"]');

var autoScrolling = true;
if(avata_params.autoscrolling !=='1' )
	autoScrolling = false;
	
$('.avata-home-sections').fullpage({
	menu: '',
	anchors: avata_params.menu_anchors,
	autoScrolling: autoScrolling,
	fitToSection: false,
	fixedElements:'#wpadminbar',
	responsiveWidth:919,
	onLeave:  function(index, nextIndex, direction){
		if( nextIndex > 1 ){
			$('#main-header').css({'background-color':'rgba(48, 48, 48, '+avata_params.sticky_header_opacity_frontpage+')'});
		}else{
			$('#main-header').css({'background':'transparent'});
		}
		
		$('section').eq(index).find('.os-animation').each(function(){
				var osAnimationClass = $(this).attr('data-os-animation'),
		 		 osAnimationDelay = $(this).attr('data-os-animation-delay');	
				 $(this).css({
			  '-webkit-animation-delay':  osAnimationDelay,
			  '-moz-animation-delay':     osAnimationDelay,
			  'animation-delay':          osAnimationDelay
		  });
	
	  	$(this).addClass('animated').addClass(osAnimationClass);
		});


	},
	afterLoad: function(anchor, index){
		
		$('#dotstyle-nav li').removeClass('active');
		$('#menu-main li a').removeClass('active');
		$('#dotstyle-nav li a[href="#'+anchor+'"]').parent('li').addClass('active');
		$('#menu-main li a[href="#'+anchor+'"]').addClass('active');
				
		$('section').eq(index-1).find('.os-animation').each(function(){
		
				var osAnimationClass = $(this).attr('data-os-animation'),
		 		 osAnimationDelay = $(this).attr('data-os-animation-delay');	
				 $(this).css({
			  '-webkit-animation-delay':  osAnimationDelay,
			  '-moz-animation-delay':     osAnimationDelay,
			  'animation-delay':          osAnimationDelay
		  });
	
	  	$(this).addClass('animated').addClass(osAnimationClass);
		});

		
	},
	 afterRender: function () {
		 if($('.avata-slider').length ){
			 var options = $('.avata-slider').data('options');
			 $('.avata-slider .avata-banner-bgimage').removeClass('avata-fullheight');
			 if(typeof options.autoplay !='undefined' && options.autoplay === '1'){
            setInterval(function () {
                $.fn.fullpage.moveSlideRight();
            }, parseInt(options.timeout));
		 }
		 }
		
	},
	
});

/*gallery*/
$('#lightgallery').lightGallery();
$('.avate-video-container').lightGallery();
// Counter
	var counter = function() {
		$('.avata-counter-style-1').waypoint( function( direction ) {
			var el = $(this.element).attr('class');
			if( direction === 'down' && !$(this.element).hasClass('animated')) {
				setTimeout( function(){
					// console.log($(this.element));
					$('.'+el).find('.js-counter').countTo({
						 formatter: function (value, options) {
				      	return value.toFixed(options.decimals);
				   	},
					});
				} , 200);
				
				$(this.element).addClass('animated');
					
			}
		} , { offset: '75%' } );


		$('.avata-counter-style-2').waypoint( function( direction ) {
			var el = $(this.element).attr('class');
			if( direction === 'down' && !$(this.element).hasClass('animated')) {
				setTimeout( function(){
					$('.'+el).find('.js-counter').countTo({
						 formatter: function (value, options) {
				      	return value.toFixed(options.decimals);
				   	},
					});
				} , 200);
				
				$(this.element).addClass('animated');
					
			}
		} , { offset: '75%' } );
	};
	counter();
/*testimonial*/

var owl = $('.owl-carousel-fullwidth');
		owl.owlCarousel({
			items: 1,
			loop: true,
			margin: 0,
			responsiveClass: true,
			nav: false,
			dots: true,
			smartSpeed: 500,
			autoHeight: true,
			pullDrag: false,
	});

$('.comment-form #submit').addClass('btn btn-md btn-primary');
$('.comment-reply-link').addClass('pull-right btn-reply');

// blog grid
var $container = $('.blog-list');
$container.imagesLoaded(function(){
  $container.masonry({
    itemSelector: '.grid-item', isAnimated: true,
  });
});

// responsive menu
if( $('header nav > ul').length )
    $('header nav').hoomenu({hooScreenWidth:1141,hooMenuContainer:'header#main-header',onePage: true});

$('.move-section-down').click(function(){
    $.fn.fullpage.moveSectionDown();
});
$('.move-section-up').click(function(){
    $.fn.fullpage.moveSectionUp();
});

// Animation
$(function(){
	function onScrollInit( items, trigger ) {
		items.each( function() {
		var osElement = $(this),
		osAnimationClass = osElement.attr('data-os-animation'),
		osAnimationDelay = osElement.attr('data-os-animation-delay');
                  
		osElement.css({
			'-webkit-animation-delay':  osAnimationDelay,
			'-moz-animation-delay':     osAnimationDelay,
			'animation-delay':          osAnimationDelay
		});
	var osTrigger = ( trigger ) ? trigger : osElement;
                    
	osTrigger.waypoint(function() {
		osElement.addClass('animated').addClass(osAnimationClass);
	},{
		triggerOnce: true,
		offset: '80%'
	});
	});
	}
	onScrollInit( $('.os-animation') );
	onScrollInit( $('.staggered-animation'), $('.staggered-animation-container') );
});

$('.progress-bar').waypoint(function() { $(this.element).css({ animation: "animate-positive 2s", opacity: "1" }); }, { offset: '75%' });
$('.progress2').waypoint(function() {
	var percent = parseInt($(this.element).data('percent'));
	var color = $(this.element).data('color');
	$(this.element).circleProgress({
		fill: {color: color},
   		value: (percent/100)
  	}).on('circle-animation-progress', function(event, progress) {
   		$(this).find('strong').html(Math.round(percent * progress) + '<i>%</i>');
  });
}, { offset: '75%' });


});



/*!
* responsive menu
*/
(function ($) {
	"use strict";
		$.fn.hoomenu = function (options) {
				var defaults = {
						hooMenuTarget: jQuery(this), // Target the current HTML markup you wish to replace
						hooMenuContainer: 'body', // Choose where hoomenu will be placed within the HTML
						hooMenuClose: "X", // single character you want to represent the close menu button
						hooMenuCloseSize: "18px", // set font size of close button
						hooMenuOpen: "<span /><span /><span />", // text/markup you want when menu is closed
						hooRevealPosition: "right", // left right or center positions
						hooRevealPositionDistance: "0", // Tweak the position of the menu
						hooRevealColour: "", // override CSS colours for the reveal background
						hooScreenWidth: "480", // set the screen width you want hoomenu to kick in at
						hooNavPush: "", // set a height here in px, em or % if you want to budge your layout now the navigation is missing.
						hooShowChildren: true, // true to show children in the menu, false to hide them
						hooExpandableChildren: true, // true to allow expand/collapse children
						hooExpand: "+", // single character you want to represent the expand for ULs
						hooContract: "-", // single character you want to represent the contract for ULs
						hooRemoveAttrs: false, // true to remove classes and IDs, false to keep them
						onePage: false, // set to true for one page sites
						hooDisplay: "block", // override display method for table cell based layouts e.g. table-cell
						removeElements: "" // set to hide page elements
				};
				options = $.extend(defaults, options);

				// get browser width
				var currentWidth = window.innerWidth || document.documentElement.clientWidth;

				return this.each(function () {
						var hooMenu = options.hooMenuTarget;
						var hooContainer = options.hooMenuContainer;
						var hooMenuClose = options.hooMenuClose;
						var hooMenuCloseSize = options.hooMenuCloseSize;
						var hooMenuOpen = options.hooMenuOpen;
						var hooRevealPosition = options.hooRevealPosition;
						var hooRevealPositionDistance = options.hooRevealPositionDistance;
						var hooRevealColour = options.hooRevealColour;
						var hooScreenWidth = options.hooScreenWidth;
						var hooNavPush = options.hooNavPush;
						var hooRevealClass = ".hoomenu-reveal";
						var hooShowChildren = options.hooShowChildren;
						var hooExpandableChildren = options.hooExpandableChildren;
						var hooExpand = options.hooExpand;
						var hooContract = options.hooContract;
						var hooRemoveAttrs = options.hooRemoveAttrs;
						var onePage = options.onePage;
						var hooDisplay = options.hooDisplay;
						var removeElements = options.removeElements;

						//detect known mobile/tablet usage
						var isMobile = false;
						if ( (navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/Android/i)) || (navigator.userAgent.match(/Blackberry/i)) || (navigator.userAgent.match(/Windows Phone/i)) ) {
								isMobile = true;
						}

						if ( (navigator.userAgent.match(/MSIE 8/i)) || (navigator.userAgent.match(/MSIE 7/i)) ) {
							// add scrollbar for IE7 & 8 to stop breaking resize function on small content sites
								jQuery('html').css("overflow-y" , "scroll");
						}

						var hooRevealPos = "";
						var hooCentered = function() {
							if (hooRevealPosition === "center") {
								var newWidth = window.innerWidth || document.documentElement.clientWidth;
								var hooCenter = ( (newWidth/2)-22 )+"px";
								hooRevealPos = "left:" + hooCenter + ";right:auto;";

								if (!isMobile) {
									jQuery('.hoomenu-reveal').css("left",hooCenter);
								} else {
									jQuery('.hoomenu-reveal').animate({
											left: hooCenter
									});
								}
							}
						};

						var menuOn = false;
						var hooMenuExist = false;


						if (hooRevealPosition === "right") {
								hooRevealPos = "right:" + hooRevealPositionDistance + ";left:auto;";
						}
						if (hooRevealPosition === "left") {
								hooRevealPos = "left:" + hooRevealPositionDistance + ";right:auto;";
						}
						// run center function
						hooCentered();

						// set all styles for hoo-reveal
						var $navreveal = "";

						var hooInner = function() {
								// get last class name
								if (jQuery($navreveal).is(".hoomenu-reveal.hooclose")) {
										$navreveal.html(hooMenuClose);
								} else {
										$navreveal.html(hooMenuOpen);
								}
						};

						// re-instate original nav (and call this on window.width functions)
						var hooOriginal = function() {
							jQuery('.hoo-bar,.hoo-push').remove();
							jQuery(hooContainer).removeClass("hoo-container");
							jQuery(hooMenu).css('display', hooDisplay);
							menuOn = false;
							hooMenuExist = false;
							jQuery(removeElements).removeClass('hoo-remove');
						};

						// navigation reveal
						var showHooMenu = function() {
								var hooStyles = "background:"+hooRevealColour+";color:"+hooRevealColour+";"+hooRevealPos;
								if (currentWidth <= hooScreenWidth) {
								jQuery(removeElements).addClass('hoo-remove');
									hooMenuExist = true;
									// add class to body so we don't need to worry about media queries here, all CSS is wrapped in '.hoo-container'
									jQuery(hooContainer).addClass("hoo-container");
									jQuery('.hoo-container').prepend('<div class="hoo-bar"><a href="#nav" class="hoomenu-reveal" style="'+hooStyles+'">Show Navigation</a><nav class="hoo-nav"></nav></div>');

									//push hooMenu navigation into .hoo-nav
									var hooMenuContents = jQuery(hooMenu).html();
									jQuery('.hoo-nav').html(hooMenuContents);

									// remove all classes from EVERYTHING inside hoomenu nav
									if(hooRemoveAttrs) {
										jQuery('nav.hoo-nav ul, nav.hoo-nav ul *').each(function() {
											// First check if this has hoo-remove class
											if (jQuery(this).is('.hoo-remove')) {
												jQuery(this).attr('class', 'hoo-remove');
											} else {
												jQuery(this).removeAttr("class");
											}
											jQuery(this).removeAttr("id");
										});
									}

									// push in a holder div (this can be used if removal of nav is causing layout issues)
									jQuery(hooMenu).before('<div class="hoo-push" />');
									jQuery('.hoo-push').css("margin-top",hooNavPush);

									// hide current navigation and reveal hoo nav link
									jQuery(hooMenu).hide();
									jQuery(".hoomenu-reveal").show();

									// turn 'X' on or off
									jQuery(hooRevealClass).html(hooMenuOpen);
									$navreveal = jQuery(hooRevealClass);

									//hide hoo-nav ul
									jQuery('.hoo-nav ul').hide();

									// hide sub nav
									if(hooShowChildren) {
											// allow expandable sub nav(s)
											if(hooExpandableChildren){
												jQuery('.hoo-nav ul ul').each(function() {
														if(jQuery(this).children().length){
																jQuery(this,'li:first').parent().append('<a class="hoo-expand" href="#" style="font-size: '+ hooMenuCloseSize +'">'+ hooExpand +'</a>');
														}
												});
												jQuery('.hoo-expand').on("click",function(e){
														e.preventDefault();
															if (jQuery(this).hasClass("hoo-clicked")) {
																	jQuery(this).text(hooExpand);
																jQuery(this).prev('ul').slideUp(300, function(){});
														} else {
																jQuery(this).text(hooContract);
																jQuery(this).prev('ul').slideDown(300, function(){});
														}
														jQuery(this).toggleClass("hoo-clicked");
												});
											} else {
													jQuery('.hoo-nav ul ul').show();
											}
									} else {
											jQuery('.hoo-nav ul ul').hide();
									}

									// add last class to tidy up borders
									jQuery('.hoo-nav ul li').last().addClass('hoo-last');
									$navreveal.removeClass("hooclose");
									jQuery($navreveal).click(function(e){
										e.preventDefault();
								if( menuOn === false ) {
												$navreveal.css("text-align", "center");
												$navreveal.css("text-indent", "0");
												$navreveal.css("font-size", hooMenuCloseSize);
												jQuery('.hoo-nav ul:first').slideDown();
												menuOn = true;
										} else {
											jQuery('.hoo-nav ul:first').slideUp();
											menuOn = false;
										}
											$navreveal.toggleClass("hooclose");
											hooInner();
											jQuery(removeElements).addClass('hoo-remove');
									});

									// for one page websites, reset all variables...
									if ( onePage ) {
										jQuery('.hoo-nav ul > li > a:first-child').on( "click" , function () {
											jQuery('.hoo-nav ul:first').slideUp();
											menuOn = false;
											jQuery($navreveal).toggleClass("hooclose").html(hooMenuOpen);
										});
									}
							} else {
								hooOriginal();
							}
						};

						if (!isMobile) {
								// reset menu on resize above hooScreenWidth
								jQuery(window).resize(function () {
										currentWidth = window.innerWidth || document.documentElement.clientWidth;
										if (currentWidth > hooScreenWidth) {
												hooOriginal();
										} else {
											hooOriginal();
										}
										if (currentWidth <= hooScreenWidth) {
												showHooMenu();
												hooCentered();
										} else {
											hooOriginal();
										}
								});
						}

					jQuery(window).resize(function () {
								// get browser width
								currentWidth = window.innerWidth || document.documentElement.clientWidth;

								if (!isMobile) {
										hooOriginal();
										if (currentWidth <= hooScreenWidth) {
												showHooMenu();
												hooCentered();
										}
								} else {
										hooCentered();
										if (currentWidth <= hooScreenWidth) {
												if (hooMenuExist === false) {
														showHooMenu();
												}
										} else {
												hooOriginal();
										}
								}
						});

					// run main menuMenu function on load
					showHooMenu();
				});
		};
})(jQuery);