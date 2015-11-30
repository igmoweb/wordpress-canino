<?php
/**
Plugin Name: wp slideshow posts
Plugin URI: http://temasphp.com/wp-slideshow-posts/
Description: Slideshow for wordpress posts with images, titles and summary.
Version: 1.1.2
Author: Marcio Cezar
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

//Activate plugin slideshow picture post.
register_activation_hook( __FILE__, 'WPSP_Activate' );

function WPSP_Activate() {
		WPSP_Add_Option_Menu();
		WPSP_DefaultSettings();
}

if ( is_admin() ) {
	add_action('admin_menu', 'WPSP_Add_Option_Menu');
	add_action('admin_menu', 'WPSP_DefaultSettings');
}

//Get options database.
function WPSP_GetOptions(){
	$options = array();
	$suboptions = explode("~",get_option('wp_slideshow_posts_options'));
	for($x=0; $x < count($suboptions); $x++){
		$temp = explode(":",$suboptions[$x]);
		$options[$temp[0]] = $temp[1];
	}
	return $options;
}

//Adds the plugin's menu options page.
function WPSP_Add_Option_Menu() {
		add_submenu_page('options-general.php', 'WP Slideshow Posts', 'WP Slideshow Posts', 8, __FILE__, 'WPSP_Options_Page');
}

//Call paste css style and JavaScript.
function WPSP_scripts_basic()  { 
	$sc_options = WPSP_GetOptions();
    wp_register_script( 'jquery.easing', plugins_url( '/js/jquery.easing.1.3.js', __FILE__ ) ); 
    wp_register_script( 'jquery.cycle', plugins_url( '/js/jquery.cycle.all.js', __FILE__ ) ); 
    wp_register_script( 'control.slider', plugins_url( '/js/control.slider.js', __FILE__ ) ); 
    wp_register_script( 'control.breakingnews', plugins_url( '/js/control-breakingnews.js', __FILE__ ) );
 
    wp_register_style( 'style-slideshow', plugins_url( '/css/style-slideshow.css', __FILE__ ), array(), '0.1', 'all' );
    wp_register_style( 'style-breaking-news', plugins_url( '/css/style-breaking-news.css', __FILE__ ), array(), '0.1', 'all' ); 

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery.easing' );  
    wp_enqueue_script( 'jquery.cycle' );  
    wp_enqueue_script( 'control.slider' );  
    wp_enqueue_script( 'control.breakingnews' );
  
    wp_enqueue_style( 'style-slideshow' );  
    wp_enqueue_style( 'style-breaking-news' );  

wp_localize_script( 'control.breakingnews', 'breakingnews_params', array( 'time' => $sc_options['transition_time'] ) );

wp_localize_script( 'control.slider', 'slider_params', array( 'time' => $sc_options['transition_time'] ) );
 
}
add_action( 'wp_enqueue_scripts', 'WPSP_scripts_basic' );

function wp_enqueue_color_picker( ) {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script(
            'iris',
            admin_url( 'js/iris.min.js' ),
            array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
            false,
            1
        );
	wp_enqueue_script( 'wp-color-picker-script', plugins_url('/js/iris-init.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	wp_register_script( 'mwscript', plugins_url( '/js/mwscript.js', __FILE__ ) );  

	wp_enqueue_script( 'mwscript' );
}
add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );

//Adds settings link on the plugin administration page.
function WPSP_Add_Settings_Link($links) {
	$settings_link = '<a href="options-general.php?page=wp-slideshow-posts/wp_slideshow_posts.php">Settings</a>'; 
	array_unshift($links, $settings_link); 
	return $links;
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'WPSP_Add_Settings_Link' );

//Set default option plugin.
function WPSP_DefaultSettings() {
	if( !get_option('wp_slideshow_posts_options') ) {
		add_option('wp_slideshow_posts_options', 'transition_time:5000~get_braeking:true~slider_color:#000000~text_color:#ffffff~link_color:#666666~get_slider:true~bullets_slider:1~number_word:100~number_news:3~number_post:3~posts_news:1~posts_slider:1~posts_id:0~category_slider:Choose a category');
	}
}

function wpsp_Slideshow($item_toggle = null){
	$sc_options = WPSP_GetOptions();
	if( $sc_options['get_slider']=='true' ) {
		wp_slideshow_posts($item_toggle);
	}
}

function WPSP_Shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'display' => '1,1,1,1',
	), $atts ) );
	ob_start();
	wp_slideshow_posts( $display );
	$output_string = ob_get_contents();
	ob_end_clean();
	return force_balance_tags( $output_string );
}
add_shortcode('slideshow-wpsp', 'WPSP_Shortcode');


require_once('wpsp_news.php');
require_once('wpsp_slideshow.php');
require_once('wpsp_options.php');

?>