<?php
  global $allowedposttags, $avata_animation, $avata_animation_delay;
  $section_title     = avata_option('section_title_counter');
  $section_subtitle  = avata_option('section_subtitle_counter');
  $counter           = avata_option('section_items_counter');
  $fullwidth         = avata_option('section_fullwidth_counter');
  $columns           = absint(avata_option('columns_counter'));
  $columns           = $columns==0?4:$columns;
  $columns           = 12/$columns;
  $container         = 'container';
  if ($fullwidth=='1')
 	 $container         = 'container-fluid';
?>
<div class="section-content-wrap">
  <div class="<?php echo $container;?>">
  <?php if ( $section_title !='' || $section_subtitle !='' ){?>
    <div class="section-title-area">
      <h2 class="section-title text-center avata-section_title_counter <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo esc_attr($section_title);?></h2>
      <p class="section-subtitle text-center avata-section_subtitle_counter <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo wp_kses(do_shortcode($section_subtitle), $allowedposttags);?></p>
    </div>
    <?php }?>
    <div class="section-content">
    <div class="avata-section_items_counter">
     
     <div class="avata-counter-style-2" data-stellar-background-ratio="0.5">
				<div class="avata-section-content-wrap">
					<div class="avata-section-content">
						<div class="row">
                        
                        <?php if(is_array($counter)):?>
						<?php foreach($counter as $item):?>
                          <?php
                          $icon  = str_replace('fa-','',$item['icon']);
                          ?>
							<div class="col-md-<?php echo $columns;?> text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
								<div class="icon">
                                <?php 
								if($item['image']!=''):
								$image = $item['image'];
								if (is_numeric($image)) {
									$image_attributes = wp_get_attachment_image_src($image, 'full');
									$image       = $image_attributes[0];
				 				}
								?>
                                <img src="<?php echo esc_url($image);?>" alt="<?php echo esc_attr($item['title']);?>">
                                <?php else:?>
									<i class="fa fa-<?php echo esc_attr($icon);?>"></i>
                                   <?php endif;?>
								</div>
								<span class="avata-counter js-counter" data-from="0" data-to="<?php echo absint($item['number']);?>" data-speed="3000" data-refresh-interval="50"></span>
								<span class="avata-counter-label"><?php echo esc_attr($item['title']);?></span>
								
							</div>
 <?php endforeach;?>
      <?php endif;?>
                            
						</div>
					</div>
			</div>
		</div>
        
        
  </div>
</div>
</div>
</div>