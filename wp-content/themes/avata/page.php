<?php

get_header();

global $avata_page_meta;

$fullwidth  = isset($avata_page_meta->full_width)?$avata_page_meta->full_width:'';

$container = 'container';
if ($fullwidth=='on')
	$container = 'container-fluid';
	
$sidebar = 'none';
$left_sidebar  = esc_attr(avata_option('left_sidebar_pages'));
$right_sidebar = esc_attr(avata_option('right_sidebar_pages'));
$hide_page_titlebar = esc_attr(avata_option('hide_page_titlebar'));

$left_sidebar = apply_filters('avata_left_sidebar_pages',$left_sidebar);
$right_sidebar = apply_filters('avata_right_sidebar_pages',$right_sidebar);
$hide_page_titlebar = apply_filters('avata_hide_page_titlebar',$hide_page_titlebar);

if ($left_sidebar != '' && $left_sidebar != '0')
	$sidebar = 'left';

if ($right_sidebar != '' && $right_sidebar != '0')
	$sidebar = 'right';

if ($left_sidebar != '' && $left_sidebar != '0' && $right_sidebar != '' && $right_sidebar != '0')
	$sidebar = 'both';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if($hide_page_titlebar !='1'){?>
  <section class="page-title-bar title-center no-subtitle" >
    <div class="<?php echo $container;?>">
      <hgroup class="page-title text-light text-center">
        <h2><?php the_title();?></h2>
      </hgroup>
      <div class="breadcrumb-nav breadcrumbs text-center text-light" itemprop="breadcrumb"> <?php avata_breadcrumbs();?></div>
      <div class="clearfix"></div>
    </div>
  </section>
 <?php }?>
  <div class="post-wrap">
    <div class="<?php echo $container;?>">
      <div class="page-inner row <?php echo avata_get_sidebar_class($sidebar);?>">
        <div class="col-main">
          <?php while (have_posts()) : ?>
          <?php the_post(); ?>
          <?php get_template_part('template-parts/content', 'page'); ?>
          <?php endwhile; ?>
        </div>
        <?php avata_get_sidebar($sidebar, 'page'); ?>
      </div>
    </div>
  </div>
</article>
<?php 
get_footer();
