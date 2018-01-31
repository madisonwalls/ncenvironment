<?php
  global $allowedposttags, $avata_animation, $avata_animation_delay;
  $section_title     = avata_option('section_title_progress_bar_2');
  $section_subtitle  = avata_option('section_subtitle_progress_bar_2');
  $progress_bar      = avata_option('section_progress_progress_bar_2');
  $fullwidth         = avata_option('section_fullwidth_progress_bar_2');

  $container         = 'container';
  if ($fullwidth=='1')
 	 $container         = 'container-fullwidth';
  
  ?>

<div class="section-content-wrap">
  <div class="<?php echo $container;?>">
  <?php if ( $section_title !='' || $section_subtitle !='' ){?>
    <div class="section-title-area">
      <h2 class="section-title text-center avata-section_title_service_2 <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo esc_attr($section_title);?></h2>
      <p class="section-subtitle text-center avata-section_subtitle_service_2 <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo wp_kses(do_shortcode($section_subtitle), $allowedposttags);?></p>
    </div>
    <?php }?>
    <div class="section-content">
      <div class="progress_bar-container">
     
     <div class="row">
     <?php
	if (is_array($progress_bar) && !empty($progress_bar) ):
		$num = count($progress_bar);
		switch($num){
			case '1':
				$col = 12;
			break;
			case '2':
				$col = 6;
			break;
			case '3':
				$col = 4;
			break;
			case '4':
				$col = 3;
			break;
			default:
				$col = 3;
			break;
			
			}
		foreach($progress_bar as $item ):
				
	?>
    
     <div class="col-md-<?php echo $col;?>">
                        <div class="progress2 circle" data-percent="<?php echo absint($item['percent']);?>" data-color="<?php echo esc_attr($item['color']);?>">
                          <strong></strong>
                          <span><?php echo esc_attr($item['title']);?></span>
                        </div>
                    </div>
    
    <?php
	 endforeach;
	 endif; 
	 ?>
            </div>
     
     
      </div>
    </div>
  </div>
</div>
