<?php
 global $allowedposttags, $avata_animation, $avata_animation_delay;
  
  $section_title     = avata_option('section_title_blog');
  $section_subtitle  = avata_option('section_subtitle_blog');
  $posts_num         = avata_option('section_post_num_blog');
  $category          = avata_option('section_category_blog');
  $columns           = intval(avata_option('section_columns_blog'));
  $excerpt_length    = intval(avata_option('section_excerpt_length_blog'));
  $btn_txt           = avata_option('section_btn_txt_blog');
  $btn_link          = avata_option('section_btn_link_blog');
  $btn_target        = avata_option('section_btn_target_blog');
  $fullwidth         =  avata_option('section_fullwidth_blog');
  $display_categories=  avata_option('section_display_categories_blog');
  
  $col               = $columns>0?12/$columns:4;
  $container         = 'container';
  if ($fullwidth=='1')
 	 $container         = 'container-fullwidth';
	
  if( is_array($category) )
	$categories = implode(',',$category);
  else
  	$categories = $category;
  ?>
  <div class="section-content-wrap">
    <div class="<?php echo $container;?>">
    <?php if ( $section_title !='' || $section_subtitle !='' ){?>
    <div class="section-title-area">
      <h2 class="section-title text-center avata-section_title_team <?php echo $avata_animation;?>" ata-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo esc_attr($section_title);?></h2>
      <p class="section-subtitle text-center avata-section_subtitle_team <?php echo $avata_animation;?>" ata-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo wp_kses(do_shortcode($section_subtitle), $allowedposttags);?></p>
    </div>
    <?php }?>
      <div class="section-content">
      
<?php
	 $news_item   = '';
	 $news_str    = '';
	 $j           = 0;
	 $avata_animation_delay_new = $avata_animation_delay;
	 $args = array(
	 				'cat'=> $categories,
					'ignore_sticky_posts'=>1,
					'posts_per_page'=>$posts_num,
					 );
	 $the_query = new WP_Query( $args );

// The Loop
if($the_query->have_posts()):
	while ( $the_query->have_posts() ) : $the_query->the_post();  
	   
		 $featured_image = '';
		if( has_post_thumbnail()  ){
			$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), "large" );
			$featured_image = '<div class="avata-post-image">
								 <div class="avata-overlay"></div>';
			if($display_categories == '1')
				$featured_image .= '<div class="avata-category">'.get_the_category_list(', ').'</div>';
			$featured_image .= '<img src="'.$image_attributes[0].'" alt="'.get_the_title().'" class="img-responsive"> </div>';		
					  
			}
		
		$news_item .= '<div class="col-md-'.$col.' '.$avata_animation.'" data-os-animation="fadeInUp" data-os-animation-delay="'.$avata_animation_delay_new.'">
	  <div class="avata-post" >
		'.$featured_image.'
		<div class="avata-post-text">
		  <h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>
		  <p>'.avata_get_excerpt($excerpt_length).'</p>
		</div>
		<div class="avata-post-meta">'.avata_posted_on().'</div>
	  </div>
	</div>';
												
												
	 
		   $m = $j+1;
		  if( $m % $columns == 0 ){
				$news_str .= '<div class="row p-b">'.$news_item.'<div class="clearfix visible-sm-block"></div></div>';
				$news_item   = '';
		   }
	 $j++;
	 $avata_animation_delay_new = str_replace('s','',$avata_animation_delay_new);
	 $avata_animation_delay_new = $avata_animation_delay_new+0.2;
	 $avata_animation_delay_new = $avata_animation_delay_new.'s';
	endwhile;
endif;

if( $news_item != '' ){
		    $news_str .= '<div class="row p-b">'.$news_item.'<div class="clearfix visible-sm-block"></div></div>';
	      
		   }
// Reset Query
 wp_reset_postdata();
 echo $news_str;	 

	  ?>
      <?php if($btn_txt!=''){?>
        <div class="row">
          <div class="col-md-4 col-md-offset-4 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="2s"> <a href="<?php echo esc_url($btn_link);?>" target="<?php echo esc_attr($btn_target);?>" class="btn btn-primary btn-lg"><?php echo esc_attr($btn_txt);?></a> </div>
        </div>
        <?php }?>
      </div>
    </div>
  </div>