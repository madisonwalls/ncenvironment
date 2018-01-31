<?php
global $avata_post_meta, $allowedposttags;
get_header();

$container = 'container';
$sidebar = 'none';
$post_class = '';
$left_sidebar = esc_attr(avata_option('left_sidebar_pages'));
$right_sidebar = esc_attr(avata_option('right_sidebar_pages'));
$hide_page_titlebar = esc_attr(avata_option('hide_page_titlebar'));

if ($left_sidebar != '')
	$sidebar = 'left';

if ($right_sidebar != '')
	$sidebar = 'right';

if ($left_sidebar != '' && $right_sidebar != '')
	$sidebar = 'both';

$page_id = absint(avata_option('page_404_content'));
$title   =  __('404 Not Found', 'avata');
$content = __('<h1>OOPS!</h1><p>Can\'t find the page.</p>', 'avata');

if ($page_id  > 0) {
	$query = new WP_Query(array('page_id' => $page_id));
	if ($query->have_posts() ) {
		while ($query->have_posts()) {
			$query->the_post();

			$title   = get_the_title();
			$content = get_the_content();
        }
	}
	wp_reset_postdata();
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if($hide_page_titlebar !='1'){ ?>
  <section class="page-title-bar title-center no-subtitle" >
    <div class="<?php echo $container;?>">
      <hgroup class="page-title text-light text-center">
        <h1>
          <?php echo $title;?>
        </h1>
      </hgroup>
      <div class="breadcrumb-nav breadcrumbs text-center text-light" itemprop="breadcrumb"> <?php avata_breadcrumbs();?></div>
      <div class="clearfix"></div>
    </div>
  </section>
<?php }?>
  <div class="page-wrap">
    <div class="<?php echo $container;?>">
      <div class="page-inner row <?php echo avata_get_sidebar_class($sidebar);?>">
        <div class="col-main">
        <?php echo wp_kses($content, $allowedposttags);?>
        </div>
        <?php avata_get_sidebar($sidebar, 'page'); ?>
      </div>
    </div>
  </div>
</article>
<?php 
get_footer();
