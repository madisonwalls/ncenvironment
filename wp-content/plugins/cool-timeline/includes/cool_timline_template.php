<?php

if (!class_exists('CoolTimeline_Template')) {

    class CoolTimeline_Template {

        /**
         * The Constructor
         */
        public function __construct() {
            // register actions
			add_action('init', array(&$this, 'cooltimeline_register_shortcode'));
            add_action('wp_enqueue_scripts', array(&$this, 'ctl_load_scripts_styles'));
			
			// Call actions and filters in after_setup_theme hook
			add_action( 'after_setup_theme',array(&$this, 'ctl_crm'),999 );

			add_filter('excerpt_length', array(&$this, 'ctl_f_custom_excerpt_length'), 999);
        }
		
		function ctl_crm() {
		   // add more link to excerpt
		   function ctl_f_custom_excerpt_length($more) {
			  global $post;
			   $ctl_options_arr = get_option('cool_timeline_options');
				if ($post->post_type == 'cool_timeline' && !is_single() ){
					 if( $ctl_options_arr['display_readmore']=='yes'){
							 return '..<a class="read_more ctl_read_more" href="'. get_permalink($post->ID) . '">'. __('Read More', 'cool-timeline') .'</a>';
					   }  
				 }else{
				  	return $more;
				 }
			}
			add_filter('excerpt_more', 'ctl_f_custom_excerpt_length', 999);
		}
		function ctl_f_custom_excerpt_length( $length ) {
			global $post;
			$ctl_options_arr = get_option('cool_timeline_options');
			$ctl_content_length = $ctl_options_arr['content_length']?$ctl_options_arr['content_length']:100;
			if ($post->post_type == 'cool_timeline' && !is_single() ){
				return $ctl_content_length;
				}
			return $length;
		}
		
        function cooltimeline_register_shortcode() {
            add_shortcode('cool-timeline', array(&$this, 'cooltimeline_view'));
		 }
	    function cooltimeline_view($atts, $content = null) {
			
			wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
			wp_enqueue_style('ctl_styles');
			wp_enqueue_script('ctl_viewportchecker');
			wp_enqueue_style('ctl_animate');
			wp_enqueue_style('ctl_prettyPhoto');

			wp_enqueue_style('ctl_gfonts');
			wp_enqueue_style('ctl_default_fonts');

            wp_enqueue_script('ctl_prettyPhoto');
			
		$attribute = shortcode_atts(array(
                'class' => 'caption',
                'post_per_page' => 10,
				'layout'=>'',
				'animation'=>'',
				'date-format'=>'',
				'icons'=>'',
				'show-posts'=>'',
                    ), $atts);
			$ctl_options_arr = get_option('cool_timeline_options');
			
		if($attribute['layout'] == "compact"){
				wp_enqueue_script('c_masonry');
			  wp_add_inline_script( 'c_masonry',"
			  	( function($) {

			  $(window).load(function(){ 
			   // masonry plugin call
			$('.compact-wrapper .cooltimeline_cont').masonry({itemSelector : '.timeline-mansory'});

			$('.compact-wrapper .cooltimeline_cont').find('.timeline-mansory').each(function(index){
				var firstPos=$(this).position();
				if($(this).next('.timeline-post').length>0){
						var secondPos=$(this).next().position();
						var gap=secondPos.top-firstPos.top;
						 new_pos=secondPos.top+70;
							if(gap<=35){
						$(this).next().css({'top':new_pos+'px','margin-top':'0'});
							}
					}


			var leftPos=$(this).position();
				if(leftPos.left<=0){
					$(this).addClass('ctl-left');
				}else{
					$(this).addClass('ctl-right');	
				}
			});
	});})(jQuery);
	");
			}

			wp_enqueue_script('ctl_scripts');
		
			$wrp_cls = 'white-timeline';
			$post_skin_cls = 'light-grey-post';
			$wrapper_cls = 'white-timeline-wrapper';
			
			$output='';
			$ctl_html='';
			$ctl_avtar_html='';
			 /*
             * Gerneral options
             */
		if ($attribute['layout'] == "one-side") {
		    $layout_cls = 'one-sided';
		    $layout_wrp = 'one-sided-wrapper';
		}elseif ($attribute['layout'] == "compact"){
			 $layout_cls = 'compact';
		    $layout_wrp = 'compact-wrapper';
		}  else {
		    $layout_cls = '';
		    $layout_wrp = 'both-sided-wrapper';
		}


          //  $ctl_timeline_type = $ctl_options_arr['timeline_type'];
            $ctl_title_text =isset($ctl_options_arr['title_text'])?$ctl_options_arr['title_text']:'';
            $ctl_title_tag = $ctl_options_arr['title_tag'];
          //  $ctl_title_pos = $ctl_options_arr['title_pos'];
        	
				if(isset($ctl_options_arr['user_avatar']['id'])){
					$user_avatar =wp_get_attachment_image_src($ctl_options_arr['user_avatar']['id'],'ctl_avatar');
					}
			
			/*
			* content settings
			*/
	
            $ctl_post_per_page = $ctl_options_arr['post_per_page'];
			$story_desc_type = $ctl_options_arr['desc_type'];
			$ctl_no_posts= isset($ctl_options_arr['no_posts'])?$ctl_options_arr['no_posts']:"No timeline post found";
			$ctl_content_length = $ctl_options_arr['content_length'];
			$ctl_posts_orders = $ctl_options_arr['posts_orders']?$ctl_options_arr['posts_orders']:"DESC";
			$disable_months =isset($ctl_options_arr['disable_months'])?$ctl_options_arr['disable_months']:"no";
			$title_alignment = $ctl_options_arr['title_alignment']?$ctl_options_arr['title_alignment']:"center";
		
			//$ctl_posts_order='date';
         
            /*
             * images sizes
             */
        
			
            $ctl_post_per_page=$ctl_post_per_page ? $ctl_post_per_page : 10;
            $ctl_title_text = $ctl_title_text ? $ctl_title_text : 'Timeline';
            $ctl_title_tag = $ctl_title_tag ? $ctl_title_tag : 'H2';
            //$ctl_title_pos = $ctl_title_pos ? $ctl_title_pos : 'left';
            $ctl_content_length ? $ctl_content_length : 100;
			

			$display_year = '';
			if($attribute['date-format']){
				$df=$attribute['date-format'];
				if($attribute['date-format']=="default"){
                $p_format =__('F j','cool-timeline');
				}else{
				 $p_format =__("$df",'cool_timeline');
				}
		 }else{
 				$p_format =__('F j','cool-timeline');
			}
			$format =__('d/M/Y','cool-timeline');
			$wrp_cls='';
			
			if($attribute['layout']){
			$wrp_cls=$attribute['layout'];
			}else{
			 $wrp_cls='default-layout';
			}
			if($attribute['icons']=="YES"){
			$clt_icons="icons_yes";
			}else{
			 $clt_icons="icons_no";
			}
			
			$ctl_format_html='';
			$ctl_html_no_cont='';
			$output='';
            $year_position = 2;
			$ctl_animation='';
			
			 if (isset($attribute['animation'])) {
                    $ctl_animation=$attribute['animation'];
                }else{
                  $ctl_animation ='bounceInUp';
                     }
			
           $args = array(
		   'post_type' => 'cool_timeline', 
		   'posts_per_page' => $ctl_post_per_page,
		   'post_status' => array( 'publish', 'future' ),
		   'orderby' => 'date',
		   'order' =>$ctl_posts_orders
		   );
		   
		   if ($attribute['show-posts']) {
			$args['posts_per_page'] = $attribute['show-posts'];
			} else {
				$args['posts_per_page'] = $ctl_post_per_page;
			}
			$args['paged']= (get_query_var('paged')) ? get_query_var('paged') : 1;
			$paged=$args['paged'];
			
			$i = 0;
			$layout=$attribute['layout'];
				$st_cls='';
			  $ctl_loop = new WP_Query($args);

            if ($ctl_loop->have_posts()){
				
                while ($ctl_loop->have_posts()) : $ctl_loop->the_post();
				$p_id=get_the_ID();
                $img_cont_size = get_post_meta(get_the_ID(), 'image_container_type', true);
				global $post;
						switch ($img_cont_size) {
                        case'Full':
                            $cont_size_cls = 'full';
							break;
				
                        case'Small':
                            $cont_size_cls = 'small';
							break;
                        default;
                            $cont_size_cls = 'full';
							break;
                    }	
					
						 if (isset($cont_size_cls) && !empty($cont_size_cls)) {
                        $container_cls = $cont_size_cls;
                    } else {
							 $container_cls ='full';
                    }
						/*
                         * Display By date
                         */
                        $post_date = explode('/', get_the_date($format));
                       
                    	if(in_array($layout,array("simple","compact"),TRUE)!=true){
                        $post_year = $post_date[$year_position];
                        if ($post_year != $display_year) {
                         $display_year = $post_year;
							$ctle_year_lbl = sprintf('<span class="ctl-timeline-date">%s</span>', $post_year);
							$ctl_html .= '<div  class="timeline-year scrollable-section "
							data-section-title="' . $post_year . '" id="clt-' . $post_year . '">
							<div class="icon-placeholder">' . $ctle_year_lbl . '</div>
							<div class="timeline-bar"></div>
							</div>';
							}
						}
						
					if($story_desc_type=='full'){
						$story_cont = get_the_content();
					}else{
						$story_cont =get_the_excerpt();
					}

					if ( '' != $story_cont ) {
						 $post_content= $story_cont;
					}else{
					 $post_content="";
					}
				 if ($i % 2 == 0) {
					$even_odd = "even";
					} else {
					$even_odd = "odd";
					}
					
					$posted_date=get_the_date(__($p_format,'cool-timeline'));
					
					   if($cont_size_cls=="full"){
					$ctl_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'large');
					}else{
					$ctl_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'medium');
					}
			
                    $ctl_thumb_url = $ctl_thumb['0'];
                    $ctl_thumb_width = $ctl_thumb['1'];
                    $ctl_thumb_height = $ctl_thumb['2'];
						if($layout !="simple"){
							$st_cls='simple-layout';
						}else{
							$st_cls='default-layout';
						}

						$compt_cls=$layout=="compact"?"timeline-mansory":'';
				$ctl_html .='<!-- .timeline-post-start-->';
				$ctl_html .='<div id="story-'.$p_id.'" class="timeline-post ' . $even_odd . ' ' . $post_skin_cls .' '.$clt_icons .' post-'.$p_id.' '.$compt_cls.'">';
				if($layout!="compact"){
				$ctl_html .='<div class="timeline-meta">';
				if($disable_months=="no"){
					$ctl_html .= '<div class="meta-details">' . $posted_date . '</div>';
				} 
				$ctl_html .= '</div>';
				}
				
				if(function_exists('get_fa')){
        $post_icon=get_fa(true);
		}
        if(isset($post_icon)){
            $icon=$post_icon;
        }else{
           $icon = '<i class="fa fa-clock-o" aria-hidden="true"></i>';
         }
		 
  if (isset($attribute['icons']) && $attribute['icons'] == "YES") {

			$ctl_html .='<div class="timeline-icon icon-larger iconbg-turqoise icon-color-white">
                    	<div class="icon-placeholder">'.$icon.'</div>
                        <div class="timeline-bar"></div>
                    </div>';
		}else {
			$ctl_html .= '<div class="timeline-icon icon-dot-full">
					<div class="timeline-bar"></div>
					</div>';
			}
	 $ctl_html .= '<div class="timeline-content  clearfix ' . $even_odd . '  ' . $container_cls .'">';

	 if($layout =="compact"){
	 if($disable_months=="no"){
		$ctl_html .= '<h2 class="content-title">' . $posted_date . '</h2>';
				} 
		}else{
		     $ctl_html .= '<h2 class="content-title">' . get_the_title() . '</h2>';
 		}	
    $ctl_html .= '<div class="ctl_info event-description ' . $cont_size_cls . '">';
     
	 if (isset($ctl_thumb_url) && !empty($ctl_thumb_url)) {
			$img_f_url = wp_get_attachment_url(get_post_thumbnail_id($p_id));

            $story_img_link = '<a title="' . get_the_title() . '"  href="' . $img_f_url . '" class="ctl_prettyPhoto">';
            $s_l_close='</a>';
		 
			if ($cont_size_cls == "full") {
				$ctl_format_html .= '<div class="full-width">'. $story_img_link.'<img  class="story-img" src="' . $ctl_thumb_url . '">'.$s_l_close.'</div>';
				} else {
					$s_img_w = $ctl_thumb_width / 2;
					$s_img_h = $ctl_thumb_height / 2;
					$ctl_format_html .= '<div class="pull-left">'.$story_img_link.'<img  width="' . $s_img_w . '" height="' . $s_img_h . '" class="story-img left_small" src="' . $ctl_thumb_url . '">'.$s_l_close.'</div>';

                }

            }
	$ctl_html .=$ctl_format_html;
	 
	 $ctl_html .= '<div class="content-details">';

	 if($layout =="compact"){
	 $ctl_html .= '<h3 class="content-title-cmt">'.get_the_title().'</h3>';
		}
	 $ctl_html .=$post_content.' </div>';
	 $ctl_html .= '</div>'; 
	 $ctl_html .= '</div><!-- timeline content -->
	</div><!-- .timeline-post-end -->';
		$ctl_format_html = '';
        $post_content = '';
		$i++;		
	endwhile;
    wp_reset_postdata();
	} else {
		$ctl_html_no_cont .= '<div class="no-content"><h4>';
		//$ctl_html_no_cont.=$ctl_no_posts;
		$ctl_html_no_cont .= __('Sorry,You have not added any story yet', 'cool-timeline');
		$ctl_html_no_cont .= '</h4></div>';
	}
	
	
		$timeline_id="ctl-free-one";	
		$output .='<! ========= Cool Timeline Free '. COOL_TIMELINE_VERSION_CURRENT .' =========>';

		$output .= '<div class="cool_timeline cool-timeline-wrapper  ' . $layout_wrp . ' ' . $wrapper_cls .'">';
		if (isset($user_avatar[0]) && !empty($user_avatar[0])) {
					$ctl_avtar_html .= '<div class="avatar_container row"><span title="' . $ctl_title_text . '"><img  class=" center-block img-responsive img-circle" alt="' . $ctl_title_text . '" src="' . $user_avatar[0] . '"></span></div> ';
				}
			  //  if ($title_visibilty == "yes") {
                $output .= sprintf(__('<%s class="timeline-main-title center-block">%s</%s>', 'cool-timeline'), $ctl_title_tag, $ctl_title_text, $ctl_title_tag);
            //}	
				$output .= $ctl_avtar_html;
			$output .= '<div class="cool-timeline white-timeline ultimate-style ' . $layout_wrp . ' ' . $wrp_cls.
			' ' .$layout_cls.'">';
			$output .= '<div data-animations="'.$ctl_animation.'"  id="' . $timeline_id . '" class="cooltimeline_cont  clearfix '.$clt_icons.'">';
			if($layout=="compact"){
				$output .='<div class="center-line">
            </div>';
			}
			$output .= $ctl_html;
            $output .= $ctl_html_no_cont;
            $output .= '</div>';

		$output .= '<div class="clearfix"></div>';
		//if ($enable_pagination == "yes") {
		$output .=clt_pagination($ctl_loop->max_num_pages, "", $paged);
		//}
		$output .=' </div></div>  <!-- end
 ================================================== -->';
            return $output ;
		}


		/*
		* Include this plugin's public JS & CSS files on posts.
		*/
		
     
        function ctl_load_scripts_styles() {
			/*
			 * google fonts
			 */
			
			$ctl_options_arr = get_option('cool_timeline_options');
		
			$post_content_face=$ctl_options_arr['post_content_typo']['face'];
			$post_title=$ctl_options_arr['post_title_typo']['face'];
			$main_title=$ctl_options_arr['main_title_typo']['face'];
			$selected_fonts = array($post_content_face,$post_title,$main_title);
			 /*
            * google fonts
            */
            // Remove any duplicates in the list
            $selected_fonts = array_unique($selected_fonts);
            // If it is a Google font, go ahead and call the function to enqueue it
            $gfont_arr=array();

        if(is_array($selected_fonts)){

            foreach ($selected_fonts as $font) {
                if ($font && $font != 'inherit') {
                    if ($font == 'Raleway')
                        $font = 'Raleway:100';
                    $font = str_replace(" ", "+", $font);
                     $gfont_arr[]=$font;
                }
            }
           if(is_array($gfont_arr)){
             $allfonts=implode("|",$gfont_arr);
              }
           wp_register_style("ctl_gfonts", "https://fonts.googleapis.com/css?family=$allfonts", false, null, 'all');
          }
            wp_register_style("ctl_default_fonts", "https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800", false, null, 'all');
		
			/*
			 * End
			 * 
			 */
				
		
			wp_register_style('ctl_styles', COOL_TIMELINE_PLUGIN_URL . 'css/ctl_styles.css',null, null,'all' );
			
			wp_register_style('ctl_animate', COOL_TIMELINE_PLUGIN_URL . 'css/animate.min.css', null, null, 'all');
			wp_register_script('ctl_viewportchecker', COOL_TIMELINE_PLUGIN_URL . 'js/jquery.viewportchecker.js', array('jquery'), null, true);
		   
		    wp_register_style('ctl_prettyPhoto', COOL_TIMELINE_PLUGIN_URL . 'css/prettyPhoto.css', null, null, 'all');
            wp_register_script('ctl_prettyPhoto', COOL_TIMELINE_PLUGIN_URL . 'js/jquery.prettyPhoto.js', array('jquery'), null, true);
        
			wp_register_script('ctl_scripts', COOL_TIMELINE_PLUGIN_URL . 'js/ctl_scripts.js', array('jquery'), null, true);
         	wp_register_script('c_masonry', COOL_TIMELINE_PLUGIN_URL . 'js/masonry.pkgd.min.js', array('jquery'), null, true);
         	
         	}

	
    }

} // end class


