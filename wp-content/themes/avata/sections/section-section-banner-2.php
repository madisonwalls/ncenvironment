<?php
  global $allowedposttags, $avata_animation, $avata_animation_delay;

  $section_title      = avata_option('section_title_banner_2');
  $section_subtitle   = avata_option('section_subtitle_banner_2');
  
  $btn_txt_1          = avata_option('section_btntxt_1_banner_2');
  $btn_link_1         = avata_option('section_btnlink_1_banner_2');
  $btn_target_1       = avata_option('section_btntarget_1_banner_2');
  $btn_txt_2          = avata_option('section_btntxt_2_banner_2');
  $btn_link_2         = avata_option('section_btnlink_2_banner_2');
  $btn_target_2       = avata_option('section_btntarget_2_banner_2');
  $arrow              = avata_option('section_display_arrow_banner_2');
  $overlay            = avata_option('section_overlay_banner_2');
  
  $avata_animation_delay_new = str_replace('s','',$avata_animation_delay);
  $avata_animation_delay_new = $avata_animation_delay_new+0.3;
  $avata_animation_delay_new = $avata_animation_delay_new.'s';
  ?>
    <div class="avata-box__magnet avata-box__magnet--sm-padding avata-box__magnet--center-center">
    <?php if($overlay == '1'){?>
        <div class="avata-overlay" style="opacity: 0.6; background-color: rgb(40, 50, 78);"></div>
        <?php }?>
        <div class="avata-box__container avata-section__container container">
            <div class="avata-box avata-box--stretched"><div class="avata-box__magnet section-content-wrap avata-box__magnet--center-center">
                <div class="avata-hero" >
                <h1 class="avata-hero__text avata-section_title_banner_2 <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><?php echo esc_attr($section_title);?></h1>
                    <p class="avata-hero__subtext <?php echo $avata_animation;?>" data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay;?>"><strong class="avata-section_subtitle_banner_2"><?php echo wp_kses(do_shortcode($section_subtitle), $allowedposttags);?></strong></p>
                </div>
                <div class="avata-buttons btn-inverse avata-buttons--center">
                <?php if($btn_txt_1 !=''){?>
                <a class="avata-buttons__btn btn btn-lg btn-primary avata-section_btntxt_1_banner_2 <?php echo $avata_animation;?>" href="<?php echo esc_url($btn_link_1);?>" target="<?php echo esc_attr($btn_target_1);?>"  data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay_new;?>"><?php echo esc_attr($btn_txt_1);?></a>
                <?php }?>
                <?php if($btn_txt_2 !=''){
					 $avata_animation_delay_new = str_replace('s','',$avata_animation_delay_new);
 					 $avata_animation_delay_new = $avata_animation_delay_new+0.3;
					 $avata_animation_delay_new = $avata_animation_delay_new.'s';
				?>
                <a class="avata-buttons__btn btn btn-lg btn-outline avata-section_btntxt_2_banner_2 <?php echo $avata_animation;?>" href="<?php echo esc_url($btn_link_2);?>" target="<?php echo esc_attr($btn_target_2);?>"  data-os-animation="fadeInUp" data-os-animation-delay="<?php echo $avata_animation_delay_new;?>"><?php echo esc_attr($btn_txt_2);?></a>
                <?php }?>
                
                </div>
            </div></div>
        </div>
        
    </div>
    <?php if($arrow =='1' ){?>
    <div class="avata-arrow avata-arrow--floating text-center">
            <div class="avata-section__container container">
                <a class="avata-arrow__link move-section-down" href="#"><i class="fa fa-angle-down"></i></a>
            </div>
        </div>
<?php }?>
