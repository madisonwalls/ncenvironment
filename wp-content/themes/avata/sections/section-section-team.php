<?php
  global $allowedposttags, $avata_animation, $avata_animation_delay;
  $section_title     = avata_option('section_title_team');
  $section_subtitle  = avata_option('section_subtitle_team');
  $team              = avata_option('section_items_team');
  $fullwidth         =  avata_option('section_fullwidth_team');
  $link_target       =  avata_option('link_target_team');
  $container         = 'container';
  if ($fullwidth=='1')
 	 $container         = 'container-fullwidth';
  
  ?>
<div class="section-content-wrap">
  <div class="<?php echo $container;?>">
  <?php if ( $section_title !='' || $section_subtitle !='' ){?>
    <div class="section-title-area">
      <h2 class="section-title text-center avata-section_title_team <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo esc_attr($section_title);?></h2>
      <p class="section-subtitle text-center avata-section_subtitle_team <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo wp_kses(do_shortcode($section_subtitle), $allowedposttags);?></p>
    </div>
    <?php }?>
    <div class="section-content avata-section_items_team">
		<div class="row">
    <?php
	$i = 1;
	$avata_animation_delay_new = $avata_animation_delay;
	if (is_array($team) && !empty($team) ):
		foreach($team as $item ):
			if(is_numeric($item['avatar']))
				$item['avatar'] = wp_get_attachment_image_url($item['avatar'],'full');
	?>
    
    <div class="col-md-4 <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay_new;?>">
        <div class="person"> <img src="<?php echo esc_url($item['avatar']);?>" alt="<?php echo esc_attr($item['name']);?>" class="img-responsive">
          <div class="person-content">
            <h4><?php echo esc_attr($item['name']);?></h4>
            <h5 class="role"><?php echo esc_attr($item['role']);?></h5>
            <p><?php echo wp_kses(do_shortcode($item['description']), $allowedposttags);?></p>
          </div>
          <ul class="social-icons clearfix">
          	<?php 
				for($i=1;$i<=5;$i++){
					if($item['social_icon_'.$i] !='' ){
			?>
            <li><a target="<?php echo $link_target;?>" href="<?php echo esc_url($item['social_link_'.$i]);?>"><i class="fa fa-<?php echo esc_attr(str_replace('fa-','',$item['social_icon_'.$i]));?>"></i></a></li>
            <?php
					}
				}
			?>
          </ul>
        </div>
      </div>
      
     <?php
	 $i++;
	 $avata_animation_delay_new = str_replace('s','',$avata_animation_delay_new);
	 $avata_animation_delay_new = $avata_animation_delay_new+0.3;
	 $avata_animation_delay_new = $avata_animation_delay_new.'s';
	 endforeach;
	 endif; 
	 ?>
		</div>
    </div>
  </div>
  </div>