<?php
  global $allowedposttags, $avata_animation, $avata_animation_delay;

  $section_content   = avata_option('section_content_slogan');
  $btn_txt           = avata_option('section_btn_txt_slogan');
  $btn_link          = avata_option('section_btn_link_slogan');
  $btn_target        = avata_option('section_btn_target_slogan');
  $fullwidth         =  avata_option('section_fullwidth_slogan');
  $container         = 'container';
  if ($fullwidth=='1')
 	 $container         = 'container-fullwidth';
  
  $avata_animation_delay_new = str_replace('s','',$avata_animation_delay);
  $avata_animation_delay_new = $avata_animation_delay_new+0.3;
  $avata_animation_delay_new = $avata_animation_delay_new.'s';
  ?>
<div class="section-content-wrap">
  <div class="<?php echo $container;?>">
    <div class="section-content">
        <div class="col-md-8 col-md-offset-2 text-center">
      <h3 class="avata-section_content_slogan <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo wp_kses(do_shortcode($section_content), $allowedposttags);?></h3>
      <a href="<?php echo esc_url($btn_link);?>" target="<?php echo esc_attr($btn_target);?>" class="btn btn-lg btn-primary avata-section_btn_txt_slogan <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay_new;?>"><?php echo esc_attr($btn_txt);?></a> </div>
</div>

    </div>
  </div>
