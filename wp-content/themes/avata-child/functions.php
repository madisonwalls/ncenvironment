<?php
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_scripts', PHP_INT_MAX);
function enqueue_child_theme_scripts() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri().'/js/poop.js' );
  wp_enqueue_style( 'parent-style', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js' );
  wp_enqueue_style( 'parent-style', get_template_directory_uri().'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js' );
  wp_enqueue_style( 'parent-style', get_template_directory_uri().'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js' );
  wp_enqueue_style( 'parent-style', get_template_directory_uri().'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js' );
}
?>
