<?php
/**
 * Template Name: Front Page
 */
 
 get_header('featured');
 global $avata_animation, $avata_animation_delay;
 
 $hide_side_nav   = absint( avata_option( 'hide_side_nav'));
 $side_nav_align  = esc_attr( avata_option( 'side_nav_align'));
 $sticky_header   = absint( avata_option( 'sticky_header_frontpage'));
 $animation       = avata_option( 'animation');

 $avata_animation = '';
 if( $animation == '1' )
 	$avata_animation =  'os-animation';
 $avata_animation_delay = esc_attr( avata_option( 'animation_delay'),'0.1s');

 $avata_sections = 	avata_get_sections();

 ?>
 
 <div id="content" class="site-content">
		<main id="main" class="site-main avata-home-sections" role="main">
        <?php 
		$i       = 0;
		$sub_nav = '';
		
		foreach ( $avata_sections as $k=>$v ){
			
			$key   = str_replace('section-','',$k);
			$index = str_replace('-','_',$key);
			$hide  = avata_option('section_hide_'.$index);
			if ( $hide == '1' || $hide == 'on' )
				continue;
				
			$section_class     = avata_option('section_css_class_'.$index);
			$section_id        = avata_option('section_id_'.$index);
  			$section_class    .= ' section section-'.$key.' avata-section-'.$key;
			$autoheight        =  avata_option('section_autoheight_'.$index);
			$attr              = '';
			
			if ($autoheight=='1')
				$section_class .= ' fp-auto-height';
			else
				$section_class .= ' avata-full-height';
			
			if ($key=='blog')
				$section_class .= ' avata-blog-style-1';
			
			echo '<section class="'.esc_attr($section_class).'" '.$attr.'>';
			if($i==0 && $sticky_header !='1' )
				echo avata_featured_header();
				
			do_action('avata_before_section');
			get_template_part('sections/section',$k);
			do_action('avata_after_section');
			echo '</section>';
			
			$menu_title         = avata_option('section_menu_title_'.$index );
			$menu_slug          = esc_attr(avata_option('section_id_'.$index ));
			
			$current     = "";
			if( $i==0 )
				$current  = "active";
			
			$hide_side_menu  = esc_attr(avata_option('hide_side_menu_'.$index ));
			$css = '';
			if($hide_side_menu == '1'){
				$css = 'style="height:0;width:0;"';
				$current .= ' avata-hide';
			}
		
			 $sub_nav .= '<li '.$css.' class="'.$current.'"><a id="nav-'.$menu_slug.'" href="#'.$menu_slug.'">'.esc_attr($menu_title).'</a></li>';
			

			$i++;
		}
		?>
         <?php get_footer('frontpage');?>
       </main>
<?php
	if ( $hide_side_nav != '1' ){
		$style = avata_option('nav_styling_css3_styles','fillup');
?>
<div id="avata-nav" class="dotstyle dotstyle-align-<?php echo $side_nav_align;?> dotstyle-<?php echo $style;?>">
  <ul id="dotstyle-nav">
    <?php echo $sub_nav;?>
  </ul>
</div>
<?php }?>
 </div>
 <?php wp_footer(); ?>
</body>
</html>