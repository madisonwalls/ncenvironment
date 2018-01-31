<?php
    global  $avata_page_meta;
	
	$left_sidebar = avata_option('left_sidebar_archive');
	$left_sidebar = (isset($avata_page_meta->left_sidebar) && $avata_page_meta->left_sidebar!="")?$avata_page_meta->left_sidebar:$left_sidebar;
	
	 if ( $left_sidebar!='0' && $left_sidebar !='' && is_active_sidebar( $left_sidebar ) ){
		dynamic_sidebar( $left_sidebar );
	 }