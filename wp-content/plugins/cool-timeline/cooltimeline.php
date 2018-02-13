<?php
/*
  Plugin Name:Cool Timeline 
  Plugin URI:http://www.cooltimeline.com
  Description:Cool Timeline is a responsive wordpress plugin that allows you to create beautiful verticle storyline. You simply create posts, set images and date then Cool Timeline will automatically populate these posts in chronological order, based on the year and date
  Version:1.3.2
  Author:Cool Timeline Team
  Author URI:http://www.cooltimeline.com
  License:GPLv2 or later
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Domain Path: /languages
  Text Domain:cool-timeline
 */

/*
  Copyright 2015  Narinder singh (email :narinder99143@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details."

 * 
 */
/** Configuration * */
if (!defined('COOL_TIMELINE_VERSION_CURRENT')){
    define('COOL_TIMELINE_VERSION_CURRENT', '1.3.2');
}
// define constants for further use
define('COOL_TIMELINE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    define('COOL_TIMELINE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
 	define( 'FA_DIR', COOL_TIMELINE_PLUGIN_DIR.'/fa-icons/' );
	define( 'FA_URL', COOL_TIMELINE_PLUGIN_URL.'/fa-icons/'  );

if (!class_exists('CoolTimeline')) {

    class CoolTimeline {

        /**
         * Construct the plugin object
         */
        public function __construct() {
          
            $this->plugin_path = plugin_dir_path(__FILE__);
          /*
            Including required files
          */
         $this->clt_include_files();

         // Cool Timeline all hooks integrations
         if(is_admin()){
            $plugin = plugin_basename(__FILE__);
            // plugin settings links hook
            add_filter("plugin_action_links_$plugin", array($this, 'plugin_settings_link'));

            // integrated shortcode generator on text editor
          	add_action( 'after_setup_theme', array($this , 'ctl_add_tinymce' ) );
            // loading date picker assets
            add_action( 'admin_enqueue_scripts',array($this , 'load_ctdp_admin_style_script'));
           
           // admin notificaiton for review
            add_action( 'admin_notices',array($this,'cool_admin_messages'));
            add_action( 'wp_ajax_hideRating',array($this,'cool_HideRating' ));
            }
            
            //loading plugin translation files
            add_action('plugins_loaded', array($this, 'clt_load_plugin_textdomain'));
		        //Fixed bridge theme confliction using this action hook
            add_action( 'wp_print_scripts', array($this,'ctl_deregister_javascript'), 100 );
          
            add_image_size( 'ctl_avatar', 250, 250,true );
         }
		
        /*
          Including required files
        */
      public function clt_include_files(){

           // cooltimeline post type
            add_action( 'init', array($this, 'include_files' ) );
            require COOL_TIMELINE_PLUGIN_DIR . 'includes/cool-timeline-posttype.php';
            $cool_timeline_posttype = new CoolTimelinePosttype();

            /*
              Loaded Backend files only 
            */
            if(is_admin()){
            //metaboxes for cooltimeline post type
            include_once COOL_TIMELINE_PLUGIN_DIR . 'includes/metaboxes.php';
            
            /*
             Plugin Settings panel 
            */
            require_once(plugin_dir_path(__FILE__) ."admin-page-class/admin-page-class.php");
             // Initialize Settings
            $this->ctl_option_panel();

            // icon picker for post type
            require COOL_TIMELINE_PLUGIN_DIR.'fa-icons/fa-icons-class.php';
            new Ctl_Fa_Icons();
            }else{ 
           
             /*
             *  Frontend files
             */
             // contains helper funciton for timeline
            include_once COOL_TIMELINE_PLUGIN_DIR . 'includes/ctl-helper-functions.php';

            //Cool Timeline Main shortcode
            require COOL_TIMELINE_PLUGIN_DIR . 'includes/cool-timeline-shortcode.php';
            new CoolTimelineShortcode();
            add_action('wp_enqueue_scripts','ctl_custom_style');
             } 
      }

       function clt_load_plugin_textdomain() {

              $rs = load_plugin_textdomain('cool-timeline', FALSE, basename(dirname(__FILE__)) . '/languages/');
          }

        // Add the settings link to the plugins page
        function plugin_settings_link($links) {
            $settings_link = '<a href="options-general.php?page=cool_timeline_page">Settings</a>';
            array_unshift($links, $settings_link);
            return $links;
        }
        
         function ctl_option_panel() {
            /**
             * configure your admin page
             */
            $config = array(
                'menu' => array('top' => 'cool_timeline'), //sub page to settings page
                'page_title' => __('Cool Timeline','apc'), //The name of this page 
                'capability' => 'manage_options', // The capability needed to view the page 
                'option_group' => 'cool_timeline_options', //the name of the option to create in the database
                'id' => 'cool_timeline_page', // meta box id, unique per page
                'fields' => array(), // list of fields (can be added by field arrays)
                'local_images' => false, // Use local or hosted images (meta box images for add/remove)
                'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
            );

            /**
             * instantiate your admin page
             */
            $options_panel = new BF_Admin_Page_Class($config);
            $options_panel->OpenTabs_container('');

            /**
             * define your admin page tabs listing
             */
            $options_panel->TabsListing(array(
                    'links' => array(
                    'options_1' => __('General Settings', 'apc'),
          					'options_2' => __('Style Settings', 'apc'),
          					'options_3' => __('Typography Settings', 'apc'),
                    'options_4' => __('Advance Settings', 'apc'),
                )
            ));

            /**
             * Open admin page first tab
             */
           $options_panel->OpenTab('options_1');

            /**
             * Add fields to your admin page first tab
             * 
             * Simple options:
             * input text, checbox, select, radio 
             * textarea
             */
            //title
           $options_panel->Title(__("General Settings", "apc"));
            //An optionl descrption paragraph
         //   $options_panel->addParagraph(__("This is a simple paragraph", "apc"));
            //text field
            $options_panel->addText('title_text', array('name' => __('Timeline Title (Default)  ', 'apc'), 'std' => 'Cool Timeline', 'desc' => __('', 'apc')));

            //select field
            $options_panel->addSelect('title_tag', array('h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6'), array('name' => __('Title Heading Tag ', 'apc'), 'std' => array('h1'), 'desc' => __('', 'apc')));
    	     	$options_panel->addRadio('title_alignment', array('left' => 'Left',
                  'center' => 'Center','right'=>'Right'), array('name' => __('Title Alignment ?', 'apc'), 'std' => array('center'), 'desc' => __('', 'apc')));
            $options_panel->addText('post_per_page', array('name' => __('Number of stories to display ?', 'apc'), 'std' => 10, 'desc' => __('This option is overridden by shortcode. Please check shortcode generator.', 'apc')));
        		$options_panel->addText('content_length', array('name' => __('Content Length ', 'apc'), 'std' => 50, 'desc' => __('Please enter no of words', 'apc')));
        		//Image field
        	
        		$options_panel->addImage('user_avatar',array('name'=> __('Timeline default Image','apc'), 'desc' => __('','apc')));

            $options_panel->addRadio('desc_type', array('short' => 'Short (Default)',
                'full' => 'Full (with HTML)'), array('name' => __('Stories Description?', 'apc'), 'std' => array('short'), 'desc' => __('', 'apc')));

            $options_panel->addRadio('display_readmore', array('yes' => 'Yes',
                  'no' => 'No'), array('name' => __('Display read more ?', 'apc'), 'std' => array('yes'), 'desc' => __('', 'apc')));
    		
        		$options_panel->addRadio('posts_orders', array('DESC' => 'DESC',
                      'ASC' => 'ASC'), array('name' => __('Stories Order ?', 'apc'), 'std' => array('DESC'), 'desc' => __('', 'apc')));
        		

        		 $options_panel->addCode('custom_styles', array('name' => 'Custom Styles', 'syntax' => 'css'));

             $options_panel->CloseTab();

            /**
             * Open admin page 2 tab
             */
           $options_panel->OpenTab('options_2');
            $options_panel->Title(__("Style Settings", "apc"));
            /**
             * To Create a Conditional Block first create an array of fields (just like a repeater block
             * use the same functions as above but add true as a last param
             */
            //   $Conditinal_fields[] = $options_panel->addText('con_text_field_id', array('name' => __('My Text ', 'apc')), true);
            $Conditinal_fields[] =$options_panel->addColor('bg_color', array('name' => __('Background Color', 'apc')), true);


          /**
           * Then just add the fields to the repeater block
           */
          //conditinal block
          $options_panel->addCondition('background', array(
              'name' => __('Container Background ', 'apc'),
              'desc' => __('', 'apc'),
              'fields' => $Conditinal_fields,
              'std' => false
          ));

          //Color field
          $options_panel->addColor('content_bg_color',array('name'=> __('Story Background Color','apc'),'std'=>'#c9dfe8', 'desc' => __('','apc')));

          $options_panel->addColor('circle_border_color',array('name'=> __('Circle Color','apc'),'std'=>'#38aab7', 'desc' => __('','apc')));

          $options_panel->addColor('line_color',array('name'=> __('Line Color','apc'),'std'=>'#025149', 'desc' => __('','apc')));
          //Color field
          $options_panel->addColor('first_post',array('name'=> __('First Color','apc'),'std'=>'#29b246', 'desc' => __('','apc')));
          $options_panel->addColor('second_post',array('name'=> __('Second Color','apc'),'std'=>'#ce792f', 'desc' => __('','apc')));
          $options_panel->CloseTab();


          /**
             * Open admin page third tab
             */
          $options_panel->OpenTab('options_3');
			
			//title
            $options_panel->Title(__("Typography Settings", "apc"));
            $options_panel->addTypo('main_title_typo', array('name' => __("Main Title", "apc"), 'std' => array('size' => '14px', 'color' => '#000000', 'face' => 'Montserrat', 'style' => 'normal'), 'desc' => __('', 'apc')));
            $options_panel->addTypo('post_title_typo', array('name' => __("Story Title", "apc"), 'std' => array('size' => '14px', 'color' => '#000000', 'face' => 'Montserrat', 'style' => 'normal'), 'desc' => __('', 'apc')));
			
			     	$options_panel->addRadio('post_title_text_style', array('lowercase' => 'Lowercase',
                'uppercase' => 'Uppercase','capitalize'=>'Capitalize'), array('name' => __('Story Title Style ?', 'apc'), 'std' => array('capitalize'), 'desc' => __('', 'apc')));
				
            $options_panel->addTypo('post_content_typo', array('name' => __("Post Content", "apc"), 'std' => array('size' => '14px', 'color' => '#000000', 'face' => 'Montserrat', 'style' => 'normal'), 'desc' => __('', 'apc')));
           
		
	
		     $options_panel->CloseTab();

          $options_panel->OpenTab('options_4');

         $options_panel->addParagraph(__('<div class="advance_options"><a target="_blank" href="https://codecanyon.net/item/cool-timeline-pro-wordpress-responsive-timeline-plugin/17046256?ref=CoolHappy"><img src="https://res.cloudinary.com/cooltimeline/image/upload/v1504097451/timeline-pro-buy_l7ffks.png"></a></div>', "cool-timeline"));
         $options_panel->CloseTab();
		   }


      function load_ctdp_admin_style_script($hook) {
   
			if( 'post.php' != $hook && 'post-new.php' != $hook)
				return;

      if(get_cpt()=="cool_timeline"){

    			if( apply_filters( 'add_ctdp_timepicker_js', true ) ){
    				wp_enqueue_script( 'timepicker-js', COOL_TIMELINE_PLUGIN_URL . 'js/jquery-ui-timepicker-addon.js', array( 'jquery-ui-datepicker' ) );
    			}
    			if( apply_filters( 'add_ctdp_js', true ) ){
    				wp_enqueue_script( 'ctdp-js', COOL_TIMELINE_PLUGIN_URL . 'js/ctdp.js', array( 'timepicker-js' ) );
    			}
    			if( apply_filters( 'add_ctdp_css', true ) ){
    				wp_enqueue_style( 'ctdp-css', COOL_TIMELINE_PLUGIN_URL . 'css/ctdp.css' );
    			}
      }
		}
       /*
        * Fixed Bridge theme confliction
        */
        function ctl_deregister_javascript() {

            if(is_admin()) {
                $screen = get_current_screen();
                if ($screen->base == "toplevel_page_cool_timeline_page") {
                    wp_deregister_script('default');
                }
            }
        }
		  public function include_files() {
            // Files specific for the front-ned
            if ( ! is_admin() ) {
                // Load template tags (always last)
                include COOL_TIMELINE_PLUGIN_DIR .'fa-icons/includes/template-tags.php';
            }
        }

    // integrated shortcode generator button in text editor
		public function ctl_add_tinymce() {
         global $typenow;
         if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
              return;
        }
    
        if(get_cpt()=="cool_timeline"){
          return ;
        }
       if ( get_user_option('rich_editing') == 'true' ) {
            add_filter('mce_external_plugins', array($this, 'ctl_add_tinymce_plugin'));
            add_filter('mce_buttons', array($this, 'ctl_add_tinymce_button'));
          }    

        }

        //loading tinymce plugin  js
			public function ctl_add_tinymce_plugin( $plugin_array ) {
            $plugin_array['cool_timeline'] =COOL_TIMELINE_PLUGIN_URL.'/includes/js/tinymce-custom-btn.js';
			     return $plugin_array;
			}
      //added shortcode button in array
		function ctl_add_tinymce_button( $buttons ) {
            array_push( $buttons, 'cool_timeline_btn' );
			return $buttons;
			}
          
            
       	/**
         * Activating plugin and adding some info
         */
        public static function activate() {
              update_option("cool-timelne-v",COOL_TIMELINE_VERSION_CURRENT);
              update_option("cool-timelne-type","FREE");
              update_option("cool-timelne-installDate",date('Y-m-d h:i:s') );
              update_option("cool-timelne-ratingDiv","no");
        }

		// END public static function activate

        /**
         * Deactivate the plugin
         */
        public static function deactivate() {
            // Do nothing
        } 
      
      // Admin notificaiton for review  
   public function cool_admin_messages() {
  
     if( !current_user_can( 'update_plugins' ) ){
        return;
     }
    $install_date = get_option( 'cool-timelne-installDate' );
    $ratingDiv =get_option( 'cool-timelne-ratingDiv' )!=false?get_option( 'cool-timelne-ratingDiv'):"no";

    $dynamic_msz='<div class="cool_fivestar update-nag" style="box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);">'.__('
      <p>Dear Cool Timeline Plugin User, Hopefully you\'re happy with our plugin. <br> May I ask you to give it a <strong>5-star rating</strong> on WordPress.org ? 
        This will help to spread its popularity and to make this plugin a better one.
        <br><br>Your help is much appreciated.Thank you very much!').'
        <ul>
            <li class="float:left"><a href="https://wordpress.org/support/plugin/cool-timeline/reviews/?filter=5#new-post" class="thankyou button button-primary" target="_new" title="I Like Cool Timeline" style="color: #ffffff;-webkit-box-shadow: 0 1px 0 #256e34;box-shadow: 0 1px 0 #256e34;font-weight: normal;float:left;margin-right:10px;">'.__('I Like Cool Timeline').'</a></li>
            <li><a href="javascript:void(0);" class="coolHideRating button" title="I already did" style="">'.__('I already rated it').'</a></li>
            <li><a href="javascript:void(0);" class="coolHideRating" title="No, not good enough" style="">'.__('No, not good enough, i do not like to rate it!').'</a></li>
        </ul>
    </div>
    <script>
    jQuery( document ).ready(function( $ ) {

    jQuery(\'.coolHideRating\').click(function(){
        var data={\'action\':\'hideRating\'}
             jQuery.ajax({
        
        url: "' . admin_url( 'admin-ajax.php' ) . '",
        type: "post",
        data: data,
        dataType: "json",
        async: !0,
        success: function(e) {
            if (e=="success") {
               jQuery(\'.cool_fivestar\').slideUp(\'fast\');
         
            }
        }
         });
        })
    
    });
    </script>';

     if(get_option( 'cool-timelne-installDate' )==false && $ratingDiv== "no" )
       {
       echo $dynamic_msz;
       }else{
            $display_date = date( 'Y-m-d h:i:s' );
            $install_date= new DateTime( $install_date );
            $current_date = new DateTime( $display_date );
            $difference = $install_date->diff($current_date);
          $diff_days= $difference->days;
        if (isset($diff_days) && $diff_days>=15 && $ratingDiv == "no" ) {
            echo $dynamic_msz;
          }
      }      

  }   
  
  // ajax handler for feedback callback
  public function cool_HideRating() {
    update_option( 'cool-timelne-ratingDiv','yes' );
    echo json_encode( array("success") );
    exit;
    }
  

        } //end class

    }

   // get current page post type
    function get_cpt() {
        global $post, $typenow, $current_screen;
       if ( $post && $post->post_type )
            return $post->post_type;
       elseif( $typenow )
            return $typenow;
       elseif( $current_screen && $current_screen->post_type )
            return $current_screen->post_type;
        elseif( isset( $_REQUEST['post_type'] ) )
            return sanitize_key( $_REQUEST['post_type'] );
       return null;
      }


    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('CoolTimeline', 'activate'));
    register_deactivation_hook(__FILE__, array('CoolTimeline', 'deactivate'));

    // instantiate the plugin class
    $cool_timeline = new CoolTimeline();
