<?php

if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) ) :
        get_template_part('index');
	else:
		get_template_part('template','frontpage');
    endif;
  