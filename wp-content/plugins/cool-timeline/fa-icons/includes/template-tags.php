<?php  

if( ! function_exists( 'get_fa' ) ) {

	function get_fa( $format = false, $post_id = null ) {
		if ( ! $post_id ) {
			global $post;
			if ( ! is_object( $post ) ) {
				return;
			}
			$post_id = $post->ID;
		}
		$icon = get_post_meta( $post_id, 'fa_field_icon', true );
		if ( ! $icon ) {
			return;
		}
		if ( $format ) {
			$output = '<i class="fa ' . $icon . '"></i>';
		} else {
			$output = $icon;
		}
		return $output;
	}

}

if( ! function_exists( 'the_fa' ) ) {

	function the_fa( $format = false, $post_id = null ) {
		echo get_fa( $format, $post_id );
	}

}
?>