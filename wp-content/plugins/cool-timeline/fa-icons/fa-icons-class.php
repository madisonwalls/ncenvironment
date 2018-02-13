<?php

  if ( ! class_exists( 'Ctl_Fa_Icons' ) ) {

    class Ctl_Fa_Icons {

      var $icons;

      var $screens;

      public function __construct()
      {
        // generate the icon array
        $this->ctl_generate_icon_array();
        // Set screens
        $this->screens = array('cool_timeline');
        $posttype = get_cpt();
        // These should only be loaded in the admin, and for users that can edit posts
        if (is_admin() && $posttype="cool_timeline") {
          if (is_admin()) {
            // Load up the metabox
            add_action('add_meta_boxes', array($this, 'ctl_metabox'));
            // Saves the data
            add_action('save_post', array($this, 'ctl_save'));
            // Load up plugin styles and scripts
            add_action('admin_enqueue_scripts', array($this, 'ctl_ss'));
            // Add a pretty font awesome modal
            add_action('admin_footer', array($this, 'ctl_modal'));
          }
          // Load scripts and/or styles in the front-end
          add_action('wp_enqueue_scripts', array($this, 'clt_front_scripts'));

          // Add a shortcode
          add_shortcode('fa', array($this, 'ctl_shortcode'));
        }
      }

      function ctl_shortcode( $atts ) {
        $atts = extract( shortcode_atts( array( 'icon' => '' ), $atts ) );
        if ( ! $icon ) {
          global $post;
          $post_id = $post->ID;
          $icon    = $this->ctl_retrieve( $post_id );
          if ( ! $icon ) {
            return;
          }
        }
        return '<i class="fa ' . $icon . '"></i>';
      }

      public function ctl_retrieve( $post_id = null, $format = false ) {
            if ( ! $post_id ) {
              global $post;
              if ( ! is_object( $post ) ) {
                return;
              }
              $post_id = $post->ID;
            }
            $icon = get_post_meta( $post_id, 'fa_field_icon', true );
            if ( ! $icon ) {
              return;
        }
        if ( $format ) {
          $output = '<i class="fa ' . $icon . '"></i>';
        } else {
          $output = $icon;
        }
        return $output;
      }

      public function clt_front_scripts() {
        if ( apply_filters( 'fa_field_load_styles', true ) ) {
          wp_enqueue_style( 'font-awesome', FA_URL . 'css/font-awesome/css/font-awesome.min.css' );
        }
      }

      public function ctl_modal() {
        ?>

        <div class="fa-field-modal" id="fa-field-modal" style="display:none">
          <div class="fa-field-modal-close">&times;</div>
          <h1 class="fa-field-modal-title"><?php _e( 'Select Font Awesome Icon', 'cool-timeline' ); ?></h1>

          <div class="fa-field-modal-icons">
            <?php if ( $this->icons ) : ?>

              <?php foreach ( $this->icons as $icon ) : ?>

                <div class="fa-field-modal-icon-holder" data-icon="<?php echo $icon['class']; ?>">
                  <div class="icon">
                    <i class="fa <?php echo $icon['class']; ?>"></i>
                  </div>
                  <div class="label">
                    <?php echo $icon['class']; ?>
                  </div>
                </div>

              <?php endforeach; ?>

            <?php endif; ?>
          </div>
        </div>

      <?php
      }
      /**
       * Loads up styles and scripts
       * @return void
       * 
       **/
      public function ctl_ss() {
        // only load the styles for eligable post types
        if ( in_array( get_current_screen()->post_type, $this->screens ) ) {
          // load up font awesome
          wp_enqueue_style( 'fa-field-fontawesome-css', FA_URL . 'css/font-awesome/css/font-awesome.min.css' );
          // load up plugin css
          wp_enqueue_style( 'fa-field-css', FA_URL . 'css/fa-field.css' );
          // load up plugin js
          wp_enqueue_script( 'fa-field-js', FA_URL . 'js/fa-field.js', array( 'jquery' ) );
        }
      }
      /**
       * Loads up actions and translations for the plugins
       * @return void
       * 
       **/
      public function ctl_metabox() {
        // which screens to add the metabox to, by default all public post types are added
        //$screens = $this->screens;
        /**
         * // change for all post types
         **/
      //  $screens = get_post_types();
        $screens=array('cool_timeline');
        foreach ( $screens as $screen ) {
          add_meta_box( 'fa_field', __( 'Select Story Icon', 'cool-timeline' ), array(
            $this,
            'ctl_populate_metabox'
          ), $screen, 'normal','high' );
        }
      }

      public function ctl_populate_metabox( $post ) {
        $icon = get_post_meta( $post->ID, 'fa_field_icon', true );
        ?>

        <div class="fa-field-metabox">
          <div class="fa-field-current-icon">
            <div class="icon">
              <?php if ( $icon ) : ?>
                <i class="fa <?php echo $icon; ?>"></i>
              <?php endif; ?>
            </div>
            <div class="delete <?php echo $icon ? 'active' : ''; ?>">&times;</div>
          </div>
          <input type="hidden" name="fa_field_icon" id="fa_field_icon" value="<?php echo $icon; ?>">
          <?php wp_nonce_field( 'fa_field_icon', 'fa_field_icon_nonce' ); ?>

          <button class="button-primary add-fa-icon"><?php _e( 'Add Icon', 'cool-timeline' ); ?></button>
        </div>

      <?php
      }

      public function ctl_save( $post_id ) {
        /**
         * // change for all post types
         **/
        /*if ( ! in_array( get_post_type( $post_id ), $this->screens ) ) {
          return;
        }*/
        if ( isset( $_POST['fa_field_icon_nonce'] ) && ! wp_verify_nonce( $_POST['fa_field_icon_nonce'], 'fa_field_icon' ) ) {
          return;
        }
        if ( isset( $_POST['fa_field_icon'] ) ) {
          update_post_meta( $post_id, 'fa_field_icon', $_POST['fa_field_icon'] );
        }
      }
      /**
       * Get an instance of the plugin
       * @return object The instance
       * 
       **/
      public function instance() {
        return new self();
      }

      private function ctl_generate_icon_array() {
        $icons = get_option( 'fa_icons' );
        if ( ! $icons ) {
          $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
          $subject = file_get_contents( FA_DIR . 'css/font-awesome/css/font-awesome.css' );
          preg_match_all( $pattern, $subject, $matches, PREG_SET_ORDER );
          $icons = array();
          foreach ( $matches as $match ) {
            $icons[] = array( 'css' => $match[2], 'class' => stripslashes( $match[1] ) );
          }
          update_option( 'fa_icons', $icons );
        }
        $this->icons = $icons;
      }
    }
  }

?>