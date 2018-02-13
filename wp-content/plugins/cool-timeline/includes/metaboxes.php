<?php
  add_action( 'add_meta_boxes_cool_timeline', 'ctl_add_meta_boxes' );
  add_action( 'save_post_cool_timeline', 'ctl_save_meta_boxes_data', 10, 2 );
  
    /**
     * Add meta box
     *
     * @param post $post The post object
     * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
     */
    function ctl_add_meta_boxes( $post ){

       add_action( 'admin_enqueue_scripts', 'ctl_post_settings_style' ); 
        add_meta_box( 'cool_timeline_meta_box', __( 'Cool Timeline Settings', 'cool-timeline' ), 'ctl_build_meta_box', 'cool_timeline', 'normal', 'high' );
        add_meta_box(
                'ctl-pro-banner',
                __( 'Please Give Us Your Feedback','cool-timeline'),
                'ctl_right_section',
                'cool_timeline',
                'side',
                'low'
            );
     }
     
         /**
         * Cool timeline custom field meta box
         *
         * @param post $post The post object
         */
        function ctl_build_meta_box( $post ){
          // make sure the form request comes from WordPress
             wp_nonce_field( basename( __FILE__ ), 'ctl_meta_box_nonce' );

         // retrieve the image_container_type current value
         $image_container_type = get_post_meta( $post->ID, 'image_container_type', true );
         ?>
            <div class="ctl_meta_box_lbl">
          <label><strong><?php _e( 'Story Image Size', 'cool-timeline' ); ?></strong></label>
          </div>
            <div class="ctl_meta_box_fields">
         <div class='ctl-switch-fields'>
          <?php if(empty($image_container_type)){ ?>
          <input type="radio" id="image_container_large" name="image_container_type" value="Full" checked="true" ?><label for="image_container_large"><?php _e('Full', 'cool-timeline'); ?></label>
          <?php }else{ ?>
          <input type="radio" id="image_container_large" name="image_container_type" value="Full" <?php checked( $image_container_type, 'Full' ); ?> /><label for="image_container_large"><?php _e('Full', 'cool-timeline'); ?></label>
        <?php } ?>
            <input type="radio" id="image_container_small" name="image_container_type" value="Small" <?php checked( $image_container_type, 'Small' ); ?> /><label for="image_container_small"><?php _e('Small', 'cool-timeline'); ?></label>
             </div> 
             <div style="clear:both"></div>
      
          </div>
            
        <?php 
    }

    /**
     * Store custom field meta box data
     *
     * @param int $post_id The post ID.
     */
    function ctl_save_meta_boxes_data( $post_id ){
       // verify meta box nonce
        if ( !isset( $_POST['ctl_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ctl_meta_box_nonce'], basename( __FILE__ ) ) ){
            return;
        }
        // return if autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return;
        }
        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ){
            return;
        }

        // store custom fields values
        // image_container_type string
        if ( isset( $_REQUEST['image_container_type'] ) ) {
            update_post_meta( $post_id, 'image_container_type', sanitize_text_field( $_POST['image_container_type'] ) );
        }
    }
  
    function ctl_right_section($post, $callback){
        global $post;
        $pro_add='';
        $pro_add .='<div><div>'.
        __('If you find our plugin and support helpful.<br>Please rate and review us,It helps us grow <br>and improve our services','cool-timeline').'.<br>
        <a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/cool-timeline">'.__('WordPress.org','cool-timeline').'</a><br>
        <a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/cool-timeline"><img src="https://res.cloudinary.com/cooltimeline/image/upload/v1504097450/stars5_gtc1rg.png"></a></div>';

        $pro_add .='</div><hr><div><strong class="ctl_add_head">'.__('Upgrade to Pro version','cool-timeline').'</strong><a target="_blank" href="http://www.cooltimeline.com"><img src="https://res.cloudinary.com/cooltimeline/image/upload/v1503490189/website-images/cool-timeline-demos.png"></a> <a target="_blank" href="http://www.cooltimeline.com/downloads/buy-now-cool-timeline-pro"><img src="https://res.cloudinary.com/cooltimeline/image/upload/v1468242487/6-buy-cool-timeline_vabou4.png"></a></div>';
        echo $pro_add ;
    }

     /* Meta boxes styles */   
     function ctl_post_settings_style($hook) {
        wp_enqueue_style( 'custom_wp_admin_css',COOL_TIMELINE_PLUGIN_URL.'css/admin-style.css');
        }