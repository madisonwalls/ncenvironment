<?php

get_header();

global $avata_page_meta;

$fullwidth  = isset($avata_page_meta->full_width)?$avata_page_meta->full_width:'';

$container = 'container';
if ($fullwidth=='on')
	$container = 'container-fluid';
	
$sidebar = 'none';
$left_sidebar  = esc_attr(avata_option('left_sidebar_products'));
$right_sidebar = esc_attr(avata_option('right_sidebar_products'));

if ($left_sidebar != '' && $left_sidebar != '0')
	$sidebar = 'left';

if ($right_sidebar != '' && $right_sidebar != '0')
	$sidebar = 'right';

if ($left_sidebar != '' && $left_sidebar != '0' && $right_sidebar != '' && $right_sidebar != '0')
	$sidebar = 'both';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <section class="page-title-bar title-center no-subtitle" >
    <div class="<?php echo $container;?>">
      <hgroup class="page-title text-light text-center">
        <h2> <?php if (is_shop()):?>
			    <?php woocommerce_page_title(); ?>
                <?php elseif ( is_product_category() || is_product_tag() ):?>
                <?php single_term_title();?>
                <?php else:?>
                <?php the_title(); ?>
                <?php endif; ?></h2>
      </hgroup>
      <div class="breadcrumb-nav breadcrumbs text-center text-light" itemprop="breadcrumb"> <?php woocommerce_breadcrumb();?></div>
      <div class="clearfix"></div>
    </div>
  </section>
  <div class="post-wrap">
    <div class="<?php echo $container;?>">
      <div class="page-inner row <?php echo avata_get_sidebar_class($sidebar);?>">
        <div class="col-main">
          <?php woocommerce_content(); ?>
        </div>
        <?php avata_get_sidebar($sidebar, 'page'); ?>
      </div>
    </div>
  </div>
</article>
<?php 
get_footer();