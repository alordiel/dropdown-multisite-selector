<?php

/**
 * Update the options.
 */

add_action("wp_ajax_dms_add_fields", "update_fields");
function update_fields() {
	
	global $wpdb;
	$sanitizer 		= new DMS_VALIDATION();
	$name 			= $_POST['name'];
	$options 		= $_POST['options'];
	$multisite 		= $_POST['multisite'];
	$settings 		= $_POST['settings'];
	$placeholder 	= $r_POSTes['placeholder'];
	$radiobuttons 	= array('none','all','usersonly');


	if( $name == "" ){

		$name = false;

	}

	//validate
	if ( $name && preg_match('/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i', $name)) {

		_e("This field can contain only letters.",'dropdown-multisite-selector');
		die();

	}

	if ( $multisite ){

		if ( !in_array($multisite, $radiobuttons)) {

			_e("Don't bug with the code, please!",'dropdown-multisite-selector');
			die();

		}
	}
	else {

		_e("Don't bug with the code, please!",'dropdown-multisite-selector');
		die();

	}

	if ( $options ) {
		
		if ( !is_array($options)) {

			_e("Please make sure that you have entered all fields correctly.",'dropdown-multisite-selector');
			die();

		}
	}
	else {

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
	if( $name !== false ) {

		$name = $sanitizer->clear_input($name);

	}

	$options 	= $sanitizer->clear_input($options);
	$multisite 	= $sanitizer->clear_input($multisite);
	$placeholder= $sanitizer->clear_input($placeholder);

	//uploade in db
	update_option( 'dms_select_name' , $name );
	update_option( 'dms_options', $options );
	update_option( 'dms_multisite', $multisite );
	update_option( 'dms_settings', $settings );
	update_option( 'dms_placeholder', $placeholder );
	
	echo true;
	die();
}