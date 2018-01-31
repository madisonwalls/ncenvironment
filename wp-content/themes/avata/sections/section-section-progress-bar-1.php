<?php
  global $allowedposttags, $avata_animation, $avata_animation_delay;
  $section_title     = avata_option('section_title_progress_bar_1');
  $section_subtitle  = avata_option('section_subtitle_progress_bar_1');
  $section_content   = avata_option('section_content_progress_bar_1');
  $progress_bar      = avata_option('section_progress_progress_bar_1');
  $layout            = avata_option('section_layout_progress_bar_1');
  $fullwidth         = avata_option('section_fullwidth_progress_bar_1');

  $container         = 'container';
  if ($fullwidth=='1')
 	 $container         = 'container-fullwidth';
  
  ?>

<div class="section-content-wrap">
  <div class="<?php echo $container;?>">
  <?php if ( $section_title !='' || $section_subtitle !='' ){?>
    <div class="section-title-area">
      <h2 class="section-title text-center avata-section_title_service_1 <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo esc_attr($section_title);?></h2>
      <p class="section-subtitle text-center avata-section_subtitle_service_1 <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo wp_kses($section_subtitle, $allowedposttags);?></p>
    </div>
    <?php }?>
    <div class="section-content">
      <div class="progress_bar-container">
        <?php if( $layout == '1'){?>
        <div class="col-md-6">
          <div class="progress_bar-content">
            <div class="avata-progress_bar">
              <div class="avata-progress_bar-content avata-section_content_progress_bar_1 <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"> <?php echo wp_kses(do_shortcode($section_content), $allowedposttags);?> </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 no-padding avata-section_progress_progress_bar_1">
     <?php
	if (is_array($progress_bar) && !empty($progress_bar) ):
		foreach($progress_bar as $item ):
				
	?>
          <div class="item">
        <h3 class="progress-title"><?php echo esc_attr($item['title']);?></h3>
        <div class="progress">
                        <div class="progress-bar" style="width:<?php echo absint($item['percent']);?>%; background:<?php echo esc_attr($item['color']);?>;">
                            <div class="progress-value"><?php echo absint($item['percent']);?>%</div>
                        </div>
                    </div>
                    </div>

       <?php
	 endforeach;
	 endif; 
	 ?>
        
         </div>
        
        <?php }else{?>
        <div class="col-md-6 no-padding avata-section_progress_progress_bar_1"> 
        
    <?php
	if (is_array($progress_bar) && !empty($progress_bar) ):
		foreach($progress_bar as $item ):
				
	?>
          <div class="item">
        <h3 class="progress-title"><?php echo esc_attr($item['title']);?></h3>
        <div class="progress">
                        <div class="progress-bar" style="width:<?php echo absint($item['percent']);?>%; background:<?php echo esc_attr($item['color']);?>;">
                            <div class="progress-value"><?php echo absint($item['percent']);?>%</div>
                        </div>
                    </div>
                    </div>

       <?php

	 endforeach;
	 endif; 
	 ?>
         </div>
        <div class="col-md-6">
          <div class="progress_bar-content">
            <div class="avata-progress_bar">
              <div class="avata-progress_bar-conten avata-section_content_progress_bar_1 <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"> <?php echo wp_kses(do_shortcode($section_content), $allowedposttags);?> </div>
            </div>
          </div>
        </div>
        <?php }?>
      </div>
    </div>
  </div>
</div>
