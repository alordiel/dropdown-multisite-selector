<?php

//general shortcode
add_shortcode( 'dms', 'dms_build_select' );
function dms_build_select() {

	$name        = false; // the name of the select's label
	$out         = ''; // the output
	$multisite   = ''; // the multisite option
	$placeholder = __( 'Select Option', 'dropdown-multisite-selector' );


	if ( get_option( 'dms_select_name' ) ) {
		$name = get_option( 'dms_select_name' );
	}

	if ( get_option( 'dms_multisite' ) ) {
		$multisite = get_option( 'dms_multisite' );
	}

	if ( get_option( 'dms_placeholder' ) ) {
		$placeholder = get_option( 'dms_placeholder' );
	}

	$out .= '<div class="dms-container">';
	if ( $name !== false ) {
		$out .= '<label for="dms-select">' . $name . '</label>';
	}
	$out .= '<select class="dms-select">';
	$out .= '<option value="">' . $placeholder . '</option>';

	if ( $multisite === 'none' ) {
		$out .= dms_none_option_selected();
	} elseif ( $multisite === 'all' ) {
		$out .= dms_show_all_network_sites();
	} elseif ( $multisite === 'usersonly' ) {
		if ( is_user_logged_in() ) {
			$out .= dms_show_sites_for_registered_users_only();
		} else {
			return false;
		}
	}


	$out .= '</select></div>';

	return $out;

}


add_shortcode( 'dms_manual', 'dms_build_select_manual' );
function dms_build_select_manual( $attributes ) {
	$output_error = '';
	$output       = '';
	$a            = shortcode_atts( array(
		'name'        => '',
		'placeholder' => 'Go to',
		'target'      => 'default',
		'options'     => array( 'url|sitename, url1|sitename1' )
	), $attributes );

	$output .= "<div class='dms-container'>";

	//Hide the label
	if ( ! empty( $a['name'] ) ) {
		$output .= "<label for='dms-select'>" . $a['name'] . '</label>';
	}

	// add class for opening in new tab
	if ( $a['target'] === 'blank' ) {
		$output .= "<select class='dms-select open-in-new-tab'>";
	} else {
		$output .= "<select class='dms-select'>";
	}

	$output .= "<option value=''>" . $a['placeholder'] . '</option>';

	//load the options for the site
	$all_sites = explode( ',', $a['options'] );
	$sites     = array();
	foreach ( $all_sites as $site ) {
		$one_site = explode( '|', $site );
		if ( count( $one_site ) === 2 ) {
			list( $url, $name ) = $one_site;
			// check if positions are not switched
			$name_is_a_link    = ( strpos( $name, 'https://' ) !== false || strpos( $name, 'http://' ) !== false );
			$url_is_not_a_link = ( strpos( $url, 'https://' ) === false && strpos( $url, 'https://' ) === false );
			if ( $name_is_a_link && $url_is_not_a_link ) {
				list( $name, $url ) = $one_site;
			}
			$sites[] = [ 'name' => trim( $name ), 'url' => trim( $url ) ];
		} else {
			$output_error .= '<p>' . __( 'You have entered wrong array of sites! They should be in format "url|sitename, url1|sitename1, ..."', 'dropdown-multisite-selector' ) . '</p>';
		}

	}
	foreach ( $sites as $site ) {
		$output .= "<option value='" . esc_url($site['url']) . "'>" . esc_html($site['name']) . '</option>';
	}

	$output .= '</select></div>';


	if ( ! empty( $output_error ) ) {
		$output = $output_error;
	}

	return $output;

}
