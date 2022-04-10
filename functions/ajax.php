<?php
//ajax for saving settings in admin panel
add_action( 'wp_ajax_dms_add_fields', 'dms_ajax_update_fields' );
function dms_ajax_update_fields() {

	check_ajax_referer( 'dms_nonce_секюрити', 'security' );

	$name            = '';
	$options         = '';
	$multisite       = 'none';
	$sorting         = 'none';
	$placeholder     = '';
	$radio_buttons    = array( 'none', 'all', 'usersonly' );
	$sorting_options = array( 'none', 'lastfirst', 'alphabetic', 'numeric' );

	if ( array_key_exists( 'name', $_POST ) ) {
		$name = ! empty( $_POST['name'] ) ? $_POST['name'] : false;
	}

	if ( array_key_exists( 'options', $_POST ) ) {
		$options = $_POST['options'];
	}

	if ( array_key_exists( 'multisite', $_POST ) ) {
		$multisite = $_POST['multisite'];
	}

	if ( array_key_exists( 'placeholder', $_POST ) ) {
		$placeholder = $_POST['placeholder'];
	}

	if ( array_key_exists( 'sorting', $_POST ) ) {
		$sorting = $_POST['sorting'];
	}

	//validate
	if ( $name ) {
		if ( preg_match( '/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i', $name ) ) {
			_e( 'This field can contain only letters.', 'dropdown-multisite-selector' );
			die();
		}
	}


	if ( ! in_array( $multisite, $radio_buttons, true ) ) {
		_e( "Don't bug with the code, please!", 'dropdown-multisite-selector' );
		die();
	}

	if ( ! in_array( $sorting, $sorting_options, true ) ) {
		_e( "Don't bug with the code, please!", 'dropdown-multisite-selector' );
		die();
	}

	if ( $options ) {
		if ( ! is_array( $options ) ) {
			_e( 'Please make sure that you have entered all fields correctly.', 'dropdown-multisite-selector' );
			die();
		}
	} elseif ( ! $options && $multisite === 'none' ) {
		_e( 'Please enter a place tag name.', 'dropdown-multisite-selector' );
		die();
	}

	if ( $name !== false ) {
		$name = dms_clean_up_user_input( dms_sanitize_input( $name ) );
	}
	$options     = dms_clean_up_user_input( dms_sanitize_input( $options ) );
	$placeholder = dms_clean_up_user_input( dms_sanitize_input( htmlspecialchars( $placeholder ) ) );


	if ( get_option( 'dms_select_name' ) != $name ) {
		if ( ! update_option( 'dms_select_name', $name ) ) {
			_e( 'Something went wrong with updating your settings.', 'dropdown-multisite-selector' );
			die();
		}
	}

	if ( $multisite === 'none' &&  get_option( 'dms_options' ) != $options  ) {
		if ( ! update_option( 'dms_options', $options ) ) {
			_e( 'Something went wrong with updating your settings.', 'dropdown-multisite-selector' );
			die();
		}
	}

	if ( get_option( 'dms_multisite' ) != $multisite ) {
		if ( ! update_option( 'dms_multisite', $multisite ) ) {
			_e( 'Something went wrong with updating your settings.', 'dropdown-multisite-selector' );
			die();
		}
	}

	if ( get_option( 'dms_sorting' ) != $sorting ) {
		if ( ! update_option( 'dms_sorting', $sorting ) ) {
			_e( 'Something went wrong with updating your settings.', 'dropdown-multisite-selector' );
			die();
		}
	}

	if ( get_option( 'dms_placeholder' ) != $placeholder ) {
		if ( ! update_option( 'dms_placeholder', $placeholder ) ) {
			_e( 'Something went wrong with updating your settings.', 'dropdown-multisite-selector' );
			die();
		}
	}

	echo true;
	wp_die();
}
