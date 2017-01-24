<?php

/**
 * Register textdomain.
 */
add_action('plugins_loaded', 'dropdown_multisite_meta_init');
function dropdown_multisite_meta_init() {
	load_plugin_textdomain( 'dropdown-multisite-selector', false, DMS_PLUGINS_DIR_ABS . platformSlashes('/languages' ) ); 
}


/**
 * Register style sheet and scripts for the admin area.
 */
add_action( 'admin_enqueue_scripts', 'admin_styles_script' );
function admin_styles_script() {
	wp_enqueue_script( 'dms-admin-js', DMS_PLUGINS_DIR_REL .'/assets/js/dms-admin.js'  );
	wp_enqueue_style( 'dms-admin-css', DMS_PLUGINS_DIR_REL . '/assets/css/dms-admin.css' );
	
	//Adding localization for script string
	$translation_array = array( 
		'tag_err' => __('Please enter a select tag name.'),
		'let_err' => __('This field can contain only letters.'),
		'emt_err' => __('All Names and URL fields should be filled.'),
		'dup_err' => __('One of your Option names is written twice or more.'),
		'suc_err' => __('Your settings were saved successfully.'),
		'err_err' => __('Something went wrong!Please check your data and try again.')
	);
	wp_localize_script( 'dms-admin-js', 'trans_str', $translation_array );
	wp_localize_script( 'dms-admin-js', 'dms_ajax_vars', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
}

/**
 * Register style sheet and scripts for the front.
 */
add_action( 'wp_enqueue_scripts', 'front_styles_script' );
function front_styles_script(){
	wp_enqueue_script( 'dms-js-front', DMS_PLUGINS_DIR_REL . '/assets/js/dms-front.js' , array(), '1.0.0', true );
	wp_enqueue_style( 'dms-style-front', DMS_PLUGINS_DIR_REL . '/assets/css/dms-front.css' );
}

/**
 * Register submenu in Settings.
 */
add_action('admin_menu','register_submenu');
function register_submenu(){
	
	add_submenu_page( 'options-general.php', 'Dropdown Multisite Selector', 'Dropdown Multisite', 'manage_options', 'dropdown-multisite-selector', 'dms_admin' );

}

/**
 * Building the admin part.
 */ 
function dms_admin(){

	$out = include_once DMS_PLUGINS_DIR_ABS . platformSlashes('/templates/dms-admin.php');

	return $out;
}