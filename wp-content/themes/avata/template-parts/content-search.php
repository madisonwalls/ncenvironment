<?php
	$hide_meta_categories = avata_option('hide_meta_categories');
	$hide_meta_readmore   = avata_option('hide_meta_readmore');	
?>
<div class="entry-box-wrap ">
  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <article class="entry-box">
    <div class="post-single">
      <?php if( $hide_meta_categories !='1' ){?>
      <div class="post-cat"> <?php echo get_the_category_list(', ');?> </div>
      <?php }?>
      <?php 
			$entry_class = 'no-img';
			if ( '' !== get_the_post_thumbnail() && ! is_single() ) : 
			$entry_class = '';
			?>
      <div class="post-img"> <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail( 'avata-featured-image' ); ?>
        </a> </div>
      <?php endif; ?>
      <div class="post-desk <?php echo $entry_class;?>">
        <?php the_title( '<h4 class="entry-title text-uppercase"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );?>
         <?php echo avata_posted_on();?>
        <p> <?php the_excerpt();?> </p>
        
        <?php if( $hide_meta_readmore !='1' ){?>
        <a href="<?php the_permalink();?>" class="p-read-more"><?php _e('Read More', 'avata')?> <i class="fa fa-long-arrow-right"></i></a>
        <?php }?>
        </div>
    </div>
  </div>
  </article>
</div>