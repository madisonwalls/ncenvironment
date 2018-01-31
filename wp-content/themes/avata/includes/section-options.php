<?php

function avata_section_types(){
	$section_types = array(
			'banner_1',
			'banner_2',
			'service_1',
			'video_1',
			'intro_1',
			'gallery',
			'team',
			'testimonial',
			'blog',
			'slogan',
			'progress_bar_1',
			'progress_bar_2',
			'counter',
		);
		return apply_filters('avata_section_types',$section_types);
	}
