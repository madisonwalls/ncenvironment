<?php
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
function scrollytelly() {
    wp_enqueue_script( 'scrolly-telly', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js', 'jQuery', '', true );
    wp_enqueue_script( 'scrolly-telly2', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js', 'jquery', '', true );
    wp_enqueue_script( 'scrolly-telly3', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js', 'jQuery', '', true );
    wp_enqueue_script( 'scrolly-telly4', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js', 'jQuery', '', true );
      wp_enqueue_script( 'scrollytelly5', get_stylesheet_directory_uri() . '/js/poop.js', 'jQuery', '', true);
}
add_action('wp_enqueue_scripts', 'scrollytelly');
?>
