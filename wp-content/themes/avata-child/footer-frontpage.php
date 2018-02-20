<section class="section fp-auto-height footer">
	<footer>
  <?php
  global $allowedposttags;
  $enable_footer_widgets  = esc_attr(avata_option('enable_footer_widgets'));
  ?>
  <?php //if ($enable_footer_widgets == '1'): ?>
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

        </div>
        <?php //endfor; ?>
      </div>
    </div>
  </div>
  <?php //endif; ?>

      <?php do_action( 'avata_after__footer' ); ?>
  </footer>
 </section>
