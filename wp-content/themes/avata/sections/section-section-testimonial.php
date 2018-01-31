<?php
  global $allowedposttags, $avata_animation, $avata_animation_delay;
  $section_title     = avata_option('section_title_testimonial');
  $section_subtitle  = avata_option('section_subtitle_testimonial');
  $testimonial       = avata_option('section_items_testimonial');
  $fullwidth         = avata_option('section_fullwidth_testimonial');
  $container         = 'container';
  if ($fullwidth=='1')
 	 $container         = 'container-fluid';
  
  ?>

<div class="section-content-wrap">
  <div class="<?php echo $container;?>">
  <?php if ( $section_title !='' || $section_subtitle !='' ){?>
  <div class="section-title-area">
    <h2 class="section-title text-center avata-section_title_testimonial <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo esc_attr($section_title);?></h2>
    <p class="section-subtitle text-center avata-section_subtitle_testimonial <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo wp_kses($section_subtitle, $allowedposttags);?></p>
  </div>
  <?php }?>
  <div class="section-content">
    <div class="row">
      <div class="col-md-12 ">
      <div class="wrap-testimonial avata-section_items_testimonial <?php echo $avata_animation;?>"  data-os-animation="fadeIn" data-os-animation-delay="<?php echo $avata_animation_delay;?>">
        <div class="owl-carousel-fullwidth owl-carousel owl-theme">
          <?php
	$i = 1;
	if (is_array($testimonial) && !empty($testimonial) ):
		foreach($testimonial as $item ):
			if(is_numeric($item['avatar']))
				$item['avatar'] = wp_get_attachment_image_url($item['avatar'],'full');
	?>
          <div class="item">
            <div class="testimonial-slide text-center">
              <figure> <img src="<?php echo esc_url($item['avatar']);?>" alt="<?php echo esc_attr($item['name']);?>"> </figure>
              <blockquote>
                <p>"<?php echo wp_kses(do_shortcode($item['description']), $allowedposttags);?>"</p>
              </blockquote>
              <span><?php echo esc_attr($item['name']);?>, <?php echo esc_attr($item['role']);?></span>
               </div>
               </div>
            <?php
	 $i++;
	 endforeach;
	 endif; 
	 ?>
     </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
