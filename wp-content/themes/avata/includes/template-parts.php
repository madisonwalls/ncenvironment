<?php

/**
 * Main header template
 */

function avata_main_header(){
global $avata_header;

$custom_logo_id = get_theme_mod('custom_logo');
$image          = wp_get_attachment_image_src($custom_logo_id , 'full');
$logo           =  $image[0];

$header_class  = 'main-header normal-header';

$html = '<header id="main-header" class="'.$header_class.'">
<div class="container">
  <div class="site-branding">
    <div class="site-brand-inner has-logo-img no-desc">
      <div class="site-logo-div">';
      
if ( $logo!="") { 
	$html .= '<a class="custom-logo-link"  rel="home" itemprop="url" href="'.esc_url(home_url('/')).'"> <img src="'.esc_url($logo).'" class="site-logo" alt="'.get_bloginfo('name').'" /> </a>';
 } 

$html .= '<div class="name-box">
<a href="'.esc_url(home_url('/')).'">
  <h1 class="site-name">' .get_bloginfo('name').'</h1>
  </a> <span class="site-tagline">
  '.get_bloginfo('description').'
  </span> </div>
      </div>
    </div>
  </div>
  <div class="header-right-wrapper">
    <nav id="site-navigation" class="main-navigation" role="navigation"> 
	'. wp_nav_menu(array('theme_location'=>'primary','depth'=>0,'echo' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>')).'
	</nav>
    <!-- #site-navigation --> 
  </div>
</div></header>';
echo $html;
			
}
add_action('avata_main__header','avata_main_header');

/**
 * Main header template
 */

function avata_featured_header(){
	
global $avata_header;

$custom_logo_id = get_theme_mod('custom_logo');
$image          = wp_get_attachment_image_src($custom_logo_id , 'full');
$logo           =  $image[0];
$sticky_header  = esc_attr( avata_option( 'sticky_header_frontpage'));

$header_class  = 'main-header homepage-header';
$theme_location = 'primary';
if (has_nav_menu('home')){
	$theme_location = 'home';
}

if($sticky_header=='1'){
	$header_class .= ' fixed';
}	

$html = '<header id="main-header" class="'.$header_class.'">
<div class="container">
  <div class="site-branding">
    <div class="site-brand-inner has-logo-img no-desc">
      <div class="site-logo-div">';
      
if ( $logo!="") { 
	$html .= '<a class="custom-logo-link"  rel="home" itemprop="url" href="'.esc_url(home_url('/')).'"> <img src="'.esc_url($logo).'" class="site-logo" alt="'.get_bloginfo('name').'" /> </a>';
 } 

$html .= '<div class="name-box">
<a href="'.esc_url(home_url('/')).'"><h1 class="site-name">' .get_bloginfo('name').'</h1></a>
<span class="site-tagline">
  '.get_bloginfo('description').'
  </span> </div>
      </div>
    </div>
  </div>
  <div class="header-right-wrapper">
    <nav id="site-navigation" class="main-navigation" role="navigation">
	'. wp_nav_menu(array('theme_location'=>''.$theme_location.'','depth'=>0,'echo' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>')).'
	</nav>
    <!-- #site-navigation --> 
  </div>
</div></header>';
echo $html;
			
}
add_action('avata_featured__header','avata_featured_header');

/**
 * Display frontpage sections option in customizer 
 */
function avata_hide_sections(){
	
	global $avata_lite_sections;
	if ( is_customize_preview() ) {
		echo '<div class="hide">';
		foreach( $avata_lite_sections as $k => $v ){
			dynamic_sidebar($k);
		}
	echo '</div>';
	}
	}
	
add_action('avata_after__footer','avata_hide_sections');