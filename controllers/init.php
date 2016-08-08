<?php
/**
 * Check the current version and add
 */
if ( !dms_version() ) {
	dms_activation();
}

function dms_version(){
    $version = get_option( 'dms_version' );
    return version_compare($version, DMS_VERSION, '=') ? true : false;
}

register_activation_hook(__FILE__, 'dms_activation');
function dms_activation() {
	$version = get_option( 'dmS_versiOn' );
	if( version_compare($version, '0.5.0', '<')) {

	  if(!get_option('dms_multisite')){
    		update_option('dms_multisite', 'all');
		}

		if(!get_option('dms_multisite')){
		   	update_option('dms_multisite', 'none');
		}

		if (!get_option('dms_style_option')) {
			update_option('dms_style_option', 'default');
		}

		if (!get_option('dms_styles')) {
			update_option('dms_styles', 'default');
		}
	}
	update_option( 'dms_version', DMS_VERSION );
	return DMS_VERSION;
}

add_action('activated_plugin', 'dms_activation_error');
function dms_activation_error() {
    file_put_contents( plugin_dir_path(__FILE__) . '/error_activation.html', ob_get_contents());
}

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
add_action( 'admin_enqueue_scripts', 'admin_styles_script' );
function admin_styles_script() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'dms-style', plugins_url() .'/dropdown-multisite-selector/assets/css/dms-admin.css' );
	wp_enqueue_script( 'dms-functions', plugins_url() .'/dropdown-multisite-selector/assets/js/dms-admin.js', array( 'wp-color-picker'), false, true );

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
add_action( 'wp_enqueue_scripts', 'front_styles_script' );
function front_styles_script( ){
	wp_enqueue_script( 'dms-functions-front', '/wp-content/plugins/dropdown-multisite-selector/assets/js/dms-front.js', array(), '1.0.0', true );
	wp_enqueue_style( 'dms-style-front', '/wp-content/plugins/dropdown-multisite-selector/assets/css/dms-front.css' );
	wp_enqueue_style( 'custom-css', '/wp-content/plugins/dropdown-multisite-selector/assets/css/custom.css', 'style');
}

/**
 * Register submenu in Settings.
 */
add_action('admin_menu','register_submenu');
function register_submenu() {
	add_submenu_page( 'options-general.php', 'Dropdown Multisite Selector', 'Dropdown Multisite', 'manage_options', 'dropdown-multisite-selector', 'dms_admin' );
}


/**
 * Function for generating the dinamically a static css file ;)
 */
function generate_custom_css($data) {

	if ( !is_writable(PLUGINS_PATH . 'assets/css/custom.css') ) {
		echo __('You don\'t have permissions to write in custom.css file. Please contact your site administrator.','dropdown-multisite-selector');
		die();
	}

	ob_start(); // Capture all output (output buffering)

		require( PLUGINS_PATH . 'models/css.php'); // Generate CSS
		$css = ob_get_clean(); // Get generated CSS (output buffering)

	ob_end_flush(); // Ends the buffering (just in case)

	file_put_contents( PLUGINS_PATH . 'assets/css/custom.css', $css, LOCK_EX); // Save it
}


/**
 * Add Classes & Widgets & Shortcodes & Menu & Ajax calls
 */

include_once ( PLUGINS_PATH . 'models/class.validation.php');
include_once ( PLUGINS_PATH . 'models/class.front-end.php');
include_once ( PLUGINS_PATH . 'controllers/shortcode.php');
include_once ( PLUGINS_PATH . 'controllers/widget.php');
include_once ( PLUGINS_PATH . 'controllers/admin-menu.php');
include_once ( PLUGINS_PATH . 'models/ajax.php');


/**
 * Building the admin part.
 */
function dms_admin() {
	$output = "";
	$output = include_once( PLUGINS_PATH . 'models/dms-admin.php');

	return $output;
}
