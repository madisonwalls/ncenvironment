<?php 

get_header(); 

$container = 'container';
$sidebar = 'none';
$left_sidebar  = esc_attr(avata_option('left_sidebar_posts'));
$right_sidebar = esc_attr(avata_option('right_sidebar_posts'));
$hide_page_titlebar = esc_attr(avata_option('hide_page_titlebar'));

$left_sidebar = apply_filters('avata_left_sidebar_posts',$left_sidebar);
$right_sidebar = apply_filters('avata_right_sidebar_posts',$right_sidebar);
$hide_page_titlebar = apply_filters('avata_hide_page_titlebar',$hide_page_titlebar);

if ($left_sidebar != '' && $left_sidebar != '0')
	$sidebar = 'left';

if ($right_sidebar != '' && $right_sidebar != '0')
	$sidebar = 'right';

if ($left_sidebar != '' && $left_sidebar != '0' && $right_sidebar != '' && $right_sidebar != '0')
	$sidebar = 'both';

?>
<?php if($hide_page_titlebar !='1'){?>
<section class="page-title-bar page-title-bar-single title-left">
  <div class="<?php echo $container;?>">
  <div class="row">
    <div class="col-md-12">
  <h4 class="text-uppercase"><?php the_title();?></h4>
    <div class="breadcrumb-nav">
      <?php avata_breadcrumbs();?>
    </div>
    <div class="clearfix"></div>
    </div>
    </div>
  </div>
</section>
<?php }?>
<div class="page-wrap">
  <div class="<?php echo $container;?>">
    <div class="page-inner row <?php echo avata_get_sidebar_class($sidebar);?>">
    <div class="col-main">
      <div class="blog-post">
        <div class="full-width">
          <?php the_post_thumbnail( 'avata-featured-image' ); ?>
        </div>
        <h4 class="text-uppercase entry-title">
          <?php the_title();?>
        </h4>
        <?php echo avata_posted_on();?>
        <?php while ( have_posts() ) : the_post();?>
        <div class="post-content">
          <?php

			the_content();

			the_posts_pagination( array(
			'prev_text' => '<i class="fa fa-arrow-left"></i><span class="screen-reader-text">' . __( 'Previous page', 'avata' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'avata' ) . '</span><i class="fa fa-arrow-right"></i>' ,
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'avata' ) . ' </span>',
		) );
			?>
            
             <div class="comments-area text-left">
              <?php
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
			  ?>
            </div> 
            
        </div>

        <div class="inline-block">
          <div class="widget-tags">
            <?php
				  if(get_the_tag_list()) {
					  echo get_the_tag_list(__( 'Tags: ', 'avata' ),', ');
				  }
				  
				  ?>
          </div>
        </div>
        <div class="pagination-row">
          <div class="pagination-post"> </div>
        </div>
        <?php endwhile; // End of the loop.?>
      </div>
      </div>
       <?php avata_get_sidebar($sidebar, 'post'); ?>
    </div>
  </div>
</div>
<?php get_footer();

