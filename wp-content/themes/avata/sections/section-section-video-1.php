<?php
  global $allowedposttags, $avata_animation, $avata_animation_delay;

  $section_title     = avata_option('section_title_video_1');
  $section_subtitle  = avata_option('section_subtitle_video_1');
  $video             = avata_option('section_url_video_1');
  $fullwidth         =  avata_option('section_fullwidth_slogan');
  $container         = 'container';
  if ($fullwidth=='1')
 	 $container         = 'container-fullwidth';
  ?>

<div class="section-content-wrap">
  <div class="<?php echo esc_attr($container);?> text-center">
    <div class="row">
      <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
        <div class="video-content">
          <div class="avate-video-container"> <a href="<?php echo esc_attr($video);?>" class="avate-media <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><i class="fa fa-play"></i></a> </div>
          <h2 class="section-title avata-section_title_video_1 <?php echo $avata_animation;?>" style="font-size: 32px;font-weight: 400;" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo wp_kses(do_shortcode($section_title), $allowedposttags);?></h2>
          <p class="section-subtitle text-center avata-section_subtitle_video_1 <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo wp_kses(do_shortcode($section_subtitle), $allowedposttags);?></p>
        </div>
      </div>
    </div>
  </div>
</div>
