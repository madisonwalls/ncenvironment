<?php
get_header(); 

$container = 'container';
$sidebar = 'none';
$left_sidebar  = esc_attr(avata_option('left_sidebar_archive'));
$right_sidebar = esc_attr(avata_option('right_sidebar_archive'));
$hide_page_titlebar = esc_attr(avata_option('hide_page_titlebar'));

if ($left_sidebar != '' && $left_sidebar != '0')
	$sidebar = 'left';

if ($right_sidebar != '' && $right_sidebar != '0')
	$sidebar = 'right';

if ($left_sidebar != '' && $left_sidebar != '0' && $right_sidebar != '' && $right_sidebar != '0')
	$sidebar = 'both';
?>

 <!--Main Area-->
 <?php if($hide_page_titlebar !='1'){?>
<section class="page-title-bar page-title-bar-archive title-left">
<div class="<?php echo $container;?>">
  <div class="row">
    <div class="col-md-12">
  <h4 class="text-uppercase"><?php 
				if( is_archive() )
					the_archive_title();
				else
					single_cat_title(); 
				
				?></h4>
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
                        <section class="page-main" role="main" id="content">
                            <div class="page-content">
                                <!--blog list begin-->
                                
                                <div class="post-list">
                                
                          <?php
			if ( have_posts() ) :

				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content', 'search' );

				endwhile;

				the_posts_pagination( array(
					'prev_text' => '<i class="fa fa-arrow-left"></i><span class="screen-reader-text">' . __( 'Previous Page', 'avata' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next Page', 'avata' ) . '</span><i class="fa fa-arrow-right"></i>' ,
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'avata' ) . ' </span>',
				) );

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>         
                                    
                                    
                                </div>
                                <!--blog list end-->
                 
                            </div>
                            <div class="post-attributes"></div>
                        </section>
                    </div>
                    <?php avata_get_sidebar($sidebar, 'archive'); ?>
                </div>
            </div>  
        </div>

<?php get_footer();
