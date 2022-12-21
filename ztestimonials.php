<?php

/**
* Plugin Name: ZTestimonials
* Plugin URI: https://www.wordpress.org/ztestimonials
* Description: A plugin to show testimonials
* Version: 1.0
* Requires at least: 5.6
* Requires PHP: 7.0
* Author: Bimalendu Behera
* Author URI: https://www.forkics.com
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: ztestimonials
* Domain Path: /languages
*/
/*
ZTestimonials is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
ZTestimonials is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Z Testimonials. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !class_exists( 'ZTestimonials' ) ){

    class ZTestimonials{

        public function __construct() {

            $this->load_textdomain();

            // Define constants used througout the plugin
            $this->define_constants(); 
            
            require_once( ZTESTIMONIALS_PATH . 'post-types/class.ztestimonials-cpt.php' );
            $ZTestimonialsPostType = new ZTestimonials_Post_Type();

            require_once( ZTESTIMONIALS_PATH . 'widgets/class.ztestimonials-widget.php' );
            $ZTestimonialsWidget = new ZTestimonials_Widget();   
            
            add_filter( 'archive_template', array( $this, 'load_custom_archive_template' ) );
            add_filter( 'single_template', array( $this, 'load_custom_single_template' ) );
        }

         /**
         * Define Constants
         */
        public function define_constants(){
            // Path/URL to root of this plugin, with trailing slash.
            define ( 'ZTESTIMONIALS_PATH', plugin_dir_path( __FILE__ ) );
            define ( 'ZTESTIMONIALS_URL', plugin_dir_url( __FILE__ ) );
            define ( 'ZTESTIMONIALS_VERSION', '1.0.0' );  
            define ( 'ZTESTIMONIALS_OVERRIDE_PATH_DIR', get_stylesheet_directory() . '/ztestimonials/' );   
        }

        public function load_custom_archive_template( $tpl ){
            if( current_theme_supports( 'ztestimonials' ) ){
                if( is_post_type_archive( 'ztestimonials' ) ){
                    $tpl = $this->get_template_part_location( 'archive-ztestimonials.php' );
                }
            }
            return $tpl;
        }

        public function load_custom_single_template( $tpl ){
            if( current_theme_supports( 'ztestimonials' ) ){
                if( is_singular( 'ztestimonials' ) ){
                    $tpl = $this->get_template_part_location( 'single-ztestimonials.php' );
                }
            }
            return $tpl;
        }

        public function get_template_part_location( $file ){
            if( file_exists( ZTESTIMONIALS_OVERRIDE_PATH_DIR . $file ) ){
                $file = ZTESTIMONIALS_OVERRIDE_PATH_DIR . $file;
            }else{
                $file = ZTESTIMONIALS_PATH . 'views/templates/' . $file;
            }
            return $file;
        }

        public function load_textdomain(){
            load_plugin_textdomain(
                'ztestimonials',
                false,
                dirname( plugin_basename( __FILE__ ) ) . '/languages/'
            );
        }

        /**
         * Activate the plugin
         */
        public static function activate(){
            update_option('rewrite_rules', '' );
        }

        /**
         * Deactivate the plugin
         */
        public static function deactivate(){
            unregister_post_type( 'ztestimonials' );
            flush_rewrite_rules();
        }

        /**
         * Uninstall the plugin
         */
        public static function uninstall(){

            delete_option( 'widget_ztestimonials' );

            $posts = get_posts(
                array(
                    'post_type' => 'ztestimonials',
                    'number_posts'  => -1,
                    'post_status'   => 'any'
                )
            );

            foreach( $posts as $post ){
                wp_delete_post( $post->ID, true );
            }
        }

    }
}

if( class_exists( 'ZTestimonials' ) ){
    // Installation and uninstallation hooks
    register_activation_hook( __FILE__, array( 'ZTestimonials', 'activate'));
    register_deactivation_hook( __FILE__, array( 'ZTestimonials', 'deactivate'));
    register_uninstall_hook( __FILE__, array( 'ZTestimonials', 'uninstall' ) );

    $ztestimonials = new ZTestimonials();
}