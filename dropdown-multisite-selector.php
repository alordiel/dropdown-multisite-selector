<?php
/**
 *
 * Plugin Name:       Dropdown multisite selector
 * Plugin URI:        https://github.com/alordiel/dropdown-multisite
 * Description:       Allows you to configure a select option of redirecting to different webpages.
 * Version:           0.9
 * Author:            alordiel
 * Author URI:        http://profiles.wordpress.org/alordiel
 * Text Domain:       dropdown-multisite-selector
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages/
 * GitHub Plugin URI: https://github.com/alordiel/dropdown-multisite
 */

/*  Copyright 2015  Alexander Vasilev  (email : alexander.dorn@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'PLUGIN_PATH_DMS', plugin_dir_path( __FILE__ ) );

/**
 * Register textdomain.
 */
add_action('plugins_loaded', 'dropdown_multisite_meta_init');
function dropdown_multisite_meta_init() {

	load_plugin_textdomain( 'dropdown-multisite-selector', false, dirname( plugin_basename( __FILE__ ) ) );

}

/**
 * Register style sheet and scripts for the admin area.
 */
add_action( 'admin_enqueue_scripts', 'dms_admin_styles_script' );
function dms_admin_styles_script() {

	wp_enqueue_style( 'dms-style', plugins_url('assets/css/dms-admin.css', __FILE__));
	wp_enqueue_script( 'dms-functions', plugins_url('assets/js/dms-admin.js', __FILE__) , array(), false, true );

	//Adding localization for script string
	$translation_array = array(
		'tag_err' => __('Please enter a select tag name.','dropdown-multisite-selector'),
		'let_err' => __('This field can contain only letters.','dropdown-multisite-selector'),
		'emt_err' => __('All Names and URL fields should be filled.','dropdown-multisite-selector'),
		'dup_err' => __('One of your Option names is written twice or more.','dropdown-multisite-selector'),
		'suc_err' => __('Your settings were saved successfully.','dropdown-multisite-selector'),
		'err_err' => __('Something went wrong!Please check your data and try again.','dropdown-multisite-selector'),
		'confirm' => __('Are you sure you want to reset all your styles and settings from the database? Once you confirm this - there is no way back... well, almost no way... ','dropdown-multisite-selector'),
		'refresh' => __('Please refresh the page and try again.','dropdown-multisite-selector'),
		'style_err'=> __('Please include only styles, no need of \<style\> tag.','dropdown-multisite-selector'),
		'style_numbers' => __('Please make sure that only numbers are used for the numeric fields!', 'dropdown-multisite-selector'),
		'style_colors' => __('Please make sure that only hex code is used for colors!', 'dropdown-multisite-selector')
	);
	wp_localize_script( 'dms-functions', 'trans_str', $translation_array );
	wp_localize_script( 'dms-functions', 'dms_ajax_vars', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

/**
 * Register style sheet and scripts for the front.
 */
add_action( 'wp_enqueue_scripts', 'dms_front_styles_script' );
function dms_front_styles_script(){

	wp_enqueue_script( 'dms-functions-front', PLUGIN_PATH_DMS.'/assets/js/dms-front.js', array(), '1.0.0', true );
	wp_enqueue_style( 'dms-style-front', PLUGIN_PATH_DMS.'/assets/css/dms-front.css' );
	wp_enqueue_style( 'custom-css', PLUGIN_PATH_DMS .'/assets/css/custom.css', 'style');

}

/**
 * Register submenu in Settings.
 */
add_action('admin_menu','dms_register_submenu');
function dms_register_submenu() {

	add_submenu_page( 'options-general.php', 'Dropdown Multisite Selector', 'Dropdown Multisite', 'manage_options', 'dropdown-multisite-selector', 'dms_admin' );

}

/**
 * Check if all settings are in one array and one option
 */
add_action('plugins_loaded', 'dms_check_for_one_option_for_all');
function dms_check_for_one_option_for_all() {
	
	$all_options = get_option('dms_settings' );
	
	if(!$all_options){
		
		$name 			= get_option('dms_select_name');
		$placeholder 	= get_option('dms_placeholder');
		$multisite 		= get_option('dms_multisite');
		$list_of_sites 	= get_option('dms_options');
		$all_options_arr= array();

		if ( $name ) {

			$all_options_arr['select_label'] = $name;
			delete_option( 'dms_select_name' );

		} else {

			$all_options_arr['select_placeholder'] = __('Select option','dropdown-multisite-selector');

		}

		if ( $placeholder ) {

			$all_options_arr['select_placeholder'] = $placeholder;
			delete_option( 'dms_placeholder' );

		} else {

			$all_options_arr['dms_placeholder'] = __('Options','dropdown-multisite-selector');

		}

		if ( $multisite ) {

			$all_options_arr['multisite_settings']= $multisite;
			delete_option( 'dms_multisite' );

		} else {

			$all_options_arr['dms_multisite'] = 'none';

		}

		if ( $list_of_sites ) {

			$all_options_arr['list_of_sites']=$list_of_sites;
			delete_option( 'dms_options' );

		} else {

			$all_options_arr['list_of_sites'] = array();

		}

		$all_options_arr['target_blank'] 		= '1';
		$all_options_arr['show_label'] 			= '1';
		$all_options_arr['show_current_site']	= '0';
		$all_options_arr['alphabetic_order'] 	= '0';

		add_option('dms_settings-options', $all_options_arr);
	}
}

/**
 * Building the admin part.
 */
function dms_admin() {

	$output = "";
	$output = include_once( PLUGIN_PATH_DMS . '/inc/dms-admin.php');

	return $output;

}

/**
 * Add Classes & Widgets & Shortcodes & Menu & Ajax calls
 */

include_once ( PLUGIN_PATH_DMS . '/inc/class.validation.php');
include_once ( PLUGIN_PATH_DMS . '/inc/class.front-end.php');
include_once ( PLUGIN_PATH_DMS . '/inc/shortcode.php');
include_once ( PLUGIN_PATH_DMS . '/inc/widget.php');
include_once ( PLUGIN_PATH_DMS . '/inc/admin-menu.php');
include_once ( PLUGIN_PATH_DMS . '/inc/ajax.php');
