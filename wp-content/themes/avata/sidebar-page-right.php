<?php
    global  $avata_page_meta;
	
	$right_sidebar = avata_option('right_sidebar_pages');
	$right_sidebar = (isset($avata_page_meta->right_sidebar) && $avata_page_meta->right_sidebar!="")?$avata_page_meta->right_sidebar:$right_sidebar;
	
	 if ( $right_sidebar!='0' && $right_sidebar !='' && is_active_sidebar( $right_sidebar ) ){
		dynamic_sidebar( $right_sidebar );
	 }