<?php

/**
 * get theme textdomain.
 */

function avata_get_option_name(){
	
	//$themename = get_option( 'stylesheet' );
	//$themename = preg_replace("/\W/", "_", strtolower($themename) );
	//return $themename;
	return 'avata';
}

function avata_setup(){
	global $content_width,$avata_lite_sections, $avata_options;
	$textdomain    = avata_get_option_name();
	$avata_options = get_option($textdomain);
	$lang = get_template_directory(). '/languages';
	load_theme_textdomain('avata', $lang );
	add_theme_support( 'post-thumbnails' ); 
	$args = array();
	$header_args = array( 
	    'default-image'          => '',
		'default-repeat' => 'no-repeat',
        'default-text-color'     => '000000',
		'url'                    => '',
        'width'                  => 1920,
        'height'                 => 82,
        'flex-height'            => true
     );
	add_theme_support( 'custom-background', $args );
	add_theme_support( 'custom-header', $header_args );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('nav_menus');
	add_theme_support( "title-tag" );
	add_theme_support( 'custom-logo' );
	register_nav_menus( array('primary' => __( 'Primary Menu', 'avata' ),'home' => __( 'Front Page Main Menu', 'avata' )));
	add_editor_style("editor-style.css");
	add_image_size( 'blog', 609, 214 , true);
	if ( !isset( $content_width ) ) $content_width = 1170;
	
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	// Woocommerce Support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'avata_setup' );


/*****************************************/
/******          WIDGETS     *************/
/*****************************************/

/*add_action('widgets_init', 'avata_register_widgets');

function avata_register_widgets() {
	global $avata_lite_sections;

	$extra_class = 'avata-section-widgets';
	foreach ( $avata_lite_sections as $k => $v ):
        register_sidebar(
            array (
                'name'          => $v['name'],
                'id'            => $k,
                'before_widget' => '<span id="%1$s" class="'.$extra_class.'">',
                'after_widget' => '</span>',
            )
        );
		
    endforeach;
}*/

/**
 * Selective Refresh
 */
function avata_register_blogname_partials( WP_Customize_Manager $wp_customize ) {
	
	global $avata_sections;
	if (is_array($avata_sections) && !empty($avata_sections) ){
    	foreach( $avata_sections as $k => $v ){
			foreach( $v['fields'] as $field_id=>$field ){
				if(!isset($field['settings']) ){
					$field['settings'] = $field_id;
					}
				if(!is_array($field['settings'])){
					if(isset($field['type']) && ($field['type'] == 'text' || $field['type'] == 'textarea' || $field['type'] == 'editor' || $field['type'] == 'image' || $field['type'] == 'repeater' ) ){
					$wp_customize->selective_refresh->add_partial( $field['settings'].'_selective', array(
						'selector' => '.avata-'.$field['settings'],
						'settings' => array( 'avata['.$field['settings'].']' ),
						'fallback_refresh' => false
						) );
					}
				}
				
			}
		}
	}
	
	$wp_customize->selective_refresh->add_partial( 'header_site_title', array(
		'selector' => '.site-name',
		'settings' => array( 'blogname' ),
	) );
	
	$wp_customize->selective_refresh->add_partial( 'header_site_description', array(
		'selector' => '.site-tagline',
		'settings' => array( 'blogdescription' ),
	) );
	
	
	$wp_customize->selective_refresh->add_partial( 'copyright_selective', array(
		'selector' => '.avata-copyright',
		'settings' => array( 'avata[copyright]' ),
	) );
}
add_action( 'customize_register', 'avata_register_blogname_partials' );

/**
 * Enqueue scripts and styles.
 */

function avata_enqueue_scripts() {
	
	global $avata_sections;
	
	$theme_info   = wp_get_theme();
	$google_fonts = avata_option('google_fonts');
	
	if (trim($google_fonts) != '') {
		$google_fonts = str_replace(' ','+',trim($google_fonts));
		wp_enqueue_style('avata-google-fonts', esc_url('//fonts.googleapis.com/css?family='.$google_fonts), false, '', false );
	}
	wp_enqueue_style('font-awesome',  get_template_directory_uri() .'/assets/plugins/font-awesome/css/font-awesome.min.css', false, '4.7.0', false);
	wp_enqueue_style('bootstrap',  get_template_directory_uri() .'/assets/plugins/bootstrap/css/bootstrap.css', false, '3.3.7', false);
	wp_enqueue_style('jquery-fullpage',  get_template_directory_uri() .'/assets/plugins/fullPage.js/jquery.fullPage.css', false, '2.9.4', false);
	wp_enqueue_style('lightgallery',  get_template_directory_uri() .'/assets/plugins/lightGallery/css/lightgallery.min.css', false, '1.5', false);
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri().'/assets/plugins/owl-carousel/assets/owl.carousel.css',false, '2.3.0', false );
	wp_enqueue_style( 'animate', get_template_directory_uri().'/assets/css/animate.css',false, '3.5.2', false );
	
	wp_enqueue_style( 'avata-main', get_stylesheet_uri(), array(),  $theme_info->get( 'Version' ) );
	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/assets/plugins/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );
	wp_enqueue_script( 'jquery-fullpage', get_template_directory_uri().'/assets/plugins/fullPage.js/jquery.fullPage.min.js', array( 'jquery' ), '2.9.4', true );
        
    wp_enqueue_script( 'picturefill', get_template_directory_uri().'/assets/plugins/lightGallery/js/picturefill.js', array( 'jquery' ), '3.0.2', true );
	wp_enqueue_script( 'lightgallery', get_template_directory_uri().'/assets/plugins/lightGallery/js/lightgallery-all.min.js', array( 'jquery' ), '1.5', true );
    wp_enqueue_script( 'jquery-mousewheel', get_template_directory_uri().'/assets/plugins/lightGallery/js/jquery.mousewheel.js', array( 'jquery' ), '3.1.13', true );
	
	wp_enqueue_script( 'jquery-countto', get_template_directory_uri().'/assets/plugins/jquery.countTo.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri().'/assets/plugins/owl-carousel/owl.carousel.js', array( 'jquery' ), '2.3.0', true );
	wp_enqueue_script( 'waypoints', get_template_directory_uri().'/assets/plugins/waypoints/jquery.waypoints.js',array( 'jquery' ), '4.0.1', true );
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'masonry' );
	
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	
	
		
	$css = '';
	/* custom sections */
	
	if ( 'blank' != get_header_textcolor() && '' != get_header_textcolor() ){
		$header_color =  ' color:#' . get_header_textcolor() . ';';
		$css .=  '.site-name,.site-tagline{'.$header_color.'}';
	}else{
		$css .=  '.site-name,.site-tagline{display:none;}';
		}
		
	$menu_color_frontpage =  avata_option('menu_color_frontpage');
	$css .=  ".homepage-header .main-nav > li > a{color:".$menu_color_frontpage.";}";
	
	$anchors = array();
	
	foreach ( $avata_sections as $k=>$v ){
		
		if($k=='section-progress-bar-2')
			wp_enqueue_script( 'jquery-circle-progress', get_template_directory_uri().'/assets/plugins/jquery-circle-progress/circle-progress.js',array( 'jquery' ), '1.2.2', true );
			
			
		$n = str_replace('section-','',$k);
		$j = str_replace('-','_',$n);
		$item = str_replace('section-','',$k) ;
		
		$hide  = avata_option('section_hide_'.$j);
		if ( $hide == '1' || $hide == 'on' )
			continue;
				
		$font_size = avata_option('font_size_'.$j);
		$font      = avata_option('font_'.$j);
		$font_color = avata_option('font_color_'.$j);
		$background_color = avata_option('background_color_'.$j);
		$background_opacity = avata_option('background_opacity_'.$j);
		$background_image = avata_option('background_image_'.$j);
		$background_repeat = avata_option('background_repeat_'.$j);
		$background_position = avata_option('background_position_'.$j);
		$background_attachment = avata_option('background_attachment_'.$j);
		$full_background_image = avata_option('full_background_image_'.$j);
		$padding_top = avata_option('padding_top_'.$j);
		$padding_bottom = avata_option('padding_bottom_'.$j);
		$menu_slug      = esc_attr(avata_option('section_id_'.$j ));
		$anchors[]      = $menu_slug;
		
		
		
		if(is_numeric($background_image))
			$background_image = wp_get_attachment_image_url($background_image,'full');
			
		
		$content_typography = avata_option( 'content_typography_'.$j );
		
		if( $content_typography )
			$css .= ".section-".$item." .section-content,.section-".$item." .section-content span,.section-".$item." .section-content h1,.section-".$item." .section-content h2,.section-".$item." .section-content h3,.section-".$item." .section-content h4,.section-".$item." .section-content h5,.section-".$item." .section-content h6{font-family:".$content_typography['font-family'].";color:".$content_typography['color'].";}.section-".$item." .social-icons a{border-color:".$content_typography['color'].";},.section-".$item." .social-icons i{color:".$content_typography['color'].";}";
		
		
		$css .= ".section-".$item."{background-image:url(".$background_image.");background-repeat:".$background_repeat.";background-position:".$background_position.";background-attachment:".$background_attachment.";}";
		
		$css .= ".section-".$item."{background-color:".Kirki_Color::get_rgba( $background_color, $background_opacity ).";}";
		//$css .= ".section-".$item.".fp-auto-height .section-content-wrap{background-color:".Kirki_Color::get_rgba( $background_color, $background_opacity ).";}";
		
		if( $full_background_image == 'yes' || $full_background_image == '1' )
			$css .= ".section-".$item."{-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;}";
		
		$css .= ".section-".$item.".fp-auto-height .section-content-wrap{padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";}";

	}
	
	wp_enqueue_script( 'avata-main', get_template_directory_uri().'/assets/js/main.js', array( 'jquery' ), $theme_info->get( 'Version' ), true );
	
	$copyright_font_color = avata_option('copyright_color');
	$copyright_bg_color   = avata_option('copyright_bg_color');
	
	$css .= "footer .sub-footer{background-color:".$copyright_bg_color.";}";
	$css .= "footer .sub-footer,footer .sub-footer i,footer .sub-footer li{color:".$copyright_font_color .";}";
	
	$nav_css3_border_color = avata_option("nav_css3_border_color");
	
	$css .=  "
	.dotstyle-fillup li a,
	.dotstyle-fillin li a,
	.dotstyle-circlegrow li a,
	.dotstyle-dotstroke li.current a{
	 box-shadow: inset 0 0 0 2px ".$nav_css3_border_color.";
	}
	.dotstyle ul li:before,
	.dotstyle ul li:before,
	.dotstyle ul:before,
	.dotstyle ul:after{
		border-color:".$nav_css3_border_color.";
		}
	.dotstyle-stroke li.current a,
	.dotstyle-smalldotstroke li.current {
    box-shadow: 0 0 0 2px ".$nav_css3_border_color.";
}
	.dotstyle-puff li a:hover, .dotstyle-puff li a:focus, .dotstyle-puff li.current a {
    border-color: ".$nav_css3_border_color.";
}
.dotstyle-hop li a {
    border: 2px solid ".$nav_css3_border_color.";
}
.dotstyle-stroke li.active a {
    box-shadow: 0 0 0 2px ".$nav_css3_border_color.";
}";
	
	$nav_css3_color = avata_option("nav_css3_color");
	
	$css .=  ".dotstyle-fillup li a::after{
	background-color: ".$nav_css3_color.";
	}
	.dotstyle-scaleup li.current a {
    background-color: ".$nav_css3_color.";
}
.dotstyle li a{
	background-color: ".Kirki_Color::get_rgba( $nav_css3_color, '0.3' ).";
	}
.dotstyle-scaleup li a:hover,
.dotstyle-scaleup li a:focus,
.dotstyle-stroke li a:hover,
.dotstyle-stroke li a:focus,
.dotstyle-circlegrow li a::after,
.dotstyle-smalldotstroke li a:hover,
.dotstyle-smalldotstroke li a:focus,
.dotstyle-smalldotstroke li.current a{
	background-color: ".$nav_css3_color.";
}
.dotstyle-fillin li.current a {
    box-shadow: inset 0 0 0 10px ".$nav_css3_color.";
}
.dotstyle-dotstroke li a {
    box-shadow: inset 0 0 0 10px ".Kirki_Color::get_rgba( $nav_css3_color, '0.5' ).";
}
.dotstyle-dotstroke li a:hover,
.dotstyle-dotstroke li a:focus {
	box-shadow: inset 0 0 0 10px ".$nav_css3_color.";
}

.dotstyle-puff li a::after {
    background: ".$nav_css3_color.";
    box-shadow: 0 0 1px ".$nav_css3_color.";
}
.dotstyle-puff li a {
    border: 2px solid ".$nav_css3_color.";
}
.dotstyle-hop li a::after{
	background: ".$nav_css3_color.";
	}";
// primary color
$primary_color = avata_option("primary_color");

if( $primary_color == '#fff' || $primary_color == '#ffffff' ){
	
	$css .=  ".btn-primary {
  		color: #666666;
		}";
	$css .=  ".btn-primary:hover {
  		color: #999;
		}";
	$css .=  ".social-icons li a:hover {
  		color: #999;
		}";
	$css .=  "#hoo-contactForm .btn-submit {
   	 	border-color: #999999;
	}";
	$css .=  "#hoo-contactForm .btn-submit:hover {
		border-color: #999999 !important;
	}";
}
	
$css .=  ".btn-primary {
  background: ".$primary_color.";
  border: 2px solid ".$primary_color.";
}
.btn-primary:hover, .btn-primary:focus, .btn-primary:active {
  background: ".$primary_color." !important;
  border-color: ".$primary_color." !important;
}
.btn-primary.btn-outline {
  color: ".$primary_color.";
  border: 2px solid ".$primary_color.";
}
.btn-primary.btn-outline:hover, .btn-primary.btn-outline:focus, .btn-primary.btn-outline:active {
  background: ".$primary_color.";
}
.btn-success {
  background: ".$primary_color.";
  border: 2px solid ".$primary_color.";
}
.btn-success.btn-outline {
  color: ".$primary_color.";
  border: 2px solid ".$primary_color.";
}
.btn-success.btn-outline:hover, .btn-success.btn-outline:focus, .btn-success.btn-outline:active {
  background: ".$primary_color.";
}
.btn-info {
  background: ".$primary_color.";
  border: 2px solid ".$primary_color.";
}
.btn-info:hover, .btn-info:focus, .btn-info:active {
  background: ".$primary_color." !important;
  border-color: ".$primary_color." !important;
}
.btn-info.btn-outline {
  color: ".$primary_color.";
  border: 2px solid ".$primary_color.";
}
.btn-info.btn-outline:hover, .btn-info.btn-outline:focus, .btn-info.btn-outline:active {
  background: ".$primary_color.";
}
.lnk-primary {
  color: ".$primary_color.";
}
.lnk-primary:hover, .lnk-primary:focus, .lnk-primary:active {
  color: ".$primary_color.";
}
.lnk-success {
  color: ".$primary_color.";
}
.lnk-info {
  color: ".$primary_color.";
}
.lnk-info:hover, .lnk-info:focus, .lnk-info:active {
  color: ".$primary_color.";
}
.avata-blog-style-1 .avata-post .avata-post-image .avata-category > a:hover {
  background: ".$primary_color.";
  border: 1px solid ".$primary_color.";
}
.avata-blog-style-1 .avata-post .avata-post-text h3 a:hover {
  color: ".$primary_color.";
}
.avata-blog-style-2 .link-block:hover h3 {
  color: ".$primary_color.";
}
.avata-team-style-2 .avata-social li a:hover {
  color: ".$primary_color.";
}
.avata-team-style-3 .person .social-circle li a:hover {
  color: ".$primary_color.";
}
.avata-testimonial-style-1 .box-testimonial blockquote .quote {
  color: ".$primary_color.";
}
.avata-pricing-style-1 .avata-price {
  color: ".$primary_color.";
}

.avata-pricing-style-1 .avata-currency {
  color: ".$primary_color." !important;
}
.avata-pricing-style-1 .avata-pricing-item.pricing-feature {
  border-top: 10px solid ".$primary_color.";
}
.avata-pricing-style-2 {
  background: ".$primary_color.";
}
.avata-pricing-style-2 .pricing-price {
  color: ".$primary_color.";
}
.avata-nav-toggle i {
  color: ".$primary_color.";
}
.social-icons a:hover, .footer .footer-share a:hover {
 background-color: ".$primary_color.";
 border-color: ".$primary_color.";
}
.wrap-testimonial .testimonial-slide blockquote:after {
  background: ".$primary_color.";
}
.avata-service-style-1 .avata-feature .avata-icon i {
  color: ".$primary_color.";
}
.avata-features-style-4 {
  background: ".$primary_color.";
}
.avata-features-style-4 .avata-feature-item .avata-feature-text .avata-feature-title .avata-border {
  background: ".$primary_color.";
}
.avata-features-style-5 .icon {
  color: ".$primary_color." !important;
}
.main-nav a:hover {
	color:  ".$primary_color.";
}
.main-nav ul li a:hover {
	color:  ".$primary_color.";
}
.main-nav li.onepress-current-item > a {
	color: ".$primary_color.";
}
.main-nav ul li.current-menu-item > a {
	color: ".$primary_color.";
}

.main-nav > li a.active {
	color: ".$primary_color.";
}
.main-nav.main-nav-mobile li.onepress-current-item > a {
		color: ".$primary_color.";
	}
.footer-widget-area .widget-title:after {
    background: ".$primary_color.";
}
.wrap-testimonial .testimonial-slide span a.twitter {
  color: ".$primary_color.";
}";

$css .=  ".work .overlay {background: ".Kirki_Color::get_rgba( $primary_color, '0.9' ).";}";

$side_nav_padding = avata_option('side_nav_padding');
$css .=  ".dotstyle{
	left: ".$side_nav_padding.";
}
.dotstyle.dotstyle-align-right{
	right: ".$side_nav_padding.";
}
.avata-hero__subtext{
	color: ".$primary_color.";
	}

.main-nav > li.current-menu-item > a,
.main-nav .current-menu-item a,
.main-nav > li > a:hover,
.main-nav > li.active > a,
.main-nav > li.current > a{
	color: ".$primary_color.";
}";
	
	$css        = wp_filter_nohtml_kses($css);
	$css        = apply_filters('avata_custom_css',$css);
	$css        = str_replace('&gt;','>',$css);
	$css        = stripslashes($css);
	wp_add_inline_style( 'avata-main', $css );
	
	$autoscrolling = avata_option('autoscrolling');
	$sticky_header_opacity_frontpage = avata_option('sticky_header_opacity_frontpage');
	
	wp_localize_script( 'avata-main', 'avata_params', array(
			'ajaxurl'  => admin_url('admin-ajax.php'),
			'menu_anchors'  => $anchors,
			'autoscrolling' => $autoscrolling,
			'sticky_header_opacity_frontpage'  => $sticky_header_opacity_frontpage,
		));
}

add_action( 'wp_enqueue_scripts', 'avata_enqueue_scripts' );

// Enqueue backup style
if ( ! function_exists( 'avata_extensions_enqueue' ) ) {
	function avata_extensions_enqueue() {
		global $wp_customize;
		$current_screen = get_current_screen();
		$section_types  = avata_section_types();

		if( $current_screen->id === "widgets" || $current_screen->id === "customize" || isset( $wp_customize ) ) :
			wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/plugins/font-awesome/css/font-awesome.css', array(), '20170730', 'all' );
			wp_enqueue_style( 'avata-extensions-widgets-customizer', get_template_directory_uri() . '/assets/css/widgets-customizer.css', array(), '20170730', 'all' );
			wp_enqueue_script(
				'avata-extensions-widgets-customizer',
				get_template_directory_uri() . '/assets/js/admin/widgets-customizer.js',
				array( 'jquery', 'jquery-ui-sortable', 'jquery-ui-autocomplete', 'wp-color-picker' ),
				'20170730', FALSE
			);
		wp_localize_script( 'avata-extensions-widgets-customizer', 'avata_params', array(
			'ajaxurl'  => admin_url('admin-ajax.php'),
			'i18n_01'  =>  __('Re-order Saved.', 'avata' ),
			'i18n_02' =>__('Are you sure you want to remove this section?', 'avata'),
			'i18n_03' =>__('Remove Section', 'avata'),
			'i18n_04' =>__('Duplicate Section', 'avata'),
			'i18n_05' => sprintf(__('Get the <a href="%s" target="_blank">Pro version</a> of Avata to acquire this feature.', 'avata'),esc_url('https://www.hoothemes.com/themes/avata.html')),
			'section_types' => $section_types
		));
		endif;
	}
}
add_action( 'admin_enqueue_scripts', 'avata_extensions_enqueue' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */

function avata_customize_controls_enqueue(){
	wp_enqueue_script( 'avata_library_customizer', get_template_directory_uri() . '/assets/js/admin/customizer-controls.js', array( 'customize-preview', 'jquery-ui-sortable', 'jquery-ui-autocomplete' ), '1.0.0', true );
	}
add_action( 'customize_controls_init', 'avata_customize_controls_enqueue' );

function avata_customize_preview_enqueue(){
	wp_enqueue_script( 'avata_library_customizer', get_template_directory_uri() . '/assets/js/admin/customizer-preview.js', array( 'jquery' ), '1.0.0', true );
	
	}
add_action( 'customize_preview_init', 'avata_customize_preview_enqueue' );

/**
 * Function to check if WordPress is greater or equal to 4.7
 */
function avata_check_if_wp_greater_than_4_7() {

	$wp_version_nr = get_bloginfo('version');

	if ( function_exists( 'version_compare' ) ) {
		if ( version_compare( $wp_version_nr, '4.7', '>=' ) ) {
			return true;
		}
	}
	return false;

}

/**
 * Get option 
 */
function avata_option($name,$default=''){
	$textdomain = avata_get_option_name();
	$return = Kirki_Values::get_value($textdomain,$name);
	if( !$return && $default)
		$return = $default;
	return $return;
  }

/**
 * Get option saved
 */
function avata_option_saved($name,$default=''){
	global $avata_options;
	if(!$avata_options){
		$textdomain = avata_get_option_name();
		$avata_options = get_option($textdomain);
	}
	if( isset($avata_options[$name]) )
		$return = $avata_options[$name];
	else
		$return = $default;
		
	return $return;
}
/**
 * Save section order
 */
function avata_sortsections(){
	if( isset($_POST['sections']) ):
		$sections = $_POST['sections'];
		update_option('avata_sortsections',$sections);
	endif;
	exit(0);
}

add_action('wp_ajax_sortsections',  'avata_sortsections');
add_action('wp_ajax_nopriv_sortsections', 'avata_sortsections');

/**
 * Get post content css class
 */
function avata_get_sidebar_class( $sidebar = '' ){
	 
	if( $sidebar == 'left' )
		return 'left-aside';
	if( $sidebar == 'right' )
		return 'right-aside';
	if( $sidebar == 'both' )
		return 'both-aside';
	if( $sidebar == 'none' )
		return 'no-aside';
	
	return 'no-aside';
	 
}

/*
 * Get Sidebar
 */
function avata_get_sidebar($sidebar, $template_part)
{
    if ($sidebar == 'left' || $sidebar == 'both') { ?>
        <div class="col-aside-left">
            <aside class="blog-side left text-left">
                <div class="widget-area">
                <?php get_sidebar($template_part.'-left');?>
                </div>
            </aside>
        </div>
    <?php 
    }
    if ($sidebar == 'right' || $sidebar == 'both') { ?>
        <div class="col-aside-right">
            <div class="widget-area">
            <?php get_sidebar($template_part.'-right');?>
            </div>
        </div>
    <?php 
    }
}

/**
 *  Cet excerpt
 */	

function avata_get_excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

/**
 *  Custom comments list
 */	
function avata_comment($comment, $args, $depth) {

?>
   
<li <?php comment_class("comment media-comment"); ?> id="comment-<?php comment_ID() ;?>">
	<div class="media-avatar media-left">
	<?php echo get_avatar($comment,'70','' ); ?>
  </div>
  <div class="media-body">
      <div class="media-inner">
          <h4 class="media-heading clearfix">
             <?php echo get_comment_author_link();?> - <?php comment_date(); ?> <?php edit_comment_link(__('(Edit)','avata'),'  ','') ;?>
             <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ;?>
          </h4>
          
          <?php if ($comment->comment_approved == '0') : ?>
                   <em><?php _e('Your comment is awaiting moderation.','avata') ;?></em>
                   <br />
                <?php endif; ?>
                
          <div class="comment-content"><?php comment_text() ;?></div>
      </div>
  </div>
</li>
                                            
<?php
	}


/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function avata_posted_on() {
									
	$return = '';
	$display_post_meta = avata_option('hide_post_meta');
		
	if( $display_post_meta != '1' ){
		
	  $hide_meta_date       = avata_option('hide_meta_date');
	  $hide_meta_author     = avata_option('hide_meta_author');
	  $hide_meta_comments   = avata_option('hide_meta_comments');
	  
		
	   $return .=  '<ul class="entry-meta">';
	  if( $hide_meta_date != '1' )
		$return .=  '<li class="entry-date"><i class="fa fa-calendar"></i>'. get_the_date(  ).'</li>';
	  if( $hide_meta_author != '1' )
		$return .=  '<li class="entry-author"><i class="fa fa-user"></i>'.get_the_author_link().'</li>';
	  //if( $hide_meta_categories != '1' )		
		//$return .=  '<li class="entry-catagory"><i class="fa fa-file-o"></i>'.get_the_category_list(', ').'</li>';
	  if( $hide_meta_comments != '1' )	
		$return .=  '<li class="entry-comments pull-right">'.avata_get_comments_popup_link('', __( '<i class="fa fa-comment"></i> 1 ', 'avata'), __( '<i class="fa fa-comment"></i> % ', 'avata'), 'read-comments', '').'</li>';
        $return .=  '</ul>';
	}

	return $return;

}

/**
 * Modifies WordPress's built-in comments_popup_link() function to return a string instead of echo comment results
 */
function avata_get_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
	
    global $wpcommentspopupfile, $wpcommentsjavascript;
 
    $id = get_the_ID();
 
    if ( false === $zero ) $zero = __( 'No Comments', 'avata');
    if ( false === $one ) $one = __( '1 Comment', 'avata');
    if ( false === $more ) $more = __( '% Comments', 'avata');
    if ( false === $none ) $none = __( 'Comments Off', 'avata');
 
    $number = get_comments_number( $id );
    $str = '';
 
    if ( 0 == $number && !comments_open() && !pings_open() ) {
        $str = '<span' . ((!empty($css_class)) ? ' class="' . esc_attr( $css_class ) . '"' : '') . '>' . $none . '</span>';
        return $str;
    }
 
    if ( post_password_required() ) {
     
        return '';
    }
	
    $str = '<a href="';
    if ( $wpcommentsjavascript ) {
        if ( empty( $wpcommentspopupfile ) )
            $home = home_url();
        else
            $home = get_option('siteurl');
        $str .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
        $str .= '" onclick="wpopen(this.href); return false"';
    } else { // if comments_popup_script() is not in the template, display simple comment link
        if ( 0 == $number )
            $str .= get_permalink() . '#respond';
        else
            $str .= get_comments_link();
        $str .= '"';
    }
 
    if ( !empty( $css_class ) ) {
        $str .= ' class="'.$css_class.'" ';
    }
    $title = the_title_attribute( array('echo' => 0 ) );
 
    $str .= apply_filters( 'comments_popup_link_attributes', '' );
 
    $str .= ' title="' . esc_attr( sprintf( __('Comment on %s', 'avata'), $title ) ) . '">';
    $str .= avata_get_comments_number_str( $zero, $one, $more );
    $str .= '</a>';
     
    return $str;
}

/**
 * Modifies WordPress's built-in comments_number() function to return string instead of echo
 */
function avata_get_comments_number_str( $zero = false, $one = false, $more = false, $deprecated = '' ) {
	
    if ( !empty( $deprecated ) )
        _deprecated_argument( __FUNCTION__, '1.3' );
 
    $number = get_comments_number();
 
    if ( $number > 1 )
        $output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', 'avata') : $more);
    elseif ( $number == 0 )
        $output = ( false === $zero ) ? __('No Comments', 'avata') : $zero;
    else // must be one
        $output = ( false === $one ) ? __('1 Comment', 'avata') : $one;
 
    return apply_filters('comments_number', $output, $number);
}

 // Code before </head>
	
 function avata_space_before_head(){
	 
   $space_before_head = avata_option('header_code');
   echo $space_before_head;
   
 } 

add_action('wp_head', 'avata_space_before_head'); 


 // Code before </body>
	
 function avata_space_before_body(){
	 
   $space_before_body = avata_option('footer_code');
   echo $space_before_body;
   
 } 

add_action('wp_footer', 'avata_space_before_body'); 

/**
* Get sections
*/
function avata_get_sections(){
	global $avata_lite_sections;
	$sortsections_saved  = avata_option('section_order');
	$avata_sections = array();
	if( $sortsections_saved!='' ){
		$sortsections_saved = @json_decode($sortsections_saved, true);
		if( is_array($sortsections_saved) ){
			foreach( $sortsections_saved as $k=>$sortsection ){
				if(isset($avata_lite_sections[$sortsection])){
					$avata_sections[$sortsection] = $avata_lite_sections[$sortsection];
				}
			}
		
			$avata_sections = array_merge($avata_sections,$avata_lite_sections);
		}else{
			$avata_sections = 	$avata_lite_sections;
		}
	
	}else{
		$avata_sections = 	$avata_lite_sections;
	}
	return $avata_sections;
	}

/*
*  Allow tags
*/
add_action('init', 'avata_html_tags_code', 10);
function avata_html_tags_code() {
	
	global $allowedposttags;
	
	$allowed_atts = array(
		'align'      => array(),
		'class'      => array(),
		'type'       => array(),
		'id'         => array(),
		'dir'        => array(),
		'lang'       => array(),
		'style'      => array(),
		'xml:lang'   => array(),
		'src'        => array(),
		'alt'        => array(),
		'href'       => array(),
		'rel'        => array(),
		'rev'        => array(),
		'target'     => array(),
		'novalidate' => array(),
		'type'       => array(),
		'value'      => array(),
		'name'       => array(),
		'tabindex'   => array(),
		'action'     => array(),
		'method'     => array(),
		'for'        => array(),
		'width'      => array(),
		'height'     => array(),
		'data'       => array(),
		'title'      => array(),
	);
	$allowedposttags['form']     = $allowed_atts;
    $allowedposttags["script"] = array("src" => array(),"name" => array(),"id" => array(),"type" => array());
	$allowedposttags['iframe'] = array (
		'align'       => true,
		'frameborder' => true,
		'height'      => true,
		'width'       => true,
		'sandbox'     => true,
		'seamless'    => true,
		'scrolling'   => true,
		'srcdoc'      => true,
		'src'         => true,
		'class'       => true,
		'id'          => true,
		'style'       => true,
		'border'      => true,
	);
	
	$allowedposttags["object"] = array("height" => array(), "width" => array());
	$allowedposttags["param"] = array("name" => array(), "value" => array());
	
	$allowedposttags["embed"] = array(
		"src" => array(),
		"type" => array(),
		"allowfullscreen" => array(),
		"allowscriptaccess" => array(),
		"height" => array(),
		"width" => array()
		);
    $allowedposttags["style"] = array("type" => array());
	$allowedposttags["link"] = array("rel" => array(),"href" => array(),"id" => array(),"type" => array(),"media" => array());
	$allowedposttags["input"] = array("name" => array(),"id" => array(),"value" => array(),"class" => array(),"placeholder" => array(),"required" => array(),"type" => array(),'aria-required' => array());
	$allowedposttags["select"] = array("name" => array(),"id" => array(),"value" => array(),"class" => array(),"required" => array(),"type" => array(),'aria-required' => array());
	$allowedposttags["textarea"] = array("name" => array(),"id" => array(),"value" => array(),"class" => array(),"placeholder" => array(),"required" => array(),"type" => array(),'aria-required' => array());
}


/**
* Standard fonts
*/
function avata_standard_fonts(){
	$standard_fonts = array(
			
			'arial' => array(
				'label' => 'Arial',
				'stack' => 'Arial, sans-serif',
			),
			'avant-garde' => array(
				'label' => 'Avant Garde',
				'stack' => '"Avant Garde", sans-serif',
			),
			'arial' => array(
				'label' => 'Arial',
				'stack' => 'Arial, sans-serif',
			),
			
			'arial' => array(
				'label' => 'Arial',
				'stack' => 'Arial, sans-serif',
			),
			'cambria' => array(
				'label'  => 'Cambria',
				'stack'  => 'Cambria, Georgia, serif',
			),
			'calibri' => array(
				'label' => 'Calibri',
				'stack' => 'Calibri,sans-serif',
			),
			'copse' => array(
				'label' => 'Copse',
				'stack' => 'Copse, sans-serif',
			),
			'garamond' => array(
				'label' => 'Garamond',
				'stack' => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
			),
			'georgia' => array(
				'label' => 'Georgia',
				'stack' => 'Georgia, serif',
			),
			'helvetica-neue' => array(
				'label' => 'Helvetica Neue',
				'stack' => '"Helvetica Neue", Helvetica, sans-serif',
			),
			'lustria' => array(
				'label' => 'Lustria',
				'stack' => 'Lustria,serif',
			),
			'open-sans' => array(
				'label' => 'Open Sans',
				'stack' => 'Open Sans, sans-serif',
			),
			'tahoma' => array(
				'label' => 'Tahoma',
				'stack' => 'Tahoma, Geneva, sans-serif',
			),
			
		);
	return $standard_fonts;	
	}
		
add_filter( 'kirki/fonts/standard_fonts', 'avata_standard_fonts' );

require_once dirname( __FILE__ ) . '/lib/kirki/kirki.php';
require_once dirname( __FILE__ ) . '/includes/options.php';
require_once dirname( __FILE__ ) . '/includes/customizer.php';
require_once dirname( __FILE__ ) . '/includes/breadcrumbs.php';
require_once dirname( __FILE__ ) . '/includes/template-parts.php';
require_once dirname( __FILE__ ) . '/includes/theme-widgets.php';


/**
 * Include the TGM_Plugin_Activation class.
 */
load_template( trailingslashit( get_template_directory() ) . 'includes/class-tgm-plugin-activation.php' );


add_action( 'tgmpa_register', 'avata_theme_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 */
function avata_theme_register_required_plugins() {

    $plugins = array(
		array(
			'name'     				=> __('Hoo Contact Form','avata'), // The plugin name
			'slug'     				=> 'avata-hoo-contact-form', // The plugin slug (typically the folder name)
			'source'   				=> esc_url('https://downloads.wordpress.org/plugin/hoo-contact-form.zip'), // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		
	);

    /**
     * Array of configuration settings. Amend each line as needed.
     */
    $config = array(
        'id'           => 'avata-hoo-contact-form',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
      
    );

    tgmpa( $plugins, $config );

}