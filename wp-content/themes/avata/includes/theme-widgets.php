<?php
// global $wp_registered_sidebars;
#########################################
function avata_widgets_init() {
		global $avata_sidebars;
		/* Register sidebars */
		$extra_class = 'avata-sidebar-widgets widget widget-box';
		foreach ( $avata_sidebars as $k => $v ):
			if( $k!='0' && $k !='' )
			register_sidebar(
				array (
					'name'          => $v,
					'id'            => $k,
					'before_widget' => '<div id="%1$s" class="'.$extra_class.' %2$s">',
					'after_widget' => '<span class="seperator extralight-border"></span></div>', 
					'before_title' => '<h3 class="widget-title">', 
					'after_title' => '</h3>' 
				)
			);
			
		endforeach;
	
		
		register_sidebar(array(
			'name' => __('Footer Area One', 'avata'),
			'id'   => 'footer-1',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>' 
			));
		register_sidebar(array(
			'name' => __('Footer Area Two', 'avata'),
			'id'   => 'footer-2',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>' 
			));
		register_sidebar(array(
			'name' => __('Footer Area Three', 'avata'),
			'id'   => 'footer-3',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>' 
			));
		register_sidebar(array(
			'name' => __('Footer Area Four', 'avata'),
			'id'   => 'footer-4',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>' 
			));
			

}
add_action( 'widgets_init', 'avata_widgets_init' );

/**
 * widgets scripts

 */

add_action( 'load-widgets.php', 'singlepag_widgets_load' );

function singlepag_widgets_load() {    
	wp_enqueue_style( 'wp-color-picker' );        
	wp_enqueue_script( 'wp-color-picker' );    
}
