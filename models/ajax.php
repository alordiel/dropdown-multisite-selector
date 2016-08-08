<?php

/**
 * Update the options.
 */

add_action("wp_ajax_dms_add_fields", "update_fields");
function update_fields() {
	global $wpdb;
	$sanitizer = new DMS_VALIDATION();
	$res = $_POST;
	$name = '';
	$options = array();
	$multisite = '';
	$settings = array();
	$placeholder = '';
	$radiobuttons = array('none','all','usersonly');

	if(array_key_exists('name', $res)){
		$name = $res['name'];
		if($name==""){
			$name = false;
		}
	}

	if(array_key_exists('options', $res)){
		$options = $res['options'];
	}

	if(array_key_exists('multisite', $res)){
		$multisite = $res['multisite'];
	}

	if(array_key_exists('placeholder', $res)){
		$placeholder = $res['placeholder'];
	}

	if(array_key_exists('settings', $res)){
		$settings = $res['settings'];
	}


	//validate
	if($name){
		if (preg_match('/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i', $name)) {
			_e("This field can contain only letters.",'dropdown-multisite-selector');
			die();
		}
	}


	if($multisite){
		if (preg_match('/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i', $multisite) || !in_array($multisite, $radiobuttons)) {
			_e("Don't bug with the code, please!",'dropdown-multisite-selector');
			die();
		}
	}
	else{
		_e("Don't bug with the code, please!",'dropdown-multisite-selector');
		die();
	}

	if ( $options ) {
		if ( !is_array($options) ) {
			_e("Please make sure that you have entered all fields correctly.",'dropdown-multisite-selector');
			die();
		}
	}
	else{
		_e("Please enter a place tag name.",'dropdown-multisite-selector');
		die();
	}

	//validate settings (only true or false)
	foreach ($settings as $setting) {

	 if ( $setting != "true" && $setting != "false" ) {
	 	_e("Don't bug with the code, please!",'dropdown-multisite-selector');
		die();
	 }
	}

	//sanitaze
	if($name !== false) {
		$name = $sanitizer->clear_input($name);
	}

	$options = $sanitizer->clear_input($options);
	$multisite = $sanitizer->clear_input($multisite);
	$placeholder = $sanitizer->clear_input($placeholder);

	//uploade in db
	if ( get_option( 'dms_select_name' ) !=  $name ) {
		if(!update_option('dms_select_name' , $name )) {
			_e("Something went worng with updating your settings.",'dropdown-multisite-selector');
			die();
		}
	}

	if ( get_option( 'dms_options' ) != $options ) {
		if(!update_option('dms_options' , $options )) {
		   _e("Something went worng with updating your settings.",'dropdown-multisite-selector');
			die();
		}
	}

	if ( get_option( 'dms_multisite' ) != $multisite ) {
		if(!update_option('dms_multisite' , $multisite )) {
		   _e("Something went worng with updating your settings.",'dropdown-multisite-selector');
			die();
		}
	}

	if ( get_option(  'dms_placeholder' ) != $placeholder ) {
		if(!update_option( 'dms_placeholder' , $placeholder )) {
		   _e("Something went worng with updating your settings.",'dropdown-multisite-selector');
			die();
		}
	}

	if ( get_option( 'dms_settings' ) != $settings ) {
		if(!update_option('dms_settings' , $settings )) {
		   _e("Something went worng with updating your settings.",'dropdown-multisite-selector');
			die();
		}
	}

	echo true;
	die();
}



function dms_update_styles() {

	global $wpdb;

	$sanitizer = new DMS_VALIDATION();
	$res = $_POST;

	$styles = '';
	$option = array();

	//Get option from Post
	if(array_key_exists('styles', $res)){
		$styles = $res['styles'];
	}

	if (array_key_exists('option', $res)){
		$option = $res['option'];
	}

	// validation
	if ($option != "ui" && $option != "custom" && $option != "default") {
		_e("Please don't play with the code!",'dropdown-multisite-selector');
		die();
	}

	if ($option == "ui" && is_array($styles)) {

		// color validation
		$color_validator = '/^#[a-f0-9]/i';
		if ( !preg_match ($color_validator, $styles['labelFontColor']) ||
			!preg_match ($color_validator, $styles['borderColor']) ||
			!preg_match ($color_validator, $styles['selectFontColor']) ||
			!preg_match ($color_validator, $styles['selectBackgroundColor'])){
		_e("Please don't play with the colors!",'dropdown-multisite-selector');
		die();
		}

		//number validation
		if ( !is_numeric($styles['labelFontSize']) || !is_numeric($styles['borderSize']) || !is_numeric($styles['borderRadiusTop']) || !is_numeric($styles['borderRadiusRight']) || !is_numeric($styles['borderRadiusBottom']) || !is_numeric($styles['borderRadiusLeft']) || !is_numeric($styles['selectFontSize']) ) {
			_e("Please don't play with the Numbers!",'dropdown-multisite-selector');
			die();
		}

		//width
		if ( $styles['selectWidth'] != 'auto' && !is_numeric($styles['selectWidth'])) {
			_e("Please don't play with the width!",'dropdown-multisite-selector');
			die();
		}

	}


	//update options if any changes
	if ( get_option( 'dms_styles' ) != $styles ) {
		if(!update_option('dms_styles' , $styles )) {
		   _e("Something went worng with updating your settings.",'dropdown-multisite-selector');
			die();
		}
	}

	if ( get_option('dms_style_option' ) != $option ) {
		if (!update_option('dms_style_option' , $option )) {
		   _e("Something went worng with updating your settings.",'dropdown-multisite-selector');
			die();
		}
	}


	if ( $res['option'] == 'ui' || $res['option'] == 'custom'){
		generate_custom_css($res['styles']); //generate the custom.css
	} else {
		file_put_contents( PLUGINS_PATH . 'assets/css/custom.css', " ", LOCK_EX); // clear the file
	}

	echo true;
	die();
}

add_action("wp_ajax_dms_delete_all", "dms_delete_all");
function dms_delete_all() {


}
