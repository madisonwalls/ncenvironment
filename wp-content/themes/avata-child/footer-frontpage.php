<section class="section fp-auto-height footer">
	<footer>
  <?php
  global $allowedposttags;
  $enable_footer_widgets  = esc_attr(avata_option('enable_footer_widgets'));
  ?>
  <?php if ($enable_footer_widgets == '1'): ?>
  <div class="footer-widget-area">
    <div class="container">
      <div class="row">
        <?php $footer_columns = 3; ?>
				<div class="col-sm-12 col-md-3 col-lg-3">
					STORIES
					<a href="https://ncenvironment-madilyn.cloudapps.unc.edu/gen-x/">Gen X</a>

					<a href="https://ncenvironment-madilyn.cloudapps.unc.edu/urban-farming/">Urban Farming</a>

					<a href="https://ncenvironment-madilyn.cloudapps.unc.edu/coal-ash/">Coal Ash</a>

					<a href="https://ncenvironment-madilyn.cloudapps.unc.edu/hog-poop/">Hog Poop</a>

					<a href="https://ncenvironment-madilyn.cloudapps.unc.edu/bees/">Bees</a>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<p>MEJO584 is a class where students work on a semester-long documentary multimedia project that includes photo and video journalists, audio recordists, designers, infographics artists, and programmers.</p>
				</div>
				<div class="col-sm-12 col-md-3 col-lg-3">
					<img src="http://ncenvironment-madilyn.cloudapps.unc.edu/wp-content/uploads/2018/02/School-of-Media-and-Journalism_logo_white_h.png">
					<img src="http://ncenvironment-madilyn.cloudapps.unc.edu/wp-content/uploads/2018/02/UNC_logo_white.png">
				</div>
          <?php if (is_active_sidebar("footer-".$i)) : ?>
          <?php dynamic_sidebar("footer-".$i); ?>
          <?php endif; ?>
        </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>

    <div class="sub-footer">
      <div class="container">
        <div class="row">

          <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="wow fadeInRight animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInRight;">
              <div class="text-left margintop-30 avata-copyright">
              <?php $copyright = wp_kses(avata_option('copyright'), $allowedposttags); ?>
                <p><?php echo $copyright;?> &nbsp;&nbsp; <?php printf(__('Designed by <a href="%s">HooThemes</a>.','avata'),esc_url('http://www.hoothemes.com/'));?></p>
              </div>
            </div>
          </div>
           <div class="col-sm-6 col-md-6 col-lg-6 text-right">
            <ul class="social">
    <?php
	$footer_social_icons = avata_option('footer_social_icons');
	foreach($footer_social_icons as $icon){
					$social_icon  = $icon['icon'];
					$social_link  = $icon['link'];
					$social_title = $icon['title'];
					$social_target = $icon['target'];
					$social_icon  = str_replace('fa fa-','',$social_icon);
					$social_icon  = str_replace('fa-','',$social_icon);
					$social_icon  = 'fa fa-'.trim($social_icon);

					if( $social_icon !=""  ){
					echo '<li><a href="'.esc_url($social_link).'" target="'.esc_attr($social_target).'" data-toggle="tooltip" title="'.esc_attr($social_title).'"><i class="'.esc_attr($social_icon).'"></i></a></li>';
					}
					}
					?>
            </ul>
          </div>
        </div>
      </div>
    </div>
      <?php do_action( 'avata_after__footer' ); ?>
  </footer>
 </section>
